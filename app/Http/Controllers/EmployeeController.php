<?php

namespace App\Http\Controllers;
use Hash;
use App\Models\Designation;
use App\Models\Department;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required | string | max:255',
            'email' => 'required',
        ]);
        
        
        $emailExists = Employee::where('email', $request->email)->first();
        
        if($emailExists)
        {
            alert::info('Email Already Exits');
            return back();
        }

        
        $employee = new Employee();
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->em_address = $request->input('em_address');
        $employee->status = 1;
        $employee->department_id = $request->input('dep_name');
        $employee->designation_id = $request->input('des_name');
        $employee->em_gender = $request->input('gender');
        $employee->em_phone = $request->input('em_phone');
        $employee->start_date = $request->input('start_date');
        $employee->dob = $request->input('dob');
        $path=Storage::putFile('contract',$request->file('contract'));
        $employee->contract = $path;
        $employee->save();

        

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'department_id'=> $request->dep_name, 
             'password' => Hash::make($request->email),
            'password_reset' => $request->password_reset == 1,
        ]);
        toast('Successfully added!','success');
        return back();
    }
    public function index()
    {

        $employee = Employee::all();

        return view('employee.index', compact('employee'));
    }
    public function create()
    {
        $employees = Department::select('id', 'dep_name')->get();
        $value = Designation::select('id', 'des_name')->get();
        return view('employee.create', [
            'employees' => $employees,
            'value' => $value,
        ]);
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $department  = Department::select('id', 'dep_name')->get();
        $designation = Designation::select('id', 'des_name')->get();
        return view('employee.edit', [ 'employee' => $employee, 'department' => $department , 'designation' => $designation,
            $id,
        ]);
    }
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::where('name', $employee->name)->first();
        $employee->name = request('name');
        $employee->email = request('email');
        $employee->em_address = request('em_address');
        $employee->department_id = request('dep_name');
        $employee->designation_id = request('des_name');
        $employee->em_gender = request('gender');
        $employee->em_phone = request('em_phone');
        $employee->start_date = $request->input('start_date');
        $employee->dob = $request->input('dob');

        if($request->input('contract'))
        {
            $path=Storage::putFile('contract',$request->file('contract'));

        }
        if ($employee->end_date = request('end_date')) {
            $employee->status = 0;
            $employee->end_date = request('end_date');
        }
       

        $user->name = request('name');
        $user->email = request('email');
        $user->department_id = $request->input('dep_name');
        $user->save();
        
        $employee->update();
        
        toast('Successfully updated!','success');
        return redirect()->route('employee.index');

    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::where('name', $employee->name)->first();
        $user->delete();
        $employee->delete();
        Alert::success('Success!', 'Successfully deleted');
       return redirect()->route('employee.index');

    }

    public function downloadContract($id)
    {
  
      $contract= Employee::where('id', $id)->firstOrFail();
      return response()->file(storage_path('app') . DIRECTORY_SEPARATOR . $contract->contract);  
    }

}
