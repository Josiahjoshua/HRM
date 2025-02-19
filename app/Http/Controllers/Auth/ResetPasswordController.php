<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class ResetPasswordController extends Controller
{

  use ResetsPasswords;
  protected $redirectTo = RouteServiceProvider::HOME;
    
public function showResetForm(Request $request, $token = null)
{
    return view('auth.passwords.reset')->with([
        'token' => $token,
        'email' => $request->email,
    ]);
}


public function reset(Request $request)
{
    // $user = Auth::user();

    $request->validate([
        'password' => 'required|min:8|confirmed',
        'email' => 'required',
    ]);
    
      $userEmail = $request->input('email');
      
      
      $newPassword = Hash::make($request->input('password'));
      

    // Check if the new password matches any of the previous passwords
    $user = User::where('email', $userEmail)->first();
      $oldPassword = $user->password;
      
     
   
        if ($newPassword === $oldPassword) {
            alert::info('password_uniqueness_error', 'The new password cannot be the same as any of the previous passwords.');
            return back();
        }
    
 
    $user->password = $newPassword;
    $user->password_reset = 1; // Set password_reset to 1 indicating password reset done
    $user->save();
    alert::success('Success', 'Password Changed Succesfully');

    return redirect()->route('home');
}

}
