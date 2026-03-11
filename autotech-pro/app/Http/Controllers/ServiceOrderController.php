<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends Controller
{
    
    public function index()
    {
        $userRole = session('user_role');
        $userId   = session('user_id');

        
        if ($userRole === 'mechanic') {
            $orders = DB::select('
                SELECT
                    so.*,
                    v.license_plate, v.brand, v.model,
                    u.full_name as customer_name,
                    ua.full_name as attendant_name
                FROM service_orders so
                JOIN vehicles v ON so.vehicle_id = v.id
                JOIN users u ON v.customer_id = u.id
                JOIN users ua ON so.attendant_id = ua.id
                WHERE so.mechanic_id = ?
                ORDER BY so.opened_at DESC
            ', [$userId]);
        } elseif ($userRole === 'customer') {
            
            $orders = DB::select('
                SELECT
                    so.*,
                    v.license_plate, v.brand, v.model,
                    u.full_name as customer_name,
                    ua.full_name as attendant_name
                FROM service_orders so
                JOIN vehicles v ON so.vehicle_id = v.id
                JOIN users u ON v.customer_id = u.id
                JOIN users ua ON so.attendant_id = ua.id
                WHERE u.id = ?
                ORDER BY so.opened_at DESC
            ', [$userId]);
        } else {
            
            $orders = DB::select('
                SELECT
                    so.*,
                    v.license_plate, v.brand, v.model,
                    u.full_name as customer_name,
                    ua.full_name as attendant_name
                FROM service_orders so
                JOIN vehicles v ON so.vehicle_id = v.id
                JOIN users u ON v.customer_id = u.id
                JOIN users ua ON so.attendant_id = ua.id
                ORDER BY so.opened_at DESC
            ');
        }

        return view('service-orders.index', compact('orders'));
    }

    
    public function create()
    {
        
        $userRole = session('user_role');
        if (!in_array($userRole, ['attendant', 'manager'])) {
            return redirect()->route('orders.index')->with('error', 'Apenas atendentes podem abrir ordens de serviço.');
        }

        
        $vehicles = DB::select('
            SELECT v.id, v.license_plate, v.brand, v.model, u.full_name as customer_name
            FROM vehicles v
            JOIN users u ON v.customer_id = u.id
            ORDER BY v.license_plate
        ');

        
        $mechanics = DB::select("SELECT id, full_name FROM users WHERE role = 'mechanic' ORDER BY full_name");

        return view('service-orders.create', compact('vehicles', 'mechanics'));
    }

    
    public function store(Request $request)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['attendant', 'manager'])) {
            return redirect()->route('orders.index')->with('error', 'Acesso negado.');
        }

        $vehicleId       = $request->input('vehicle_id');
        $mechanicId      = $request->input('mechanic_id');
        $customerSymptoms = $request->input('customer_symptoms');
        $attendantId     = session('user_id');

        if (empty($vehicleId) || empty($customerSymptoms)) {
            return redirect()->back()->with('error', 'Veículo e sintomas são obrigatórios.')->withInput();
        }

        DB::insert('
            INSERT INTO service_orders (vehicle_id, attendant_id, mechanic_id, customer_symptoms, status)
            VALUES (?, ?, ?, ?, \'received\')
        ', [$vehicleId, $attendantId, $mechanicId ?: null, $customerSymptoms]);

        return redirect()->route('orders.index')->with('success', 'Ordem de Serviço aberta com sucesso!');
    }

    
    public function show($id)
    {
        
        $order = DB::selectOne('
            SELECT
                so.*,
                v.license_plate, v.brand, v.model, v.fipe_code,
                u.full_name as customer_name,
                ua.full_name as attendant_name,
                um.full_name as mechanic_name
            FROM service_orders so
            JOIN vehicles v ON so.vehicle_id = v.id
            JOIN users u ON v.customer_id = u.id
            JOIN users ua ON so.attendant_id = ua.id
            LEFT JOIN users um ON so.mechanic_id = um.id
            WHERE so.id = ?
        ', [$id]);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Ordem de serviço não encontrada.');
        }

        
        $photos = DB::select('SELECT * FROM order_photos WHERE order_id = ?', [$id]);

        
        $entryPhotos = [];
        $exitPhotos  = [];
        foreach ($photos as $photo) {
            if ($photo->entry_exit === 'entry') {
                $entryPhotos[] = $photo;
            } else {
                $exitPhotos[] = $photo;
            }
        }

        
        $mechanics = DB::select("SELECT id, full_name FROM users WHERE role = 'mechanic' ORDER BY full_name");

        return view('service-orders.show', compact('order', 'entryPhotos', 'exitPhotos', 'mechanics'));
    }

    
    public function edit($id)
    {
        $order = DB::selectOne('SELECT * FROM service_orders WHERE id = ?', [$id]);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Ordem não encontrada.');
        }

        $mechanics = DB::select("SELECT id, full_name FROM users WHERE role = 'mechanic' ORDER BY full_name");

        return view('service-orders.edit', compact('order', 'mechanics'));
    }

    
    public function update(Request $request, $id)
    {
        $mechanicDiagnosis = $request->input('mechanic_diagnosis');
        $mechanicId        = $request->input('mechanic_id');

        DB::update('UPDATE service_orders SET mechanic_diagnosis = ?, mechanic_id = ? WHERE id = ?', [
            $mechanicDiagnosis, $mechanicId, $id
        ]);

        return redirect()->route('orders.show', $id)->with('success', 'Diagnóstico atualizado!');
    }

    
    
    public function updateStatus(Request $request, $id)
    {
        $newStatus = $request->input('status');
        $userRole  = session('user_role');

        
        $validStatuses = ['received', 'diagnostic', 'awaiting_approval', 'in_repair', 'ready', 'delivered'];

        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->back()->with('error', 'Status inválido.');
        }

        
        if ($newStatus === 'delivered') {
            
            $warrantyExpiry = date('Y-m-d', strtotime('+90 days'));

            DB::update('UPDATE service_orders SET status = ?, labor_warranty_expiry = ? WHERE id = ?', [
                $newStatus, $warrantyExpiry, $id
            ]);
        } elseif ($newStatus === 'in_repair') {
            
            DB::update('UPDATE service_orders SET status = ?, customer_approval = TRUE WHERE id = ?', [
                $newStatus, $id
            ]);
        } else {
            DB::update('UPDATE service_orders SET status = ? WHERE id = ?', [
                $newStatus, $id
            ]);
        }

        return redirect()->route('orders.show', $id)->with('success', 'Status da OS atualizado!');
    }

    
    public function uploadPhotos(Request $request, $id)
    {
        $entryExit = $request->input('entry_exit'); 
        $position  = $request->input('position');   

        
        if (!$request->hasFile('photo')) {
            return redirect()->back()->with('error', 'Nenhuma foto foi selecionada.');
        }

        $file = $request->file('photo');

        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Apenas imagens JPG e PNG são aceitas.');
        }

        
        $fileName = time() . '_' . $file->getClientOriginalName();

        
        $file->move(public_path('uploads/orders/' . $id), $fileName);

        
        $photoUrl = 'uploads/orders/' . $id . '/' . $fileName;

        DB::insert('INSERT INTO order_photos (order_id, photo_url, entry_exit, position) VALUES (?, ?, ?, ?)', [
            $id, $photoUrl, $entryExit, $position
        ]);

        return redirect()->route('orders.show', $id)->with('success', 'Foto adicionada com sucesso!');
    }
}
