<?php

namespace App\Http\Controllers;
use App\Models\Material;
use App\Models\Product;
use App\Models\Casual;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CasualController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   $casual= Casual::all();
        return view('employee.casualWorkers', compact('casual'));
    }

    public function store(Request $request)
    {
        $path = Storage::disk('public')->putFile('images', $request->file('em_image'));
        $path2 = Storage::disk('public')->putFile('images', $request->file('id_card'));
        $validatedData = $request->validate([
            'worker_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'location' => 'required',
            'phone' => 'required',
          
        ]);

        $casual = new Casual();
        $casual->worker_name = $request->input('worker_name');
        $casual->amount = $request->input('amount');
        $casual->phone= $request->input('phone');
        $casual->location = $request->input('location');
        $casual->end_date= $request->input('end_date');
        $casual->start_date= $request->input('start_date');
        $casual->em_image = $path;
        $casual->id_card= $path2;
        $casual->save();
        toast('Successfully added!', 'success');
        return back();
        
    }
    
    public function edit($id)
{
        $casual = Casual::findOrFail($id);

   return view('employee.editCasualWorker', compact('casual'));
}

public function update(Request $request,$id)

{
        $casual = Casual::findOrFail($id);
        $casual->worker_name = $request->input('worker_name');
        $casual->amount = $request->input('amount');
        $casual->phone= $request->input('phone');
        $casual->location = $request->input('location');
        $casual->end_date= $request->input('end_date');
        $casual->start_date= $request->input('start_date');
    $casual->update();
   Alert::success('Success!', 'Successfully updated');
   return redirect()->route('casual.index'); 
}
    public function destroy($id)
    {
        $casual = Casual::findOrFail($id);
        $casual->delete();
        Alert::success('Success!', 'Successfully deleted');
        return back();
}
}