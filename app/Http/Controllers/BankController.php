<?php

namespace App\Http\Controllers;

use App\Models\PettyCash;
use App\Models\Bank;
use App\Models\BankIn;
use App\Models\BankOut;
use App\Models\Cash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
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
    
        return view('balanceSheet.bank.index', compact('banks'));
    }
    

       public function show($id)
    {
        $bank = Bank::find($id);
        
        return view('balanceSheet.bank.show', compact('bank', ));
    }

   
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bank_name' => 'required',
            'date' => 'required|date',
        ]);

        $product = new Bank();
        $product->bank_name = $request->input('bank_name');
        $product->date = $request->input('date');
        $product->save();
        Alert::success('Successfully saved!', 'success');
        return back();
    }
    public function destroy($id)
    {
        $product = Bank::findOrFail($id);
        $product->delete();
        Alert::success('Successfully deleted!', 'success');
        return back();
    }

    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('balanceSheet.bank.edit', ['bank' => $bank, ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'bank_name' => 'required',
            'date' => 'required',
        ]);

        

        $batch = Bank::findorFail($id);
       
        $batch->bank_name = $request->input('bank_name');
        $batch->date = $request->input('date');
        $batch->save();
       
        Alert::success('Successfully updated!', 'success');
        return back();
    }

    public function bankIn($id)
    {
        $bank = Bank::find($id);
    
        // Retrieve bank-in transactions
        $bankIn = BankIn::where('bank_id', $bank->id)->get();
    
        // Retrieve cash transactions where source_destination equals $bank->bank_name and type equals expenditure
        $cashExpenditure = Cash::where('source_destination', $bank->bank_name)
                                ->where('type', 'expenditure')
                                ->get();
    
        // Retrieve petty cash transactions where source_destination equals $bank->bank_name and type equals expenditure
        $pettyCashExpenditure = PettyCash::where('source_destination', $bank->bank_name)
                                            ->where('type', 'expenditure')
                                            ->get();
    
        // Merge all transactions into a single collection
        $transactions = collect([$bankIn, $cashExpenditure, $pettyCashExpenditure])->flatten()->sortBy('date');
    
        $banks = Bank::select('bank_name', 'id')->orderBy('bank_name')->get();
        
        return view('balanceSheet.bank.bankIn', compact('transactions', 'banks', 'bank'));
    }
    

    public function bankOut($id)
    {
        $bank = Bank::find($id);
        $bankOut = BankOut::where('bank_id',$bank->id)->get();
        $banks = Bank::select('bank_name','id')->orderBy('bank_name')->get();
        return view('balanceSheet.bank.bankOut', compact('bankOut','banks','bank'));
    }

    public function bankInStore(Request $request)
    {
       $validatedData = $request->validate([
            'amount' => 'required',
            'date' => 'required|date',
            'source' => 'required',
            'otherSource' => 'required_if:source,other',
            'bank_id' => 'required',
        ]);

        $product = new BankIn();
        $product->bank_id = $request->input('bank_id');
        $product->date = $request->input('date');
        $product->source = $request->input('source');
        $product->otherSource = $request->input('otherSource');
        $product->amount = $request->input('amount');
        $product->save();

        Alert::success('Successfully saved!', 'success');

        return back();
    }

    public function bankOutStore(Request $request)
    {

        $validatedData = $request->validate([
            'amount' => 'required',
            'date' => 'required|date',
            'destination' => 'required',
            'bank_id' => 'required',
            'otherSource' => 'required_if:source,other',
         
        ]);

        $product = new BankOut();
        $product->bank_id = $request->input('bank_id');
        $product->date = $request->input('date');
        $product->destination = $request->input('destination');
        $product->othersource = $request->input('othersource');
        $product->amount = $request->input('amount');
        $product->save();
        Alert::success('Successfully saved!', 'success');
        return back();
    }


    public function bankInUpdate(Request $request, $id)
    {
       
        $validatedData = $request->validate([
            'amount' => 'required',
            'date' => 'required|date',
            'source' => 'required',
            'otherSource' => 'required_if:source,other',
         
        ]);
 

        $product = BankIn::find($id);
        $product->date = $request->input('date');
        $product->amount = $request->input('amount');
        $product->source = $request->input('source');
        $product->otherSource = $request->input('otherSource');
        $product->save();
        Alert::success('Successfully Updated!', 'success');
        return back();
    }

    public function bankOutUpdate(Request $request, $id)
    {
       
        $validatedData = $request->validate([
            'amount' => 'required',
            'destination' => 'required',
            'date' => 'required|date',
            'otherSource' => 'required_if:destination,other',
         
        ]);

        $product = BankOut::find($id);
        $product->date = $request->input('date');
        $product->amount = $request->input('amount');
        $product->destination = $request->input('destination');
        $product->othersource = $request->input('othersource');
        $product->save();
        Alert::success('Successfully Updated!', 'success');
        return back();
    }

    public function bankOutDelete($id)
    {
        $product = BankOut::findOrFail($id);
        $product->delete();
        Alert::success('Successfully deleted!', 'success');
        return back();

    }

    public function bankInDelete($id)
    {
        $product = BankIn::findOrFail($id);
        $product->delete();
        Alert::success('Successfully deleted!', 'success');
        return back();

    }


}
