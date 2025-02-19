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

class PettyCashController extends Controller
{
   public function index()
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

    // Fetch all petty cash and banks
    $pettyCash = PettyCash::all();
    $banks = Bank::all();

    return view('balanceSheet.pettyCash.index', compact('pettyCash', 'banks', 'pettyCashAvailable'));
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
  $cash = new PettyCash();
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
  $cash = PettyCash::findOrFail($id);

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
      return redirect()->route('pettyCash.index');
}

    public function destroy($id)
   {
   
       $cash= PettyCash::findOrFail($id);
       $cash->delete();
       Alert::success('Success!', 'Successfully deleted');
       return back();
   }

   public function edit($id)
   {

      $pettyCashEdit = PettyCash::findOrFail($id);
      $banks = Bank::all();
      return view('balanceSheet.pettyCash.edit', compact('pettyCashEdit','banks'));

   }


      
}
