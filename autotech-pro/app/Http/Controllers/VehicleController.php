<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    
    public function index()
    {
        $userRole = session('user_role');

        
        if ($userRole === 'customer') {
            $userId = session('user_id');
            $vehicles = DB::select('
                SELECT v.*, u.full_name as customer_name
                FROM vehicles v
                JOIN users u ON v.customer_id = u.id
                WHERE v.customer_id = ?
                ORDER BY v.brand, v.model
            ', [$userId]);
        } else {
            
            $vehicles = DB::select('
                SELECT v.*, u.full_name as customer_name
                FROM vehicles v
                JOIN users u ON v.customer_id = u.id
                ORDER BY v.brand, v.model
            ');
        }

        return view('vehicles.index', compact('vehicles'));
    }

    
    public function create()
    {
        
        $customers = DB::select("SELECT id, full_name, tax_id FROM users WHERE role = 'customer' ORDER BY full_name");

        return view('vehicles.create', compact('customers'));
    }

    
    public function store(Request $request)
    {
        $customerId   = $request->input('customer_id');
        $licensePlate = $request->input('license_plate');
        $brand        = $request->input('brand');
        $model        = $request->input('model');
        $fipeCode     = $request->input('fipe_code');

        
        if (empty($customerId) || empty($licensePlate)) {
            return redirect()->back()->with('error', 'Cliente e placa são obrigatórios.')->withInput();
        }

        
        $licensePlate = strtoupper(trim($licensePlate));

        
        $existingPlate = DB::selectOne('SELECT id FROM vehicles WHERE license_plate = ?', [$licensePlate]);
        if ($existingPlate) {
            return redirect()->back()->with('error', 'Esta placa já está cadastrada no sistema.')->withInput();
        }

        DB::insert('INSERT INTO vehicles (customer_id, license_plate, brand, model, fipe_code) VALUES (?, ?, ?, ?, ?)', [
            $customerId,
            $licensePlate,
            $brand,
            $model,
            $fipeCode
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    
    public function show($id)
    {
        
        $vehicle = DB::selectOne('
            SELECT v.*, u.full_name as customer_name, u.email as customer_email
            FROM vehicles v
            JOIN users u ON v.customer_id = u.id
            WHERE v.id = ?
        ', [$id]);

        if (!$vehicle) {
            return redirect()->route('vehicles.index')->with('error', 'Veículo não encontrado.');
        }

        
        $orders = DB::select('
            SELECT so.*, ua.full_name as attendant_name
            FROM service_orders so
            JOIN users ua ON so.attendant_id = ua.id
            WHERE so.vehicle_id = ?
            ORDER BY so.opened_at DESC
        ', [$id]);

        return view('vehicles.show', compact('vehicle', 'orders'));
    }

    
    public function edit($id)
    {
        $vehicle = DB::selectOne('SELECT * FROM vehicles WHERE id = ?', [$id]);

        if (!$vehicle) {
            return redirect()->route('vehicles.index')->with('error', 'Veículo não encontrado.');
        }

        $customers = DB::select("SELECT id, full_name, tax_id FROM users WHERE role = 'customer' ORDER BY full_name");

        return view('vehicles.edit', compact('vehicle', 'customers'));
    }

    
    public function update(Request $request, $id)
    {
        $customerId   = $request->input('customer_id');
        $licensePlate = strtoupper(trim($request->input('license_plate')));
        $brand        = $request->input('brand');
        $model        = $request->input('model');
        $fipeCode     = $request->input('fipe_code');

        if (empty($customerId) || empty($licensePlate)) {
            return redirect()->back()->with('error', 'Cliente e placa são obrigatórios.')->withInput();
        }

        DB::update('UPDATE vehicles SET customer_id = ?, license_plate = ?, brand = ?, model = ?, fipe_code = ? WHERE id = ?', [
            $customerId, $licensePlate, $brand, $model, $fipeCode, $id
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Veículo atualizado com sucesso!');
    }
}
