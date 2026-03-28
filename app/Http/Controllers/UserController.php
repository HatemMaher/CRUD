<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:15',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:25',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        auth()->login($user);

        return redirect()->route('notes.index')->with('success', 'Welcome! Your account is ready.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('name', $request->name)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            auth()->login($user);

            return redirect()->route('notes.index')->with('success', 'Signed in successfully.');
        }

        return redirect()->route('login')->with('login_error', 'Invalid username or password.');
    }

    public function showLogin(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login')->with('success', 'Signed out.');
    }
}
