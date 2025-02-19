<?php

namespace App\Http\Controllers;

use App\Models\PettyCash;
use App\Models\Bank;
use App\Models\BankIn;
use App\Models\BankOut;
use App\Models\Cash;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class CashController extends Controller
{
   public function index()
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
   
       // Fetch all cash and banks
       $cash = Cash::all();
       $banks = Bank::all();
   
       return view('balanceSheet.Cash.index', compact('cash', 'banks', 'cashAvailable'));
   }

public function store(Request $request)
{
       // Validate the incoming request data
       $validatedData = $request->validate([
         'type' => 'required|in:income,expenditure',
         'source_destination' => 'required',
         'date' => 'required|date',
         'amount' => 'required|numeric',
         'description' => 'required|string',
     ]);
   
     // Find the Cash record by its ID
     $cash = new Cash();
     // Update the Cash record with the validated data
     $cash->type = $validatedData['type'];
     $cash->source_destination = $validatedData['source_destination'];
     $cash->date = $validatedData['date'];
     $cash->amount = $validatedData['amount'];
     $cash->description = $validatedData['description'];
    
     
     // If 'other' option is selected, update the 'othersource_destination' field
     if ($request->input('source_destination') == 'other') {
         $cash->othersource_destination = $request->input('othersource_destination');
     } else {
         $cash->othersource_destination = null; // Reset the field if 'other' option is not selected
     }
   
     // Save the updated Cash record
     $cash->save();

    Alert::success('Success!', 'Successfully saved');
      return back();
}

public function update(Request $request,  $id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
      'type' => 'required|in:income,expenditure',
      'source_destination' => 'required',
      'date' => 'required|date',
      'amount' => 'required|numeric',
      'description' => 'required|string',
  ]);

  // Find the Cash record by its ID
  $cash = Cash::findOrFail($id);

 

  // Update the Cash record with the validated data
  $cash->type = $validatedData['type'];
  $cash->source_destination = $validatedData['source_destination'];
  $cash->date = $validatedData['date'];
  $cash->amount = $validatedData['amount'];
  $cash->description = $validatedData['description'];
 
  
  // If 'other' option is selected, update the 'othersource_destination' field
  if ($request->input('source_destination') == 'other') {
      $cash->othersource_destination = $request->input('othersource_destination');
  } else {
      $cash->othersource_destination = null; // Reset the field if 'other' option is not selected
  }

  // Save the updated Cash record
  $cash->save();

    Alert::success('success', 'Cash record updated successfully.');
      return redirect()->route('cash.index');
}

    public function destroy($id)
   {
   
       $cash= Cash::findOrFail($id);
       $cash->delete();
       Alert::success('Success!', 'Successfully deleted');
       return back();
   }

   public function edit($id)
   {

      $CashEdit = Cash::findOrFail($id);
      $banks = Bank::all();
      return view('balanceSheet.cash.edit', compact('CashEdit','banks'));

   }
 
      
}
