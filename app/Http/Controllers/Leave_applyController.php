<?php

namespace App\Http\Controllers;
use App\Models\Leave;
use App\Notifications\LeaveApproved;
use App\Notifications\LeaveRejected;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;


class Leave_applyController extends Controller
{

 public function index() 
   {
    
    $employee =  auth()->user();
     $user = Employee::select('id', 'name')->get();
     $users = User::select('id', 'name')->get();
    $leave_type = Leave_type::select('id', 'leavename')->get();
    $leave_apply = Leave_application::where('employee_id', $employee->id)->get();
    
   
     
    return view('leave.leave_application.leave_employee.index',  ['users'=>$users,'user'=>$user,'employee' => $employee, 'leave_apply' => $leave_apply, 'leave_type' => $leave_type]);
   }
  
  


public function create()
{
    $employees = Employee::all();
    return view('leave.create', compact('employees'));
}

public function isTanzaniaHoliday($date)
{
    // Get the year of the date
    $year = $date->format('Y');

    // List of Tanzania holidays
    $holidays = [
        '01-01', // New Year's Day
        '04-07', // Karume Day
        '04-14', // Good Friday
        '04-16', // Easter Sunday
        '04-17', // Easter Monday
        '04-26', // Union Day
        '05-01', // Labor Day
        '07-07', // Saba Saba Day
        '12-09', // Independence Day
        '12-25', // Christmas Day
        '12-26', // Boxing Day
        // Add more holidays if needed
    ];

    // Check if the date falls on any of the holidays
    foreach ($holidays as $holiday) {
        if ($date->format('m-d') === $holiday) {
            return true;
        }
    }

    return false;
}

 public function store(Request $request)
{
    $leave = new Leave_application;
    $employee_id=auth()->user()->id;
  // Retrieve the role of the authenticated user
    $user = auth()->user();
    $role = $user->roles()->first();
    $role_name = $role ? $role->name : null;
    $start_date = Carbon::parse($request->startdate);
    $end_date = Carbon::parse($request->enddate);

    $total_days = $start_date->diffInDaysFiltered(function ($date) {
    return !$date->isWeekend() && !$this->isTanzaniaHoliday($date);
    }, $end_date);

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
        Alert::Warning('warning!', 'It exceeds the total leave balance');
        return back();
    }
    
    // reject if requestor is selected as approver
    // if (in_array($employee_id, $request->assignto)) {
    //     Alert::warning('warning!', 'You cannot choose yourself as an approver');
    //     return back();
    // }
    
    if ($start_date->greaterThanOrEqualTo($end_date)) {
    Alert::warning('warning!', 'Start date should come after the end date');
    return back();
}


    
    $leave->employee_id =$employee_id;
    $leave->leave_id = $leave_type->id;
    $leave->start_date = $request->startdate;
    $leave->end_date = $request->enddate;
    $leave->reason = $request->reason;
    $leave->total_day = $total_days;
    $leave->role =$role; // store the role
    $leave->day_remain = $balance - $total_days;
    $leave->role = $role_name;
    
        If($request->input('proof')){
        $path_proof = Storage::putFile('proof', $request->file('proof'));
         $leave->proof = $path_proof;
        
        }
    $leave->save();
    
    // notify assigned approvers
    // $assignto = [];
    
    // foreach($request->assignto as $user_id) {
    //     $user = User::findOrFail($user_id);
         
    //     $assignto[] = $user->id;
       
    //     $user->notify(new NewLeaveApplicationNotification($leave));
    // }
    
    
// Notify users with the roles "director" and "manager" that there is a new leave request
$directorsAndManagers = User::whereHas('roles', function ($query) {
    $query->whereIn('name', ['director', 'manager']);
})->get();

Notification::send($directorsAndManagers, new NewLeaveApplicationNotification($leave, Auth::user()->name));



    Alert::success('Success!', 'Leave Application Successfully Sent');
    return back();
}



  public function edit($id)
  {
    $leave_apply = Leave_application::findOrFail($id);
    $employee = Employee::select('id', 'name')->get();
    $leave_type = Leave_type::select('id', 'leavename')->get();
    return view('leave.leave_application.edit',  ['employee' => $employee, 'leave_type' => $leave_type, 'leave_apply' => $leave_apply, $id]);
  }

  public function update(Request $request, $id)
  {
      
      
    $leave = Leave_application::findOrFail($id);
    $employee_id=auth()->user()->id;
    $start_date = Carbon::parse($request->startdate);
    $end_date = Carbon::parse($request->enddate);
    $total_days = $start_date->diffInDays($end_date);
    $leave_type = Leave_type::find($request->leave_type_id);
    $pendingLeaveApplication = Leave_application::where('employee_id', $employee_id)->whereNull('num_approvals')->orderBy('created_at', 'desc')->first();

    // check if last approved leave application of same leave type
    $lastLeaveApplicationOfSameType =  Leave_application::where('employee_id', $employee_id)
      ->where('leave_id', $request->leave_type_id)
      ->where('num_approvals','>=', 1)
      ->whereBetween('created_at', [now()->startOfYear()->toDateString(), now()->endOfYear()->toDateString()])
      ->orderBy('created_at', 'desc')->first();
    $balance = $lastLeaveApplicationOfSameType ?
    $lastLeaveApplicationOfSameType->day_remain : $leave_type->day_no;
    // reject if  $balance exceed application days
    if ($balance < $total_days) {
      Alert::Warning('warning!', 'its exceed the total leave balance');
      return back();
    }
    
     if ($start_date->greaterThanOrEqualTo($end_date)) {
    Alert::warning('warning!', 'Start date should come after the end date');
    return back();
     }

    $leave->employee_id =  $employee_id;
    $leave->leave_id = $leave_type->id;
    $leave->start_date = $request->startdate;
    $leave->end_date = $request->enddate;
    $leave->reason = $request->reason;
    $leave->total_day = $total_days;
    $leave->day_remain = $balance - $total_days;
    
    //  dd($request->file('proof'));
    
if ($request->hasFile('proof') && $request->file('proof')->isValid()) {
    $path_proof = Storage::putFile('proof', $request->file('proof'));
    $leave->proof = $path_proof;
}


    $leave->save();

    Alert::success('Success!', 'Application successfully updated');
    return back();


  }
  
  
  public function destroy($id)
{
    $leave = Leave_application::findOrFail($id);
    $leave->delete();
     
    Alert::success('Success!', 'Leave deleted successfully');
    return redirect()->route('leave.index');
}

