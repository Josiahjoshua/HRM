<?php

namespace App\Http\Controllers;

use App\Models\WorkOverTime;
use App\Models\Employee;
use App\Models\User;
use App\Models\MachineTimesheet;
use App\Models\Machine;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MachineTimesheetController extends Controller
{
  public function index()
  {

     $user = User::all();
     
      $monthlyTimesheet =  DB::table('machinetimesheet')
            ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('SUM(hours) as total_hours'))
            ->groupBy('month')
            ->get();
    
    $dailyTimesheet = MachineTimesheet::all();
    return view('machineTimesheet.index', compact('monthlyTimesheet', 'user','dailyTimesheet'));
  }



  public function store(Request $request)
  {
    $request->validate([
      'employee_id' => 'required',
      'machine_id' => 'required',
      'start_hour' => ['required', 'integer'],
      'end_hour' => ['required', 'integer'],
      'activities' => 'required',
      'date' => 'required'
    ]);

    $timesheet = new MachineTimesheet();
    $timesheet->employee_id = request('employee_id');
      $timesheet->machine_id = request('machine_id');
    $timesheet->date = request('date');
    $timesheet->start_hour = request('start_hour');
     $timesheet->end_hour = request('end_hour');
    $timesheet->fuel = request('fuel');
     $timesheet->activities = request('activities');
        $timesheet->hours = request('end_hour') - request('start_hour');
    $timesheet->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $timesheet = MachineTimesheet::findOrFail($id);
    $timesheet->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $timesheet = MachineTimesheet::findOrFail($id);
    $machine = Machine::all();
    $employee = User::select('id', 'name')->get();
    return view('machineTimesheet.edit', compact('timesheet', 'employee','machine'));
  }

public function update(Request $request, $id)
{
    $timesheet = MachineTimesheet::find($id);
    
    // Validate the request data
    $request->validate([
        'employee_id' => 'required',
        'machine_id' => 'required',
        'date' => 'required|date',
        'activities' => 'required',
        'start_hour' => 'required|numeric',
        'end_hour' => 'required|numeric',
        'fuel' => 'required|numeric',
    ]);

    // Update the timesheet with the request data
    $timesheet->employee_id = $request->input('employee_id');
    $timesheet->machine_id = $request->input('machine_id');
    $timesheet->date = $request->input('date');
    $timesheet->activities = $request->input('activities');
    $timesheet->start_hour = $request->input('start_hour');
    $timesheet->end_hour = $request->input('end_hour');
    $timesheet->fuel = $request->input('fuel');

    // Save the updated timesheet
    $timesheet->save();
    Alert::success('Success!', 'Successfully updated');
    return redirect()->route('machine.show',$id);
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
