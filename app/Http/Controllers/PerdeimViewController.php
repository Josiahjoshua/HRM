<?php

namespace App\Http\Controllers;

use App\Models\Perdeim;
use App\Models\User;
use App\Models\PerdeimRetire;
use App\Models\Employee;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PerdeimViewController extends Controller
{
  public function index()
  {

    $employee = auth()->user();
    $perdeim = Perdeim::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->get();
    $users = User::select('id', 'name')->get();
    return view('perdeim.index',  ['employee' => $employee, 'perdeim' => $perdeim, 'users' => $users]);
  }

 public function store( Request $request)
    {

    $perdeim = new Perdeim;
    $employee_id=auth()->user()->id;
    $pendingPerdeimApplication = Perdeim::where('employee_id', $employee_id)
      ->whereNull('num_approvals')
      ->orderBy('created_at', 'desc')->first();
   

$Retire = Perdeim::where('employee_id', $employee_id)
    ->where('statusDr', '=', 1)
    ->whereNull('retire_status')
    ->orderBy('created_at', 'desc')
    ->first();
    
    
    
    //reject if there is pending leave application
    if ($pendingPerdeimApplication) {
      Alert::warning('warning!', 'You can\'t apply until the previous application is processed!');
      return back();
    }
    if($Retire){
            Alert::warning('warning!', 'You can\'t apply until the Retirement is done!');
            return back();
             }   
    else{
    $perdeim->employee_id =$employee_id;
    $perdeim->amount = $request->amount;
    $perdeim->reason = $request->reason;
    $perdeim->save();
      $assignto = [];

       $approvers = $request->assignto;
    if (!empty($approvers)) {
        foreach ($approvers as $user_id) {
            $user = User::findOrFail($user_id);
            $user->notify(new NewPerdeimApplicationNotification($perdeim));
        }
    }
    Alert::success('Success!', 'application successful added');
    return back();
     }
   }
    
  

  public function show($perdeim_id)
  {

    $perdeim = PerdeimRetire::with('perdeim')->where('perdeim_id', $perdeim_id)->get();
    return view('perdeimemployee.retire.index', compact('perdeim', 'perdeim_id'));
  }
}
