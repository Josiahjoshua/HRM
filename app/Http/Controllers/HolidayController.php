<?php

namespace App\Http\Controllers;
use App\Models\Holiday;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    public function index()
  {
  
    $holiday = Holiday::all();

    return view('leave.holiday.index', compact('holiday'));
  }
  public function store(Request $request)
    {
      
      $holiday = new Holiday();
      $holiday->name = request('holiname');
      $holiday->date= request('date');
      $holiday->save();
      Alert::success('Success!', 'Successfully added');
      return back();
    }
  public function destroy($id)
    {

    $holiday = Holiday::findOrFail($id);
    $holiday->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
    }

  public function edit($id)
  {

    $holiday = Holiday::findOrFail($id);
    return view('leave.holiday.edit', compact('holiday'));
  }

  public function update(Request $request, Holiday $holiday)
  {

      $request->validate([
          'name' => 'required',
          'date' => 'required',
      ]);   
      $holiday->update($request->all());
      Alert::success('Success!', 'Successfully updated');
      return redirect()->route('holiday.index');
  }

}
