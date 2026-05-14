<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index() {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $pedido) {
        $pedido->load('items.product', 'user');
        return view('admin.orders.show', compact('pedido'));
    }

    public function update(Request $request, Order $order) {
        return back();
    }

    public function updateStatus(Request $request, Order $order) {
        $request->validate(['status' => ['required','in:pendiente,pagado,enviado,entregado,cancelado']]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Estado actualizado.');
    }
}