<?php

namespace App\Http\Controllers;
use App\Models\Deduction;
use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeeDeduction;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EmployeeDeductionController extends Controller
{
    public function index()
    {
      $deduction_employee = EmployeeDeduction::all();
      $employee= User::select('id', 'name')->get();
      $deduction= Deduction::select('id', 'name')->get();
      return view('payrol.employee-deduction.index', compact('deduction_employee','employee','deduction'));
    }
    public function store(Request $request)
    {

        $deduction = new EmployeeDeduction();
        $deduction->employee_id = request('employee_id');
        $deduction->deduction_id = request('deduction_id');
        $deduction->effective_date = request('effective_date');
        $deduction->end_date = $request->input('end_date');
        $deduction->amount= request('amount');
        $deduction->save();
        Alert::success('Success!', 'Successfully added');
        return back();
  
      }
      
      public function destroy($id)
      {
        $deduction= EmployeeDeduction::findOrFail($id);
        $deduction->delete();
        Alert::success('Success!', 'Successfully deleted');
        return back();
        // return redirect('/foodie')->with('success', 'Corona Case Data is successfully deleted');
      }
      public function edit($id)
      {
        $deduct =EmployeeDeduction::findOrFail($id);
        $deduction= Deduction::select('id', 'name')->get();
        return view('payrol.employee-deduction.edit', compact('deduct','deduction'));
      }

      public function update(Request $request, $id)
      {
          $request->validate([
              'employee_id' => 'required',
              'deduction_id' => 'required',
              'effective_date' => 'required',
              'end_date' => 'required',
              'amount' => 'required',
          ]);
      
          $deduction = EmployeeDeduction::findOrFail($id);
          $deduction->employee_id = $request->input('employee_id');
          $deduction->deduction_id = $request->input('deduction_id');
          $deduction->effective_date = $request->input('effective_date'); // Corrected assignment
          $deduction->end_date = $request->input('end_date');
          $deduction->amount = $request->input('amount'); // You may need this if you intend to update the amount as well
          $deduction->save();
      
          Alert::success('Success!', 'Successfully updated');
          return redirect()->route('employee-deduction.index');
      }
      
}
