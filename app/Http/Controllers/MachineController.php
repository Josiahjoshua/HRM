<?php

namespace App\Http\Controllers;

use App\Models\WorkOverTime;
use App\Models\Employee;
use App\Models\User;
use App\Models\Machine;
use App\Models\MachineTimesheet;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MachineController extends Controller
{
  public function index()
  {
    $machine = Machine::all();
    return view('machineTimesheet.machine', compact('machine'));
  }

  public function show($id)
  {
     $user = User::all();
     
     $machine = Machine::find($id);
      $monthlyTimesheet =  DB::table('machinetimesheet')
            ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('SUM(hours) as total_hours'))
            ->where('machine_id', $id)
            ->groupBy('month')
            ->get();
    
    $dailyTimesheet = MachineTimesheet::where('machine_id', $id)->get();
    return view('machineTimesheet.index', compact('monthlyTimesheet', 'user','dailyTimesheet','machine'));
  }


  public function store(Request $request)
  {
    $request->validate([
      'machine_name' => 'required',

    ]);

    $machine = new Machine();
    $machine->machine_name = request('machine_name');
    $machine->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $machine = Machine::findOrFail($id);
    $machine->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $machine = Machine::findOrFail($id);
    return view('machineTimesheet.editMachine', compact('machine'));
  }

  public function update(Request $request, $id)
  {

    $request->validate([
      'machine_name' => 'required',

    ]);

     $machine = Machine::find($id);
    $machine->machine_name = request('machine_name');
    $machine->save();

    Alert::success('Success!', 'Successfully updated');
    return redirect()->route('machine.index');
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
