<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authcontroller extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();


            if ($user->is_admin) {
                return redirect()->route('admin.home');
            } else {
                Auth::logout();
                return redirect()->route('login.web')->with('error', 'Access denied.');
            }
        } else {
            return redirect()->route('login.web')->with('error', 'Invalid credentials.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.web');
    }
}