public function managerView()
{
    $user = auth()->user();

    // Get the department ID of the logged-in manager
    $managerDepartmentId = $user->department_id;

    // Fetch leave applications of employees in the same department as the manager
    $leave_apply = Leave_application::query()
        ->select('leave_application.*')
        ->join('users', 'users.id', '=', 'leave_application.employee_id')
        // ->where('users.department_id', '=', $managerDepartmentId)
        ->where('leave_application.role', '!=', 'manager')
        // ->where('leave_application.employee_id', '!=', $user->id )
        ->get();

    $employee = User::select('id', 'name')->get();
    $leave_type = Leave_type::select('id', 'leavename')->get();

    return view('leaveApprove.managerApprove', [
        'employee' => $employee,
        'leave_apply' => $leave_apply,
        'leave_type' => $leave_type,
    ]);
}



  public function managerApprove($id)
  {
    
    $leave = Leave_application::findOrFail($id);
    $leave->statusManager = 1; //Approved
    $leave->num_approvals += 1; //aded 03rd
    $leave->managerApprover = Auth::user()->name;
    $leave->save();
    $leave->user->notify(new LeaveApproved($leave, Auth::user()->name));
    Alert::success('Approved!', 'Leave request approved');
    return redirect()->back(); //Redirect user somewhere
  }

  public function managerDecline(Request $request)
  {
    $leaveId = $request->input('leave_id');
   
    $leave = Leave_application::where('id',$leaveId)->first();
    
    if($leave){
    $leave->statusManager = 0; //Declined
    $leave->num_approvals += 1; //aded 03rd
    $leave->rejection_reason = $request->input('rejection_reason');
    $leave->managerApprover = Auth::user()->name;
    $leave->save();
    $approverEmail = Auth::user()->email;
    $rejectionReason = $request->input('rejection_reason'); 
    $leave->user->notify(new LeaveRejected($leave, Auth::user()->name,$rejectionReason,  $approverEmail));
    Alert::success('Rejected!', 'application successful rejected');
    return redirect()->back(); //Redirect user somewhere
    
    }
    
     Alert::info('', 'No data found');
    return redirect()->back(); //Redirect user somewhere

  }

  
    public function hrView()
  {
        $leave_apply = Leave_application::query()
      ->select('leave_application.*')
      ->get();
    $employee = User::select('id', 'name')->get();
    $leave_type = Leave_type::select('id', 'leavename')->get();
    return view('leaveApprove.hrApprove',  ['employee' => $employee, 'leave_apply' => $leave_apply, 'leave_type' => $leave_type]);
 
  }

  public function hrApprove($id)
  {
    $leave = Leave_application::findOrFail($id);
    $leave->statusHr = 1; //Approved
     $leave->num_approvals += 1; //aded 03rd
     $leave->directorApprover = Auth::user()->name;
    $leave->save();
       $leave->user->notify(new LeaveApproved($leave, Auth::user()->name));
    Alert::success('Approved!', 'Leave request approved');
    return redirect()->back(); //Redirect user somewhere
  }

  public function hrDecline(Request $request)
  {
        $leaveId = $request->input('leave_id');
   
    $leave = Leave_application::where('id',$leaveId)->first();
    
     if($leave){
    $leave->statusHr = 0; //Declined
    $leave->num_approvals += 1; //aded 03rd
    $leave->rejection_reason = $request->input('rejection_reason');
     $leave->directorApprover = Auth::user()->name;
    $leave->save();
    $leave->user->notify(new LeaveRejected($leave, Auth::user()->name));
    Alert::info('Rejected!', 'Leave Application successful rejected');
    return redirect()->back(); //Redirect user somewhere
    
  }
    
     Alert::info('', 'No data found');
    return redirect()->back(); //Redirect user somewhere

  }
  
      public function downloadProof($id)
    {
        $proof = Leave_application::where('id', $id)->firstOrFail();
        return response()->file(
            storage_path('app') . DIRECTORY_SEPARATOR . $proof->proof
        );
    }
}
