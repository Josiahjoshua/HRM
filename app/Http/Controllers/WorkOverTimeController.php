<?php

namespace App\Http\Controllers;

use App\Models\WorkOverTime;
use App\Models\Employee;
use App\Models\User;
use App\Models\Salary;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class WorkOverTimeController extends Controller
{
  public function index()
  {

    $employee = Auth::user();
     
      $work_overtime = WorkOverTime::where('employee_id', $employee->id)->orderBy('date','desc')->get();
    
    return view('payrol.work-overtime.index', compact('work_overtime', 'employee'));
  }

  public function approveWorkOverTime()
  {

if (auth()->check()) {
    $employee = auth()->user();
    
    if ($employee->hasRole('director')) {
        // Fetch work overtime for directors
        $work_overtime = WorkOverTime::all();
    }



    if ($employee->hasRole('Super Admin')) {
      // If the user has a 'manager' role, fetch work overtime for all employees
      $work_overtime = WorkOverTime::all();
    } 
    
    elseif ($employee->hasRole('manager')) {
      // If the user has a 'manager' role, fetch work overtime for all employees except managers


      $loggedInUser = Auth::user(); // Get the logged-in user
      
      $work_overtime = DB::table('workovertime')
          ->join('users', 'workovertime.employee_id', '=', 'users.id')
          ->orderBy('workovertime.date','desc')
          ->whereIn('employee_id', function ($query) use ($loggedInUser) {
              $query->select('id')
                  ->from('users')
                  ->whereNotIn('id', function ($subQuery) {
                      $subQuery->select('model_id')
                          ->from('model_has_roles')
                          ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                          ->where('roles.name', 'manager');
                  })
                  ->where('department_id', $loggedInUser->department_id); // Add the department condition
          })
           ->get();
    } 
    
      return view('payrol.work-overtime.approveWorkOvertime', compact('work_overtime', 'employee'));
}

else{
     return redirect()->route('login');
}
      
      
    
    
  }

  public function store(Request $request)
  {
    $request->validate([
      'employee_id' => 'required',
      'hours' => ['required', 'integer']
    ]);

    $work_overtime = new WorkOverTime();
    $employee_id = Auth::user()->id;
    $work_overtime->employee_id =  $employee_id;
    $work_overtime->date = request('date');
    $work_overtime->total_hours = request('hours');
    $path = Storage::putFile('file_url', $request->file('file_url'));
    $work_overtime->file_url = $path;
    $work_overtime->amount_per_hour = request('amountPerHour');
    $work_overtime->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $work_overtime = WorkOverTime::findOrFail($id);
    $work_overtime->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $work = WorkOverTime::findOrFail($id);
    $employee = User::select('id', 'name')->get();
    return view('payrol.work-overtime.edit', compact('work', 'employee'));
  }

  public function update(Request $request, $id)
  {

    $month = now()->startOfMonth()->subMonth()->format('Y-m');
    $request->validate([
      'employee_id' => ['required'],
      'total_hours' => ['required', 'integer']
    ]);
    $work_overtime = WorkOverTime::findOrFail($id);;
    $employee_id = Auth::user()->id;
    $work_overtime->date = request('date');
    $work_overtime->total_hours = request('total_hours');
    if ($request->input('file_url')) {
      $path = Storage::putFile('file_url', $request->file('file_url'));
      $work_overtime->file_url = $path;
    }
    $work_overtime->amount_per_hour = request('amount_per_hour');
    $work_overtime->save();
    Alert::success('Success!', 'Successfully updated');
    return redirect()->route('work-overtime.index');
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
    $work_overtime->approverName = Auth::user()->name;
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
