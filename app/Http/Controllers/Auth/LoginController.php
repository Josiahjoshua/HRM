<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

   public function authenticated(Request $request, $user)
{
    if (!$user->password_reset) {
        $token = $this->generatePasswordResetToken($user);
        return redirect()->route('password.reset', ['token' => $token]);
    }

    // User has already reset the password, proceed with the regular flow
    return redirect()->intended($this->redirectPath());
}

private function generatePasswordResetToken($user)
{
    return app('auth.password.broker')->getRepository()->create($user);
}

}
