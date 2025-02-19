<?php

namespace App\Http\Controllers;
use App\Models\Deduction;
use App\Models\Employee;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeductionController extends Controller
{
    public function index()
    {

      $deduction = Deduction::all();
      return view('payrol.deduction.index', compact('deduction'));
    }

    public function store(Request $request)
    { 

      $deduction = new Deduction();
      $deduction->name = request('name');
      $deduction->description= request('description');
      $deduction->save();
      Alert::success('Success!', 'Successfully added');
      return back();
    }
      
    public function destroy($id)
    {

      $deduction= Deduction::findOrFail($id);
      $deduction->delete();
      Alert::success('Success!', 'Successfully deleted');
      return back();
    }

   public function edit($id)
   {   

      $deduct=Deduction::findOrFail($id);
      return view('payrol.deduction.edit', compact('deduct'));
   }

   public function update(Request $request, $id)
   {
      $deduction= Deduction::findOrFail($id);
      $deduction->name=request('name');
      $deduction->description=request('description');
      $deduction->save();
      Alert::success('Success!', 'Successfully updated');
      return redirect()->route('deductionChange.index');
      
  }
    
}
