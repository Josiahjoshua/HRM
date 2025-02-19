<?php

namespace App\Http\Controllers;

use App\Models\PettyCash;
use App\Models\Bank;
use App\Models\BankIn;
use App\Models\BankOut;
use App\Models\Cash;
use App\Models\BalanceSheetItem;
use App\Models\BalanceSheet;
use App\Models\Asset;
use App\Models\Assetlist;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use Spatie\Pdf\Structure;
use Dompdf\Options;

class BalanceSheetController extends Controller
{
  public function index()
  {
    $balanceSheet = BalanceSheet::all();
    return view('balanceSheet.category', compact('balanceSheet'));
  }


  
  public function store(Request $request)
  {
    $request->validate([
      'category_name' => 'required',
      'type' =>'required'

    ]);

    $balanceSheet = new BalanceSheet();
    $balanceSheet->category_name = request('category_name');
    $balanceSheet->type = request('type');
    $balanceSheet->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $balanceSheet = BalanceSheet::findOrFail($id);
    $balanceSheet->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $balanceSheet = BalanceSheet::findOrFail($id);
    return view('balanceSheet.editCategory', compact('balanceSheet'));
  }

  public function update(Request $request, $id)
  {

    $request->validate([
      'category_name' => 'required',
      'type' =>'required'


    ]);

     $balanceSheet = BalanceSheet::find($id);
    $balanceSheet->category_name = request('category_name');
    $balanceSheet->type = request('type');
    $balanceSheet->save();

    Alert::success('Success!', 'Successfully updated');
    return redirect()->route('balanceSheet.index');
  }

public function show($id)
  {
      $balanceSheet = BalanceSheet::find($id);
  
      $balanceSheetItem = [];

      if ($balanceSheet->category_name == 'Current Assets') {
          // Fetch available bank balance, available cash, and available petty cash
          $balanceSheetItem[] = ['item' => 'bank', 'amount' => $this->getAvailableBankBalance()];
          $balanceSheetItem[] = ['item' => 'cash', 'amount' => $this->getAvailableCashBalance()];
          $balanceSheetItem[] = ['item' => 'pettycash', 'amount' => $this->getAvailablePettyCashBalance()];
           
      } elseif ($balanceSheet->category_name == 'Fixed Assets') {
          // Fetch asset categories from the asset table and accumulate depreciation
          $assetCategories = DB::table('asset')
          ->select('category_type','asset.id',
          DB::raw('SUM(assetlist.price) as total_price')
        )
        ->join('assetlist','asset.id', '=', 'assetlist.asset_id')
        ->groupBy('category_type','asset.id')
        ->get();

        foreach($assetCategories as $category) {
            $balanceSheetItem[] = ['item' => $category->category_type, 'amount' => $category->total_price];
        }

        $balanceSheetItem[] = ['item' => 'Accumulated Depreciation', 'amount' => $this->getAccumulatedDepreciation()];
    
     } else {
    $balanceSheetItem = DB::table('balance_sheet_details')
        ->select('id', 'item', 'amount')
        ->where('category_id', $id)
        ->groupBy('id', 'item', 'amount')
        ->get()
        ->map(function ($item) {
            return ['id' => $item->id, 'item' => $item->item, 'amount' => $item->amount];
        })
        ->toArray();
}
      return view('balanceSheet.index', compact('balanceSheetItem', 'balanceSheet'));
}

