<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function create(){
        return view('register');
    }   




    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|min:3|max:15',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:25',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        auth()->login($user);

        return redirect('/login');

    }
 
    public function login(Request $request){
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('name', $request->name)->first();
        if ($user && Hash::check($request->password, $user->password)){
            auth()->login($user);
            return redirect('/')->with('success', 'Logged in successfully!');
        }else{
            return redirect('/login')->with('login_error', 'Invalid name or password!');
        }

        return redirect('/');
    }


    public function showLogin(){
        return view('login');
    }


    public function logout(){
        auth()->logout();
        return redirect('/register')->with('success', 'Logged out successfully.');
    }

}
