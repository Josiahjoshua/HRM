<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Perdeim;
use App\Models\PerdeimRetire;
use App\Models\User;
use App\Notifications\NewPerdeimApplicationNotification;
use App\Notifications\PerdeimApplicationApproved;
use App\Notifications\PerdeimApplicationRejected;
use App\Notifications\PerdeimRetirementApproved;
use App\Notifications\PerdeimRetirementRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;


class PerdeimController extends Controller
{
    public function index()
    {

        $employee = auth()->user();
        $perdeim = Perdeim::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->get();
        $users = User::select('id', 'name')->get();
        return view('perdeim.index', ['employee' => $employee, 'perdeim' => $perdeim, 'users' => $users]);
    }

    public function store(Request $request)
    {

        $perdeim = new Perdeim;
        $employee_id = auth()->user()->id;
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
        if ($Retire) {
            Alert::warning('warning!', 'You can\'t apply until the Retirement is done!');
            return back();
        } else {
            $perdeim->employee_id = $employee_id;
            $perdeim->date = request('date');
            $perdeim->amount = request('amount');
            $perdeim->allowance = request('allowance');
            $perdeim->reason = request('reason');
            $perdeim->save();

            // Notify users with the roles "director" and "manager" that there is a new leave request
            $directorsAndManagers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['Super Admin', 'Empty Role']);
            })->get();

            Notification::send($directorsAndManagers, new NewPerdeimApplicationNotification($perdeim, Auth::user()->name));

            Alert::success('Success!', 'application successful added');
            return back();
        }
    }
    public function show($perdeim_id)
    {

        $perdeim = PerdeimRetire::with('perdeim')->where('perdeim_id', $perdeim_id)->get();
        return view('perdeim.perdeimretire.index', compact('perdeim', 'perdeim_id', 'perdeim_id'));
    }

    public function managerView()
    {
        $employeeId = auth()->user()->id;

        $perdeim = Perdeim::query()
            ->select('perdeim.*')
            ->join('users', 'users.id', '=', 'perdeim.employee_id')
            ->get();

        $perdeimRetire = PerdeimRetire::all();

        $employee = Employee::select('id', 'name')->get();
        // $leave_type = Leave_type::select('id', 'leavename')->get();
        return view('perdeimApprove.managerApprove', compact('perdeim', 'employee', 'perdeimRetire'));
    }

    public function managerApprove($id)
    {

        $perdeim = Perdeim::findOrFail($id);
        $perdeim->statusManager = 1; //Approved
        $perdeim->num_approvals += 1; //aded 03rd
        $perdeim->managerApprover = Auth::user()->name;
        $perdeim->save();
        $approverEmail = Auth::user()->email;
        $perdeim->user->notify(new PerdeimApplicationApproved($perdeim, Auth::user()->name, $approverEmail ));
        Alert::success('Approved!', 'Perdeim request approved');
        return redirect()->back(); //Redirect user somewhere
    }

    public function managerDecline(Request $request)
    {
        $perdeimId = $request->input('perdeim_id');

        $perdeim = Perdeim::findOrFail($perdeimId);
        $perdeim->statusManager = 0; //Declined
        $perdeim->num_approvals += 1; //aded 03rd
        $perdeim->managerApprover = Auth::user()->name;
        $perdeim->rejection_reason = $request->input('rejection_reason');
        $perdeim->save();
        $approverEmail = Auth::user()->email;
        $rejectionReason = $request->input('rejection_reason'); 
        $perdeim->user->notify(new PerdeimApplicationRejected($perdeim, Auth::user()->name, $rejectionReason,  $approverEmail));

        Alert::success('Rejected!', 'application successful rejected');
        return redirect()->back(); //Redirect user somewhere

    }

    public function managerApproveRetirement($id)
    {
        $perdeim = PerdeimRetire::findOrFail($id);
        $perdeim->statusManager = 1; //Approved
        $perdeim->save();
        $p = Perdeim::find($perdeim->perdeim_id);
        $approverEmail = Auth::user()->email;
        $p->user->notify(new PerdeimRetirementApproved(Auth::user()->name,   $approverEmail));
        Alert::success('Approved!', 'Perdeim request approved');
        return redirect()->back(); //Redirect user somewhere
    }

    public function managerDeclineRetirement(Request $request)
    {
        $perdeimId = $request->input('perdeim_retire_id');

        $perdeim = PerdeimRetire::findOrFail($perdeimId);
        $perdeim->statusManager = 0; //Declined
        $perdeim->rejection_reason = $request->input('rejection_reason');
        $perdeim->save();
        $rejectionReason = $request->input('rejection_reason');
        $p = Perdeim::find($perdeim->perdeim_id); // Assuming the rejection_reason is a column in the perdeims table
        $approverEmail = Auth::user()->email;
        $p->user->notify(new PerdeimRetirementRejected($perdeim, Auth::user()->name, $rejectionReason, $approverEmail));        
        Alert::success('Rejected!', 'application successful rejected');
        return redirect()->back(); //Redirect user somewhere

    }

    public function drView()
    {

        $perdeim = Perdeim::all();
        $perdeimRetire  = PerdeimRetire::all();
        $employee = User::select('id', 'name')->get();
        return view('perdeimApprove.drApprove', compact('perdeim', 'employee', 'perdeimRetire'));
    }

    public function drApprove($id)
    {

        $perdeim = Perdeim::findOrFail($id);
        $perdeim->statusDr = 1; //Approved
        $perdeim->num_approvals += 1; //aded 03rd
        $perdeim->drApprover = Auth::user()->name;
        $perdeim->save();
        $approverEmail = Auth::user()->email;
        $perdeim->user->notify(new PerdeimApplicationApproved($perdeim, Auth::user()->name,  $approverEmail));
        Alert::success('Approved!', 'Perdeim request approved');
        return redirect()->back(); //Redirect user somewhere
    }

    public function drDecline(Request $request)
    {
        $perdeimId = $request->input('perdeim_id');
        $perdeim = Perdeim::findOrFail($perdeimId);
        $perdeim->statusDr = 0; //Declined
        $perdeim->num_approvals += 1; //aded 03rd
        $perdeim->drApprover = Auth::user()->name;
        $perdeim->rejection_reason = $request->input('rejection_reason');
        $perdeim->save();
        $rejectionReason = $request->input('rejection_reason');
        $approverEmail = Auth::user()->email;
        $perdeim->user->notify(new PerdeimRetirementRejected($perdeim, Auth::user()->name, $rejectionReason, $approverEmail));        
        Alert::success('Rejected!', 'application successful rejected');
        return redirect()->back(); //Redirect user somewhere

    }

    public function drDeclineRetirement(Request $request)
    {
        $perdeimId = $request->input('perdeim_retire_id');

      

        $perdeim = PerdeimRetire::findOrFail($perdeimId);
        $perdeim->statusDr = 0; //Declined
        $perdeim->rejection_reason = $request->input('rejection_reason');
        $perdeim->save();
        $rejectionReason = $request->input('rejection_reason');
        $p = Perdeim::find($perdeim->perdeim_id); // Assuming the rejection_reason is a column in the perdeims table
        $approverEmail = Auth::user()->email;
        $p->user->notify(new PerdeimRetirementRejected($perdeim, Auth::user()->name, $rejectionReason, $approverEmail));        
        Alert::success('Rejected!', 'application successful rejected');
        return redirect()->back(); //Redirect user somewhere

    }

    public function edit($id)
    {
        $perdeim = Perdeim::findOrFail($id);
        return view('perdeim.edit', compact('perdeim'));
    }

    public function update(Request $request, $id)
    {
        $perdeim = Perdeim::findOrFail($id);

        // Validate the input data
        $request->validate([
            'reason' => 'required', // Add validation rules for other fields
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Update the Perdeim record
        $perdeim->update([
            'reason' => $request->input('reason'), // Update other fields here
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
        ]);
        Alert::success('Success!', 'Perdeim updated successfully');
        return redirect()->route('perdeim.index');
    }

    public function destroy($id)
    {
        $perdeim = Perdeim::findOrFail($id);
        $perdeim->delete();

        Alert::success('Success!', 'Perdeim deleted successfully');
        return redirect()->route('perdeim.index');
    }

}
