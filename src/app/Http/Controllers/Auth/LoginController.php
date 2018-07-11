<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    protected function sendLoginResponse(\Illuminate\Http\Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        return response()->json(\Auth::user());
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return $request->session()->token();
    }
}
