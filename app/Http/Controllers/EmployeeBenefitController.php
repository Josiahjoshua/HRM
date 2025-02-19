<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeeBenefit;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeBenefitController extends Controller
{
    public function index()
    {
  

      $benefit_employee = EmployeeBenefit::all();
      $employee= User::select('id', 'name')->get();
      $benefits= benefit::select('id', 'name')->get();
      return view('payrol.employee-benefit.index', ['employee'=> $employee,'benefit_employee'=> $benefit_employee, 'benefits'=>$benefits]);
    }

    public function store(Request $request)
    {
      

      $benefit = new EmployeeBenefit();
      $benefit->employee_id = request('employee_id');
      $benefit->benefit_id = request('benefit_id');
      $benefit->effective_date = request('effective_date');
      $benefit->end_date = request('end_date');
      $benefit->amount= request('amount');
      $benefit->save();
      Alert::success('Success!', 'Successfully added');
      return back();
  
    }

    public function edit($id)
    {
      $benefit =EmployeeBenefit::findOrFail($id);
      $benefits= Benefit::select('id', 'name')->get();
      $employee= User::select('id', 'name')->get();
      return view('payrol.employee-benefit.edit', compact('benefit','benefits','employee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'benefit_id' => 'required',
            'effective_date' => 'required',
            'end_date' => 'required',
            'amount' => 'required',
        ]);
    
        $deduction = EmployeeBenefit::findOrFail($id);
        $deduction->employee_id = $request->input('employee_id');
        $deduction->benefit_id = $request->input('benefit_id');
        $deduction->effective_date = $request->input('effective_date'); // Corrected assignment
        $deduction->end_date = $request->input('end_date');
        $deduction->amount = $request->input('amount'); // You may need this if you intend to update the amount as well
        $deduction->save();
    
        Alert::success('Success!', 'Successfully updated');
        return redirect()->route('employee-benefit.index');
    }
}
