<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartController extends Controller
{
    
    public function index()
    {
        $parts = DB::select('SELECT * FROM parts ORDER BY name ASC');
        return view('parts.index', compact('parts'));
    }

    
    public function create()
    {
        
        $userRole = session('user_role');
        if (!in_array($userRole, ['manager', 'attendant'])) {
            return redirect()->route('parts.index')->with('error', 'Acesso negado.');
        }

        return view('parts.create');
    }

    
    public function store(Request $request)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['manager', 'attendant'])) {
            return redirect()->route('parts.index')->with('error', 'Acesso negado.');
        }

        $name                    = $request->input('name');
        $costPrice               = $request->input('cost_price');
        $salePrice               = $request->input('sale_price');
        $stockQuantity           = $request->input('stock_quantity');
        $manufacturerWarranty    = $request->input('manufacturer_warranty_months');

        if (empty($name) || empty($costPrice) || empty($salePrice) || empty($stockQuantity)) {
            return redirect()->back()->with('error', 'Preencha todos os campos obrigatórios.')->withInput();
        }

        
        if ($salePrice <= $costPrice) {
            return redirect()->back()->with('error', 'O preço de venda deve ser maior que o preço de custo.')->withInput();
        }

        DB::insert('
            INSERT INTO parts (name, cost_price, sale_price, stock_quantity, manufacturer_warranty_months)
            VALUES (?, ?, ?, ?, ?)
        ', [$name, $costPrice, $salePrice, $stockQuantity, $manufacturerWarranty ?? 3]);

        return redirect()->route('parts.index')->with('success', 'Peça cadastrada com sucesso!');
    }

    
    public function edit($id)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['manager', 'attendant'])) {
            return redirect()->route('parts.index')->with('error', 'Acesso negado.');
        }

        $part = DB::selectOne('SELECT * FROM parts WHERE id = ?', [$id]);

        if (!$part) {
            return redirect()->route('parts.index')->with('error', 'Peça não encontrada.');
        }

        return view('parts.edit', compact('part'));
    }

    
    public function update(Request $request, $id)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['manager', 'attendant'])) {
            return redirect()->route('parts.index')->with('error', 'Acesso negado.');
        }

        $name                 = $request->input('name');
        $costPrice            = $request->input('cost_price');
        $salePrice            = $request->input('sale_price');
        $stockQuantity        = $request->input('stock_quantity');
        $manufacturerWarranty = $request->input('manufacturer_warranty_months');

        if (empty($name) || empty($costPrice) || empty($salePrice) || empty($stockQuantity)) {
            return redirect()->back()->with('error', 'Preencha todos os campos obrigatórios.')->withInput();
        }

        DB::update('
            UPDATE parts SET name = ?, cost_price = ?, sale_price = ?, stock_quantity = ?, manufacturer_warranty_months = ?
            WHERE id = ?
        ', [$name, $costPrice, $salePrice, $stockQuantity, $manufacturerWarranty, $id]);

        return redirect()->route('parts.index')->with('success', 'Peça atualizada com sucesso!');
    }

    
    public function destroy($id)
    {
        $userRole = session('user_role');
        if ($userRole !== 'manager') {
            return redirect()->route('parts.index')->with('error', 'Apenas gerentes podem remover peças.');
        }

        DB::delete('DELETE FROM parts WHERE id = ?', [$id]);

        return redirect()->route('parts.index')->with('success', 'Peça removida do estoque!');
    }
}
