<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function submitRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email,except,id',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()){
            return redirect()->back()->with('success', 'Registration Complete');
        }

        return redirect()->back()->with('error', 'Registration Failed');
    }


    public function submitLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password], request()->remember)) {
            return back()->with('status', "Credential Wrong or Something went Wrong !!!");
        }
        return redirect()->route('home');
    }


    public function logout()
    {
        auth()->logout();

        return redirect()->route('home');
    }

}
