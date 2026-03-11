<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesCatalogController extends Controller
{
    
    public function index()
    {
        $services = DB::select('SELECT * FROM services_catalog ORDER BY description ASC');
        return view('services-catalog.index', compact('services'));
    }

    
    public function create()
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['manager', 'attendant'])) {
            return redirect()->route('services.index')->with('error', 'Acesso negado.');
        }

        return view('services-catalog.create');
    }

    
    public function store(Request $request)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['manager', 'attendant'])) {
            return redirect()->route('services.index')->with('error', 'Acesso negado.');
        }

        $description = $request->input('description');
        $hourlyRate  = $request->input('hourly_rate');

        if (empty($description) || empty($hourlyRate)) {
            return redirect()->back()->with('error', 'Todos os campos são obrigatórios.')->withInput();
        }

        DB::insert('INSERT INTO services_catalog (description, hourly_rate) VALUES (?, ?)', [
            $description, $hourlyRate
        ]);

        return redirect()->route('services.index')->with('success', 'Serviço cadastrado com sucesso!');
    }

    
    public function edit($id)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['manager', 'attendant'])) {
            return redirect()->route('services.index')->with('error', 'Acesso negado.');
        }

        $service = DB::selectOne('SELECT * FROM services_catalog WHERE id = ?', [$id]);

        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Serviço não encontrado.');
        }

        return view('services-catalog.edit', compact('service'));
    }

    
    public function update(Request $request, $id)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['manager', 'attendant'])) {
            return redirect()->route('services.index')->with('error', 'Acesso negado.');
        }

        $description = $request->input('description');
        $hourlyRate  = $request->input('hourly_rate');

        if (empty($description) || empty($hourlyRate)) {
            return redirect()->back()->with('error', 'Todos os campos são obrigatórios.')->withInput();
        }

        DB::update('UPDATE services_catalog SET description = ?, hourly_rate = ? WHERE id = ?', [
            $description, $hourlyRate, $id
        ]);

        return redirect()->route('services.index')->with('success', 'Serviço atualizado!');
    }

    
    public function destroy($id)
    {
        if (session('user_role') !== 'manager') {
            return redirect()->route('services.index')->with('error', 'Apenas gerentes podem remover serviços.');
        }

        DB::delete('DELETE FROM services_catalog WHERE id = ?', [$id]);

        return redirect()->route('services.index')->with('success', 'Serviço removido!');
    }
}
