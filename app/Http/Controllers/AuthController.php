<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (!empty(Auth::check())) {
            return redirect('admin/dashboard');
        }
        return view('auth.login');
    }

     public function AuthLogin(Request $request)
    {
           // dd($request->all());
        $remember = !empty($request->remember) ? true : false;
        
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
          
            return redirect('admin/dashboard');
        } 
        else
        {        
            return redirect()->back()->with('error', 'Please enter correct email and password');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }
}
