<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    
    public function showLogin()
    {
        
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    
    public function doLogin(Request $request)
    {
        
        $email = $request->input('email');
        $password = $request->input('password');

        
        if (empty($email) || empty($password)) {
            return redirect()->route('login')->with('error', 'Por favor, preencha todos os campos.');
        }

        
        
        $user = DB::selectOne('SELECT * FROM users WHERE email = ?', [$email]);

        
        if (!$user) {
            return redirect()->route('login')->with('error', 'E-mail ou senha incorretos.');
        }

        
        
        if (!password_verify($password, $user->password)) {
            return redirect()->route('login')->with('error', 'E-mail ou senha incorretos.');
        }

        
        session([
            'user_id'   => $user->id,
            'user_name' => $user->full_name,
            'user_role' => $user->role,
            'user_email'=> $user->email,
        ]);

        return redirect()->route('dashboard')->with('success', 'Bem-vindo, ' . $user->full_name . '!');
    }

    
    public function doLogout()
    {
        
        session()->flush();

        return redirect()->route('login')->with('success', 'Você saiu do sistema com sucesso.');
    }
}
