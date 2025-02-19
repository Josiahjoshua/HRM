<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Leave_application;
use App\Models\Assetlist;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employee = Employee::count();
         $leave = Leave_application::count();
            $asset = Assetlist::count();
            $user = Auth::user();
           
            
            // dd($profilePicturePath);

        return view('home', compact('employee','asset','leave','user'));
    }
}
