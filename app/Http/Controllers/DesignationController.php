<?php

namespace App\Http\Controllers;
use App\Models\Designation;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DesignationController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }
    public function store(Request $request)
    {
   
        $des = new Designation();
        $des->des_name = request('des_name');
        $des->save();
        Alert::success('Success!', 'Successfully added');
        return back();
  
      }
      public function index()
    {
   
      $des = Designation::all();
  
      return view('organization.designation.index', compact('des'));
    }
  
    public function edit($id)
    {
   
      $des = Designation::findOrFail($id);
  
      return view('organization.designation.edit', compact('des'));
    }
    public function update(Request $request, $id)
    {
  
  $validatedData =  $request->validate([
      'des_name' => 'required',
      
  ]);
  
  Designation::whereId($id)->update($validatedData);
  Alert::success('Success!', 'Successfully updated');
  return redirect('/designation');
    }
  
    public function destroy($id)
    {
 
      $des = Designation::findOrFail($id);
      $des->delete();
      Alert::success('Success!', 'Successfully deleted');
      return redirect(route('designation.index'));

    }
    public function show(Designation $des)
    {

      return view('organization.designation.index', compact('des'));
    } 
  
}
