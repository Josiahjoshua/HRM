<?php

namespace App\Http\Controllers;
use App\Models\Perdeim;
use App\Models\PerdeimRetire;
use App\Models\Employee;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class PerdeimRetireViewController extends Controller
{
    public function store(Request $request)
    {
  
        $perdeimretire = new PerdeimRetire();
        $perdeimretire->perdeim_id= request('perdeim_id');
        $perdeimretire->amount_used= request('amount_used');
        $path=Storage::putFile('proof',$request->file('file_url'));
        $perdeimretire->file_title= request('title');
        $perdeimretire->file_url = $path;
        $perdeimretire->save();
        Alert::success('Success!', 'Successfully added');
        return back();
  
      }
}
