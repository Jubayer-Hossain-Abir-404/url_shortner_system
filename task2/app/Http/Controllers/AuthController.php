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

}
