<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Product, Order, Category};

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'usuarios'   => User::count(),
            'productos'  => Product::count(),
            'pedidos'    => Order::count(),
            'ventas'     => Order::where('status', 'pagado')->sum('total'),
            'empleados'  => User::where('role', 'empleado')->count(),
            'clientes'   => User::where('role', 'cliente')->count(),
            'sin_stock'  => Product::where('stock', 0)->count(),
            'hoy'        => Order::whereDate('created_at', today())->count(),
        ];

        $recientes = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recientes'));
    }
}