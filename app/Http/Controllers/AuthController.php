<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {

        if(!empty(Auth::check())){
            if(Auth::user()->user_type == 1){
                return redirect('admin/dashboard');
            } else if(Auth::user()->user_type == 2){
                return redirect('educator/dashboard');
            } else if(Auth::user()->user_type == 3){
                return redirect('student/dashboard');
            } else if(Auth::user()->user_type == 4){
                return redirect('parent/dashboard');
            }
        };
        return view('auth.login');
    }

    public function AuthLogin(Request $request)
    {
        // $password = Hash::make($request->password);
        // dd($password);

        $remember = !empty($request->remember) ? true : false;

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)){
            if(Auth::user()->user_type == 1){
                return redirect('admin/dashboard');
            } else if(Auth::user()->user_type == 2){
                return redirect('educator/dashboard');
            } else if(Auth::user()->user_type == 3){
                return redirect('student/dashboard');
            } else if(Auth::user()->user_type == 4){
                return redirect('parent/dashboard');
            }

        }
        else{
            return redirect()->back()->with('error', 'Please enter correct email and password!');
        };
    }

    public function logout()
    {
        if(!empty(Auth::check())){
            Auth::logout();
        }
        return redirect(url(''));
    }

    public function forgotPassword() {
        return view('auth.forgot');
    }

    public function postForgotPassword(Request $request) {

        $user = User::getEmailSingle($request->email);

        if(!empty($user)){

            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', "Please check your email and reset your password.");
        }else{
            return redirect()->back()->with('error', "Email not found in the system!");
        }
        // dd($user);
    }

    public function resetPassword($remember_token) {

        $user = User::getTokenSingle($remember_token);

        if(!empty($user)){

            $data['user'] = $user;
            return view('auth.reset', $data);

        }else{
            abort(404);
        }
        // dd($remember_token);
    }

    public function postResetPassword($remember_token, Request $request) {


       if($request->password == $request->cpassword){

            $user = User::getTokenSingle($remember_token);
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();

            return redirect(url(''))->with('success', 'Password successfully changed!');
       }else{
            return redirect()->back()->with('error', "Passwords do NOT match!");
       }
    }
}
