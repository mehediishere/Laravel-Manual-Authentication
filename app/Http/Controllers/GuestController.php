<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class GuestController extends Controller
{
    //=== Login

    public function viewLogin(){
        return view('login');
    }

    public function userLoginBtn(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('user_email', Auth::user()->email);
            return redirect()->intended('profile');
        }

        return back()->withErrors([
            'error_message' => 'The provided credentials do not match our records.',
        ]);
    }

    //=== Registration

    public function viewRegistration(){
        return view('registration');
    }

    public function userRegistrationBtn(Request $request){
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', "Registration successful!!");
    }
}
