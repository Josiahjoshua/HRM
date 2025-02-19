<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Earn_leave;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Leave_earnController extends Controller
{
    public function index()
    {

      $leave_earn = Earn_leave::all();
      $employee = Employee::select('id', 'first_name')->get();
      return view('leave.earn_leave.index',  ['employee'=> $employee,'leave_earn'=> $leave_earn]);
    }
    public function store(Request $request)
    {

        $leave_earn = new Earn_leave();
        $leave_earn->employee_id=request('first_name');
        $leave_earn->start_date=request('start_date');
        $leave_earn->end_date=request('end_date');
        $dt1 = Carbon::parse($leave_earn->start_date);
        $dt2 = Carbon::parse($leave_earn->end_date);
        $leave_earn->total_earndays=$interval = $dt1->diffInDays($dt2 );
        $leave_earn->save();
        Alert::success('Success!', 'successful added');
        return back();       
        
}
public function edit($id)
  {

    
    $leave_earn = Earn_leave::findOrFail($id);
    $employee = Employee::select('id', 'first_name')->get();
    return view('leave.earn_leave.edit',  ['employee'=> $employee,'leave_earn'=> $leave_earn]);
  }
  public function update(Request $request, $id)
  {

      $leave= Earn_leave::findOrFail($id);
      $leave->employee_id=request('first_name');
      $leave->start_date=request('start_date');
      $leave->end_date=request('end_date');
      $dt1 = Carbon::parse($leave->start_date);
      $dt2 = Carbon::parse(($leave->end_date));
      $leave->total_earndays=$interval = $dt1->diffInDays($dt2 );
      $leave->update();
      Alert::success('Success!', 'successful updated');
      return redirect()->route('leave_earn.index');
       }
}
