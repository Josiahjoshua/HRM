<?php

namespace App\Http\Controllers;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        
        $dep = new Department();
        $dep->dep_name = $request->input('dep_name');
        $dep->save();
        toast('Successfully added!','success');
        return back();
    }
    public function index()
    {
        

        $dep = Department::all();

        return view('organization.department.index', compact('dep'));
    }

    public function edit($id)
    {

        $dep = Department::findOrFail($id);
        return view('organization.department.edit_dep', compact('dep'));
    }

    public function update(Request $request, $id)
    {
 
        $validatedData = $request->validate([
            'dep_name' => 'required',
        ]);

        Department::whereId($id)->update($validatedData);
        toast('Successfully update!','success');
        return redirect('/department');
    }

    public function destroy($id)
    {
  
        $dep = Department::findOrFail($id);
        $dep->delete();
        toast('Successfully deleted!','success');
        return redirect(route('department.index'));
    }

    public function show(Department $dep)
    {

        return view('organization.department.index', compact('dep'));
    }
}
