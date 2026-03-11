<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
    public function index()
    {
        
        if (session('user_role') !== 'manager') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado. Apenas gerentes podem acessar esta área.');
        }

        
        $users = DB::select('SELECT id, full_name, email, tax_id, role, created_at FROM users ORDER BY full_name ASC');

        return view('users.index', compact('users'));
    }

    
    public function create()
    {
        if (session('user_role') !== 'manager') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        return view('users.create');
    }

    
    public function store(Request $request)
    {
        if (session('user_role') !== 'manager') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        
        $fullName = $request->input('full_name');
        $email    = $request->input('email');
        $password = $request->input('password');
        $taxId    = $request->input('tax_id');
        $role     = $request->input('role');

        
        if (empty($fullName) || empty($email) || empty($password) || empty($taxId) || empty($role)) {
            return redirect()->back()->with('error', 'Todos os campos são obrigatórios.')->withInput();
        }

        
        $existingEmail = DB::selectOne('SELECT id FROM users WHERE email = ?', [$email]);
        if ($existingEmail) {
            return redirect()->back()->with('error', 'Este e-mail já está cadastrado.')->withInput();
        }

        
        $existingTaxId = DB::selectOne('SELECT id FROM users WHERE tax_id = ?', [$taxId]);
        if ($existingTaxId) {
            return redirect()->back()->with('error', 'Este CPF/CNPJ já está cadastrado.')->withInput();
        }

        
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        DB::insert('INSERT INTO users (full_name, email, password, tax_id, role) VALUES (?, ?, ?, ?, ?)', [
            $fullName,
            $email,
            $hashedPassword,
            $taxId,
            $role
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    
    public function edit($id)
    {
        if (session('user_role') !== 'manager') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        
        $user = DB::selectOne('SELECT * FROM users WHERE id = ?', [$id]);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Usuário não encontrado.');
        }

        return view('users.edit', compact('user'));
    }

    
    public function update(Request $request, $id)
    {
        if (session('user_role') !== 'manager') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        $fullName = $request->input('full_name');
        $email    = $request->input('email');
        $taxId    = $request->input('tax_id');
        $role     = $request->input('role');
        $newPassword = $request->input('password'); 

        if (empty($fullName) || empty($email) || empty($taxId) || empty($role)) {
            return redirect()->back()->with('error', 'Preencha todos os campos obrigatórios.')->withInput();
        }

        
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            DB::update('UPDATE users SET full_name = ?, email = ?, password = ?, tax_id = ?, role = ? WHERE id = ?', [
                $fullName, $email, $hashedPassword, $taxId, $role, $id
            ]);
        } else {
            
            DB::update('UPDATE users SET full_name = ?, email = ?, tax_id = ?, role = ? WHERE id = ?', [
                $fullName, $email, $taxId, $role, $id
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    
    public function destroy($id)
    {
        if (session('user_role') !== 'manager') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        
        if ($id == session('user_id')) {
            return redirect()->route('users.index')->with('error', 'Você não pode deletar seu próprio usuário.');
        }

        DB::delete('DELETE FROM users WHERE id = ?', [$id]);

        return redirect()->route('users.index')->with('success', 'Usuário removido com sucesso!');
    }
}
