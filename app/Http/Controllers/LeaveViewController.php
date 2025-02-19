<?php

namespace App\Http\Controllers;

use App\Models\Leave_type;
use App\Models\Leave_application;
use App\Models\Employee;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewLeaveApplicationNotification; 

class LeaveViewController extends Controller
{
   public function index() 
   {
    
    $employee = auth()->user();
     $user = Employee::select('id', 'first_name')->get();
     $users = User::select('id', 'name')->get();
    //  dd($users);
    $leave_type = Leave_type::select('id', 'leavename')->get();
    $leave_apply = Leave_application::where('employee_id', auth()->user()->employee_id)->get();
     dd($employee);
    return view('leave.leave_application.leave_employee.index',  ['users'=>$users,'user'=>$user,'employee' => $employee, 'leave_apply' => $leave_apply, 'leave_type' => $leave_type]);
   }

   public function store(Request $request)
   {  
     
     $leave = new Leave_application;
     $employee_id=auth()->user()->employee_id;
     dd($employee_id);
     $start_date = Carbon::parse($request->startdate);
     $end_date = Carbon::parse($request->enddate);
     $total_days = $start_date->diffInDays($end_date);
     $leave_type = Leave_type::find($request->leave_type_id);
     $pendingLeaveApplication = Leave_application::where('employee_id', $employee_id)->whereNull('num_approvals')->orderBy('created_at', 'desc')->first();
     //reject if there is pending leave application
     if ($pendingLeaveApplication) {
       Alert::warning('warning!', 'You can\'t apply until the previous application is processed!');
       return back();
     }
     // check if last approved leave application of same leave type
     $lastLeaveApplicationOfSameType =  Leave_application::where('employee_id', $employee_id)
       ->where('leave_id', $request->leave_type_id)
       ->where('num_approvals', 3)
       ->whereBetween('created_at', [now()->startOfYear()->toDateString(), now()->endOfYear()->toDateString()])
       ->orderBy('created_at', 'desc')->first();
     $balance = $lastLeaveApplicationOfSameType ?
     $lastLeaveApplicationOfSameType->day_remain : $leave_type->day_no;
     // reject if  $balance exceed application days
     if ($balance < $total_days) {
       Alert::Warning('warning!', 'its exceed the total leave balance');
       return back();
     }
     $leave->employee_id = $employee_id;
     $leave->leave_id = $leave_type->id;
     $leave->start_date = $request->startdate;
     $leave->end_date = $request->enddate;
     $leave->reason = $request->reason;
     $leave->total_day = $total_days;
     $leave->day_remain = $balance - $total_days;
     $leave->save();
      $assignto = [];
    foreach($request->assignto as   $user_id) {
       $approvers = $request->assignto;
    if (!empty($approvers)) {
        foreach ($approvers as $user_id) {
            $user = User::findOrFail($user_id);
            $user->notify(new NewLeaveApplicationNotification($leave));
        }
    }
    }
     Alert::success('Success!', 'application successful added');
     return back();
   }
   public function edit($id)
  {
    
    $leave_apply = Leave_application::findOrFail($id);
    $employee = auth()->user();
    $user = Employee::select('id', 'first_name')->get();
    $leave_type = Leave_type::select('id', 'leavename')->get();
    return view('leave.leave_application.leave_employee.edit',  ['user'=>$user,'employee' => $employee, 'leave_type' => $leave_type, 'leave_apply' => $leave_apply, $id]);
  }
   //seno added  this function below 
   
 
public function show()
{
    
    // Retrieve all leave applications from the database
    $leaves = Leave_application::all();
    
    // Pass the report data to the view
    return view('leave.report',  ['leaves' => $leaves]);
 
}

  
  public function update(Request $request, $id)
  {
    $leave = Leave_application::findOrFail($id);
    $employee_id = auth()->user()->employee_id;
     $start_date = Carbon::parse($request->startdate);
     $end_date = Carbon::parse($request->enddate);
     $total_days = $start_date->diffInDays($end_date);
     $leave_type = Leave_type::find($request->leave_type_id);
 
     $pendingLeaveApplication = Leave_application::where('employee_id', $employee_id)
       ->whereNull('num_approvals')
       ->orderBy('created_at', 'desc')->first();
 
     //reject if there is pending leave application
     if ($pendingLeaveApplication) {
       Alert::warning('warning!', 'You can\'t apply until the previous application is processed!');
       return back();
     }
 
     // check if last approved leave application of same leave type
     $lastLeaveApplicationOfSameType =  Leave_application::where('employee_id', $employee_id)
       ->where('leave_id', $request->leave_type_id)
       ->where('num_approvals', 3)
       ->whereBetween('created_at', [now()->startOfYear()->toDateString(), now()->endOfYear()->toDateString()])
       ->orderBy('created_at', 'desc')->first();
     $balance = $lastLeaveApplicationOfSameType ?
     $lastLeaveApplicationOfSameType->day_remain : $leave_type->day_no;
     // reject if  $balance exceed application days
     if ($balance < $total_days) {
       Alert::Warning('warning!', 'its exceed the total leave balance');
       return back();
     }
     $leave->employee_id = $employee_id;
     $leave->leave_id = $leave_type->id;
     $leave->start_date = $request->startdate;
     $leave->end_date = $request->enddate;
     $leave->reason = $request->reason;
     $leave->total_day = $total_days;
     $leave->day_remain = $balance - $total_days;
     $leave->save();
     Alert::success('Success!', 'application successful updated');
     return back();
    }
}