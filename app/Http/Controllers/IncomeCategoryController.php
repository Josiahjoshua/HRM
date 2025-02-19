<?php

namespace App\Http\Controllers;

use App\Models\WorkOverTime;
use App\Models\Income;
use App\Models\User;
use App\Models\IncomeCategory;
use App\Models\MachineTimesheet;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class IncomeCategoryController extends Controller
{
  public function index()
  {
    $income = IncomeCategory::all();
    return view('income.category', compact('income'));
  }

  public function show($id)
  {
    $income = IncomeCategory::find($id);
     
     $monthlyIncome =  DB::table('income')
     ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('SUM(amount) as total_amount'))
     ->where('category_id', $id)
     ->groupBy('month')
     ->orderBy('month','desc')
     ->get();

$dailyIncome = Income::where('category_id', $id)->get();
return view('income.index', compact('monthlyIncome', 'income','dailyIncome'));
  }


  public function store(Request $request)
  {
    $request->validate([
      'category_name' => 'required',

    ]);

    $machine = new IncomeCategory();
    $machine->category_name = request('category_name');
    $machine->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $machine = IncomeCategory::findOrFail($id);
    $machine->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $machine = IncomeCategory::findOrFail($id);
    return view('income.editCategory', compact('machine'));
  }

  public function update(Request $request, $id)
  {

    $request->validate([
      'category_name' => 'required',

    ]);

     $machine = IncomeCategory::find($id);
    $machine->category_name = request('category_name');
    $machine->save();

    Alert::success('Success!', 'Successfully updated');
    return redirect()->route('machine.index');
  }

  


}
