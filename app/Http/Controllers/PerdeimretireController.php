<?php

namespace App\Http\Controllers;

use App\Models\Perdeim;
use App\Models\PerdeimRetire;
use App\Models\Employee;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewPerdeimRetirement; 

class PerdeimretireController extends Controller
{
    public function store(Request $request)
    {

        $perdeimretire = new PerdeimRetire();
        $perdeimretire->perdeim_id= request('perdeim_id');
        $perdeimretire->amount_used= request('amount_used');
        $path=Storage::putFile('proof',$request->file('file_url'));
        $perdeimretire->file_title= request('title');
        $perdeimretire->file_url = $path;
        
        $perdeim = Perdeim::where('id',request('perdeim_id'))->first();
        $perdeim->amount_used =  request('amount_used');
        $perdeim->retire_status =  1 ;
        $perdeim->save();
        $perdeimretire->save();
        
            // Notify users with the role "director" that the order has been confirmed
    $director = User::whereHas('roles', function ($query) {
        $query->where('name', 'director');
    })->get();

    Notification::send($director, new NewPerdeimRetirement($perdeim, Auth::User()->name));
        Alert::success('Success!', 'Retirement Successfully Saved');
        return back();
  
      }
      
      
        public function edit($id)
{
    $perdeimretire = PerdeimRetire::findOrFail($id);
  
    return view('perdeim.perdeimretire.edit', compact('perdeimretire'));
}

  public function update(Request $request, $id)
{
    $perdeimretire = PerdeimRetire::findOrFail($id);
    
    // Validate the input data
    $request->validate([
        
        'amount_used' => 'required|numeric', 
    ]);
        
       $perdeimretire->amount_used = $request->input('amount_used');
       
       if($request->hasFile('file_url')){
        $path=Storage::putFile('proof',$request->file('file_url'));
        
        $perdeimretire->file_url = $path;
       }
       $perdeimretire->file_title = $request->input('file_title');
        $perdeimretire->save();
        

    Alert::success('Success!', 'Perdeim Retire updated successfully');
    return redirect()->back();
}

     
    
    
      public function download($id)
      {

        $perdeims = PerdeimRetire::where('id', $id)->firstOrFail();
        return response()->file(storage_path('app') . DIRECTORY_SEPARATOR .$perdeims->file_url);
       
      }
      
      
      public function destroy($id)
{
    $perdeim = PerdeimRetire::findOrFail($id);
    $perdeim->delete();
     
    Alert::success('Success!', 'Perdeim Retire deleted successfully');
    return redirect()->back();
}
      
      
}
