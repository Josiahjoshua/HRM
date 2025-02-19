<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function index()
    {
  
     
      $benefit =Benefit::all();
      return view('payrol.benefit.index', compact('benefit'));
    }

    public function store(Request $request)
    {
       $benefit = new Benefit();
       $benefit->name = request('name');
       $benefit->description= request('description');
       $benefit->save();
       Alert::success('Success!', 'Successfully added');
       return back();
    }

    public function destroy($id)
   {
   
       $benefit= Benefit::findOrFail($id);
       $benefit->delete();
       Alert::success('Success!', 'Successfully deleted');
       return back();
   }

   public function edit($id)
   {

      $benefit = Benefit::findOrFail($id);
      return view('payrol.benefit.edit', compact('benefit'));

   }

   public function update(Request $request, Benefit $benefit)
   {

      $request->validate([
     'name' => 'required',
     'description' => 'required', ]);
      $benefit->update($request->all());
      Alert::success('Success!', 'Successfully updated');
      return redirect()->route('benefit.index');
  }  
      
}
