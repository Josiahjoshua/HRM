<?php

namespace App\Http\Controllers;

use App\Models\WorkOverTime;
use App\Models\Employee;
use App\Models\User;
use App\Models\Expenditure;
use App\Models\Machine;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ExpenditureController extends Controller
{
  public function index()
  {

     $user = User::all();
     
      $monthlyExpenditure =  DB::table('expenditure')
            ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('month')
            ->orderBy('month','desc')
            ->get();
    
    $dailyExpenditure = Expenditure::all();
    return view('expenditure.index', compact('monthlyExpenditure', 'user','dailyExpenditure'));
  }



  public function store(Request $request)
  {
    $request->validate([
      
      'amount' => 'required',
      'for' => 'required',
      'desc' => 'required',
      'date' => 'required',
      'category_id' => 'required'
    ]);

    $expenditure = new Expenditure();
    $expenditure->category_id = request('category_id');
     $expenditure->date = request('date');
    $expenditure->for = request('for');
    $expenditure->amount = request('amount');
     $expenditure->desc = request('desc');
    $expenditure->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $expenditure = Expenditure::findOrFail($id);
    $expenditure->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $expenditure = Expenditure::findOrFail($id);
   
    return view('expenditure.edit', compact('expenditure'));
  }

public function update(Request $request, $id)
{
    $expenditure = Expenditure::find($id);
    
    // Validate the request data
    $request->validate([
      
      'amount' => ['required', 'integer'],
      'for' => 'required',
      'desc' => 'required',
      'date' => 'required'
    ]);

    
     $expenditure->date = request('date');
    $expenditure->for = request('for');
    $expenditure->amount = request('amount');
     $expenditure->desc = request('desc');

    // Save the updated timesheet
    $expenditure->save();
    Alert::success('Success!', 'Successfully updated');
    return redirect()->route('machine.index');
  }

 
}
