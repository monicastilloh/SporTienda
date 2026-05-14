<?php
namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller {
    public function index() {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('empleado.orders.index', compact('orders'));
    }
}