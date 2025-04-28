<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|string|email|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome deve ter no máximo 20 caracteres.',
            'email.max' => 'O campo email deve ter no máximo 20 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.unique' => 'Esse email já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('welcome')->with('success','User created successfully. You can now login.');



    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ], );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Welcome back, ' . Auth::user()->name);
        }

        return back()->withErrors([
            'error' => 'Usuário ou senha incorretos.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}