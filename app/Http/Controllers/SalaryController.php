<?php

namespace App\Http\Controllers;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\User;
use App\Models\Deduction;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
  public function index()
  {


    $salary = Salary::all();
    $employee= User::select('id', 'name')->get();
    return view('payrol.salary-info.index', compact('salary','employee'));
  }
   
  public function store(Request $request)
  {

    $salary = new Salary();
    $salary->employee_id = request('employee_id');
    $salary -> basic_salary = request('salary');
    $salary -> start_date = request('start_date');
    $salary -> end_date = request('end_date');
    $salary->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }
    


public function edit($id)
{
    $employee_salary = Salary::findOrFail($id);
    return view('payrol.salary-info.edit', compact('employee_salary'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'basic_salary' => 'required|numeric',
        'start_date' => 'required|date',
    ]);

    $employee_salary = Salary::findOrFail($id);
    $employee_salary->basic_salary = $request->input('basic_salary');
    $employee_salary->start_date = $request->input('start_date');
    $employee_salary->end_date = $request->input('end_date');
    
    // Save the updated salary record
    $employee_salary->save();

 
    Alert::success('Success!', 'Successfully Updated');
    return redirect()->route('salary.index');
}

public function destroy($id)
{
    $employee_salary = Salary::findOrFail($id);
    $employee_salary->delete();

    Alert::success('Success!', 'Successfully Deleted');
    return redirect()->route('salary.index');
}


}
