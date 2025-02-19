<?php

namespace App\Http\Controllers;

use App\Models\WorkOverTime;
use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeeTimesheet;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EmployeeTimesheetController extends Controller
{
  public function index()
  {

     $user = User::all();

    return view('employeeTimesheet.employee', compact('user'));
  }
  
    public function show($id)
  {
        
      $user = User::find($id);
      $monthlyTimesheet =  DB::table('employeetimesheet')
            ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), 
            DB::raw('SUM(hours) as total_hours'),
            DB::raw('SUM(overtime) as total_overtime'))
            ->where('employee_id', $id)
            ->groupBy('month')
            ->get();
    
    $dailyTimesheet = EmployeeTimesheet::where('employee_id', $id)->get();
    return view('employeeTimesheet.index', compact('monthlyTimesheet', 'user','dailyTimesheet'));
      
  }



  public function store(Request $request)
  {
    
    $request->validate([
      'start_hour' => 'required',
      'end_hour' => 'required',
      'overtime' => 'required',
      'date' => 'required'
    ]);

    $timesheet = new EmployeeTimesheet();
    $timesheet->employee_id = request('employee_id');
    $timesheet->date = request('date');
    $timesheet->start_hour = request('start_hour');
    $timesheet->end_hour = request('end_hour');
    $timesheet->overtime = request('overtime');
    $timesheet->hours = round((strtotime(request('end_hour')) - strtotime(request('start_hour'))) / 3600, 2);
    $timesheet->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $timesheet = EmployeeTimesheet::findOrFail($id);
    $timesheet->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $timesheet = EmployeeTimesheet::findOrFail($id);
    $employee = User::select('id', 'name')->get();
    return view('employeeTimesheet.edit', compact('timesheet', 'employee'));
  }

public function update(Request $request, $id)
{
    $timesheet = EmployeeTimesheet::find($id);
    
    // Validate the request data
    $request->validate([
        
        'date' => 'required|date',
        'start_hour' => 'required',
        'end_hour' => 'required',
    ]);

    // Update the timesheet with the request data

    $timesheet->date = $request->input('date');
    $timesheet->overtime = $request->input('overtime');
    $timesheet->start_hour = $request->input('start_hour');
    $timesheet->end_hour = $request->input('end_hour');
    $timesheet->hours = round((strtotime(request('end_hour')) - strtotime(request('start_hour'))) / 3600, 2);

    // Save the updated timesheet
    $timesheet->update();
    Alert::success('Success!', 'Successfully updated');
    return back();
  }

  

  public function approve($id)
  {

    $work_overtime = WorkOverTime::findOrFail($id);
    $work_overtime->status = 1; //Approved
    $work_overtime->approverName = Auth::user()->name;
    $work_overtime->save();
    Alert::success('Approved!', 'Your Work-Overtime have been approved');
    return redirect()->back(); //Redirect user somewhere
  }

  public function decline($id)
  {

    $work_overtime = WorkOverTime::findOrFail($id);
    $work_overtime->status = 0; //Declined
    $work_overtime->save();
    Alert::info('Rejected!', 'Your work-overtime have been rejected');
    return redirect()->back(); //Redirect user somewhere
  }

  public function download($id)
  {

    $work_overtime = WorkOverTime::where('id', $id)->firstOrFail();
    return response()->file(storage_path('app') . DIRECTORY_SEPARATOR . $work_overtime->file_url);
  }
}