  private function getAvailableBankBalance()
  {

    $totalBankBalance = 0;
    $banks = DB::table('bank')
    ->select('bank_name', 'bank.date', 'bank.id')
    ->leftJoin('bank_in', 'bank.id', '=', 'bank_in.bank_id')
    ->leftJoin('bank_out', 'bank.id', '=', 'bank_out.bank_id')
    ->leftJoin('cash', function ($join) {
        $join->on('bank.bank_name', '=', 'cash.source_destination')
            ->where('cash.type', '=', 'expenditure');
    })
    ->leftJoin('cash as cash_income', function ($join) {
        $join->on('bank.bank_name', '=', 'cash_income.source_destination')
            ->where('cash_income.type', '=', 'income');
    })
    ->leftJoin('petty_cash', function ($join) {
        $join->on('bank.bank_name', '=', 'petty_cash.source_destination')
            ->where('petty_cash.type', '=', 'expenditure');
    })
    ->leftJoin('petty_cash as petty_cash_income', function ($join) {
        $join->on('bank.bank_name', '=', 'petty_cash_income.source_destination')
            ->where('petty_cash_income.type', '=', 'income');
    })
    ->groupBy('bank_name', 'bank.date', 'bank.id')
    ->selectRaw('SUM(IFNULL(bank_in.amount, 0)) - SUM(IFNULL(bank_out.amount, 0)) 
                + SUM(IFNULL(cash.amount, 0)) - SUM(IFNULL(cash_income.amount, 0)) 
                + SUM(IFNULL(petty_cash.amount, 0)) - SUM(IFNULL(petty_cash_income.amount, 0)) as available_amount')
    ->get();

    foreach($banks as $bank)
    {
      $balncePerBank = $bank->available_amount;
      $totalBankBalance += $balncePerBank;
    }
     return $totalBankBalance;
  }
  
  private function getAvailableCashBalance()
  {
     // Calculate sum of amount from bank_in table where source is cash
     $bankInTotal = BankIn::where('source', 'cash')->sum('amount');
   
     // Calculate sum of amount from bank_out table where destination is cash
     $bankOutTotal = BankOut::where('destination', 'cash')->sum('amount');
 
     // Calculate sum of income from cash table where source_destination is cash
     $cashIncomeTotal = Cash::where('type', 'income')->sum('amount');
 
     // Calculate sum of expenditure from cash table where source_destination is cash
     $cashExpenditureTotal = Cash::where('type', 'expenditure')->sum('amount');
 
     // Calculate cashAvailable
     $cashAvailable = ($bankOutTotal - $bankInTotal) + ($cashIncomeTotal - $cashExpenditureTotal);

     return $cashAvailable;

  }

  private function getAvailablePettyCashBalance()
  {
    // Calculate sum of amount from bank_in table where source is pettyCash
    $bankInTotal = BankIn::where('source', 'pettyCash')->sum('amount');

    // Calculate sum of amount from bank_out table where destination is pettyCash
    $bankOutTotal = BankOut::where('destination', 'pettyCash')->sum('amount');

    // Calculate sum of income from cash table where source_destination is pettyCash
    $cashIncomeTotal = Cash::where('type', 'income')->where('source_destination', 'pettyCash')->sum('amount');

    // Calculate sum of expenditure from cash table where source_destination is pettyCash
    $cashExpenditureTotal = Cash::where('type', 'expenditure')->where('source_destination', 'pettyCash')->sum('amount');

    // Calculate sum of income from pettyCash table
    $pettyCashIncomeTotal = PettyCash::where('type', 'income')->sum('amount');

    // Calculate sum of expenditure from pettyCash table
    $pettyCashExpenditureTotal = PettyCash::where('type', 'expenditure')->sum('amount');

    // Calculate pettyCashAvailable
    $pettyCashAvailable = ( $bankOutTotal - $bankInTotal ) + ( $cashExpenditureTotal - $cashIncomeTotal ) + ($pettyCashIncomeTotal - $pettyCashExpenditureTotal);

    return $pettyCashAvailable;

  }

  private function getAccumulatedDepreciation()
  {
    $totalAccumulatedDepreciation = 0;
    $assets = Assetlist::all();
    foreach ($assets as $asset)
    {
     $purchase_price = $asset->price;
     $depr_rate = $asset->depr_rate;
     $purchase_date = $asset->purchase_date;

     // Step 2: Get the current date
     $currentDate = date('Y-m-d');

     // Calculate the number of days since the purchase date
     $daysSincePurchase = floor((strtotime($currentDate) - strtotime($purchase_date)) / (60 * 60 * 24));

     //  Calculate the depreciated value based on the number of days since purchase
    
   
         $depreciatedValue = $purchase_price * ($depr_rate / 36500) * $daysSincePurchase;
         $totalAccumulatedDepreciation += $depreciatedValue;
    }

    return $totalAccumulatedDepreciation;

  }

  private function getAccumulatedDepreciationPerCategory($id)
  {
    $totalAccumulatedDepreciation = 0;
    $assets = Assetlist::where('asset_id', $id)->get();
    foreach ($assets as $asset)
    {
     $purchase_price = $asset->price;
     $depr_rate = $asset->depr_rate;
     $purchase_date = $asset->purchase_date;

     // Step 2: Get the current date
     $currentDate = date('Y-m-d');

     // Calculate the number of days since the purchase date
     $daysSincePurchase = floor((strtotime($currentDate) - strtotime($purchase_date)) / (60 * 60 * 24));

     //  Calculate the depreciated value based on the number of days since purchase
    
   
         $depreciatedValue = $purchase_price * ($depr_rate / 36500) * $daysSincePurchase;
         $totalAccumulatedDepreciation += $depreciatedValue;
    }

    return $totalAccumulatedDepreciation;

  }


  public function balancesheetreport()
{
  $typeResults = BalanceSheet::select('type')->distinct()->get();

  $types = [];
   
  foreach ($typeResults as $typeResult){
    $type = $typeResult->toArray();
        
      $categories = BalanceSheet::where('type', $type['type'])->get();
    
      $type['categories'] = [];
      $accumulatedDepreciation = 0;
    
      foreach ($categories as $category) {
          $category = $category->toArray();
          $category['items'] = [];
      
          if ($category['category_name'] == 'Current Assets') {
              $category['items'][] = ['item' => 'Bank', 'amount' => $this->getAvailableBankBalance()];
              $category['items'][] = ['item' => 'Cash', 'amount' => $this->getAvailableCashBalance()];
              $category['items'][] = ['item' => 'Petty cash', 'amount' => $this->getAvailablePettyCashBalance()];
          }
          elseif ($category['category_name'] == 'Fixed Assets') {
              $assetCategories = DB::table('asset')->select('category_type','asset.id', DB::raw('SUM(assetlist.price) as total_price'))->join('assetlist','asset.id', '=', 'assetlist.asset_id')->groupBy('category_type','asset.id')->get();
        
              foreach($assetCategories as $category_item) {
                  $accumulatedDepreciation += $this->getAccumulatedDepreciationPerCategory($category_item->id);
                  $category['items'][] = ['item' => $category_item->category_type, 'amount' => $category_item->total_price ];            
              }
              $category['items'][] = ['item' => 'Accumulated Depreciation', 'amount' => $this->getAccumulatedDepreciation()];
          }
          else {
              $items = DB::table('balance_sheet_details')->select('id', 'item', 'amount')->where('category_id', $category['id'])->groupBy('id', 'item', 'amount')->get();
              foreach($items as $item) {
                  $category['items'][]  = ['id' => $item->id, 'item' => $item->item, 'amount' => $item->amount];
              }
          }
  
          $category['totalPerCategory'] = array_sum(array_column($category['items'], 'amount'));

          if ($category['category_name'] == 'Fixed Assets') {
            $category['totalPerCategory'] -= (2 * $accumulatedDepreciation);
          }
          $type['categories'][] = $category;
     
      }
  
      $type['totalPerType'] = array_sum(array_map(function($category) {
        return $category['totalPerCategory'];
    }, $type['categories']));
   
      array_push($types, $type);
  }


    $imagePath = public_path('/dist/img/pejunlogo2.png');

    $fontPath = storage_path('fonts/Roboto-Regular.ttf');

    $pdf = new PDF(
        app('dompdf'),
        app('config'), 
        app('files'),
        app('view')
    );

    $pdf->loadView('balanceSheet.balanceSheetReport', compact('types','imagePath'));
    $pdf->getDomPDF()->getOptions()->setFontDir($fontPath);
    $pdf->getDomPDF()->getOptions()->setDefaultFont('Roboto-Regular');
    $pdf->setPaper('A4', 'portrait');
    $pdf->setWarnings(false);

    $options = new Options();
    $options->set('isPhpEnabled', true); // Enable PHP processing in your HTML
    $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parsing
    $options->set('isRemoteEnabled', true); // Allow loading external stylesheets

    return $pdf->stream('balancesheet.pdf');

}




  // public function balancesheetreport()
  // {
  //     // Retrieve all types from the balance_sheet table
  //     $types = BalanceSheet::select('type')->distinct()->get();
  
  //     // Iterate through each type to fetch related categories and items
  //     foreach ($types as $type) {
  //         $type->categories = BalanceSheet::where('type', $type->type)->get();
  
  //         // Iterate through each category to fetch related items
  //         foreach ($type->categories as $category) {
  //             $category->items = BalanceSheetItem::where('category_id', $category->id)->get();
  //             $category->totalPerCategory = $category->items->sum('amount');
  //         }
  
  //         // Calculate total amount for each type
  //         $type->totalPerType = $type->categories->sum('totalPerCategory');
  //     }

      
  //   $imagePath = public_path('/dist/img/pejunlogo2.png');

  //   $fontPath = storage_path('fonts/Roboto-Regular.ttf');


  //   // Create an instance of the PDF class with the required arguments
  //   $pdf = new PDF(
  //     app('dompdf'), // You may need to adjust this if 'dompdf' is not the correct service name
  //     app('config'), // Create an instance of the config repository
  //     app('files'), // Create an instance of the filesystem
  //     app('view') // The name of your view
  //   );

  //   $pdf->loadView('balanceSheet.balanceSheetReport', compact('types','imagePath'));
  //   $pdf->getDomPDF()->getOptions()->setFontDir($fontPath);
  //   $pdf->getDomPDF()->getOptions()->setDefaultFont('Roboto-Regular');
  //   $pdf->setPaper('A4', 'portrait');
  //   $pdf->setWarnings(false);

  //   $options = new Options();
  //   $options->set('isPhpEnabled', true); // Enable PHP processing in your HTML
  //   $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parsing
  //   $options->set('isRemoteEnabled', true); // Allow loading external stylesheets


  //   return $pdf->stream('balancesheet.pdf');

  // }

  


}
