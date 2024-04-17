<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Mail;

class AuthController extends Controller
{
    public function login()
    {
        if (!empty(Auth::check())) {
                        if(Auth::user()->user_type==1)
            {
                return redirect('admin/dashboard');
            }
            else if(Auth::user()->user_type==2)
            {
                return redirect('teacher/dashboard');
            }
            else if(Auth::user()->user_type==3)
            {
                return redirect('student/dashboard');
            }
            else if(Auth::user()->user_type==4)
            {
                return redirect('parent/dashboard');
            }
        }
        return view('auth.login');
    }

     public function AuthLogin(Request $request)
    {
           // dd($request->all());
        $remember = !empty($request->remember) ? true : false;
        
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
          
            if(Auth::user()->user_type== 1)
            {
                return redirect('admin/dashboard');
            }
            else if(Auth::user()->user_type== 2)
            {
                return redirect('teacher/dashboard');
            }
            else if(Auth::user()->user_type== 3)
            {
                return redirect('student/dashboard');
            }
            else if(Auth::user()->user_type== 4)
            {
                return redirect('parent/dashboard');
            }
        } 
        else
        {        
            return redirect()->back()->with('error', 'Please enter correct email and password');
        }
    }
    public function forgotpassword ()
    {
        return view('auth.forgot');

    }
    public function PostForgotPassword(Request $request)
    {
        $user = User::getEmailSingle($request->email);
        if(!empty($user))
        {
            $user->remember
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

        }
        else{
            return redirect()->back()->with('error', "Email is not found in the system.");
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }
}
