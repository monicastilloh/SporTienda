@extends('layouts.app')
@section('title', 'Pago exitoso')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-10">
        <div class="text-7xl mb-4 animate-bounce">🎉</div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">¡Pago exitoso!</h1>
        <p class="text-gray-500 mb-1">Gracias por tu compra, {{ auth()->user()->name }}</p>
        <p class="font-mono text-sm text-gray-400 mb-8">Pedido: <strong class="text-gray-700">{{ $order->order_number }}</strong></p>

        <div class="bg-gray-50 rounded-2xl p-5 text-left mb-6">
            <h2 class="font-semibold text-gray-900 mb-3 text-sm">Resumen del pedido</h2>
            <div class="space-y-2">
                @foreach($order->items as $item)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">{{ $item->product->name }} × {{ $item->quantity }}</span>
                    <span class="font-medium">${{ number_format($item->subtotal, 2) }}</span>
                </div>
                @endforeach
                <div class="border-t border-gray-200 pt-2 mt-2 space-y-1">
                    <div class="flex justify-between text-sm text-gray-500"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                    <div class="flex justify-between text-sm text-gray-500"><span>IVA 16%</span><span>${{ number_format($order->iva, 2) }}</span></div>
                    <div class="flex justify-between font-bold text-gray-900"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
                </div>
            </div>
        </div>

        <div class="flex gap-3 justify-center">
            <a href="{{ route('shop') }}" class="bg-sport-dark text-white px-8 py-3 rounded-xl font-semibold hover:bg-sport-accent transition text-sm">
                Seguir comprando
            </a>
            <a href="{{ route('cliente.pedidos') }}" class="bg-gray-100 text-gray-700 px-8 py-3 rounded-xl font-semibold hover:bg-gray-200 transition text-sm">
                Mis pedidos
            </a>
        </div>
    </div>
</div>
@endsection