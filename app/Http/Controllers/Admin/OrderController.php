<?php
namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller {
    public function index() {
        $orders = Order::where('user_id', Auth::id())->with('items.product')->latest()->paginate(10);
        return view('cliente.orders', compact('orders'));
    }

    public function show(Order $order) {
        if ($order->user_id !== Auth::id()) abort(403);
        $order->load('items.product');
        return view('cliente.order-detail', compact('order'));
    }
}