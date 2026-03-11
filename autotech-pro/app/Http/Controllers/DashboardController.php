<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        
        $userRole = session('user_role');

        
        
        $totalOrders = DB::selectOne('SELECT COUNT(*) as total FROM service_orders');
        $ordersReceived = DB::selectOne("SELECT COUNT(*) as total FROM service_orders WHERE status = 'received'");
        $ordersInRepair = DB::selectOne("SELECT COUNT(*) as total FROM service_orders WHERE status = 'in_repair'");
        $ordersReady = DB::selectOne("SELECT COUNT(*) as total FROM service_orders WHERE status = 'ready'");
        $ordersAwaitingApproval = DB::selectOne("SELECT COUNT(*) as total FROM service_orders WHERE status = 'awaiting_approval'");

        
        $totalCustomers = DB::selectOne("SELECT COUNT(*) as total FROM users WHERE role = 'customer'");

        
        $totalVehicles = DB::selectOne('SELECT COUNT(*) as total FROM vehicles');

        
        
        $recentOrders = DB::select('
            SELECT
                so.id,
                so.status,
                so.opened_at,
                v.license_plate,
                v.brand,
                v.model,
                u.full_name as customer_name
            FROM service_orders so
            JOIN vehicles v ON so.vehicle_id = v.id
            JOIN users u ON v.customer_id = u.id
            ORDER BY so.opened_at DESC
            LIMIT 5
        ');

        
        $lowStockParts = DB::select('SELECT * FROM parts WHERE stock_quantity < 5 ORDER BY stock_quantity ASC');

        return view('dashboard.index', compact(
            'userRole',
            'totalOrders',
            'ordersReceived',
            'ordersInRepair',
            'ordersReady',
            'ordersAwaitingApproval',
            'totalCustomers',
            'totalVehicles',
            'recentOrders',
            'lowStockParts'
        ));
    }
}
