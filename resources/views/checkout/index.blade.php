@extends('layouts.app')
@section('title', 'Pago')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">💳 Finalizar compra</h1>

    <div class="flex gap-6 items-start">
        <!-- Pago solo PayPal -->
        <div class="flex-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-semibold text-gray-900 mb-5">Método de pago</h2>

                <div class="text-center py-8">
                    <div class="text-6xl mb-4">🅿️</div>
                    <p class="text-gray-500 text-sm mb-2 font-medium">Pago seguro con PayPal</p>
                    <p class="text-gray-400 text-xs mb-8">Serás redirigido a PayPal para completar tu pago de forma segura. Puedes pagar con tu cuenta PayPal o con tarjeta a través de PayPal.</p>
                    <a href="{{ route('checkout.paypal') }}"
                       class="inline-block bg-yellow-400 text-sport-dark font-bold px-10 py-4 rounded-xl hover:bg-yellow-300 transition text-base">
                        Pagar ${{ number_format($total, 2) }} MXN con PayPal
                    </a>
                    <p class="text-xs text-gray-400 mt-4">🔒 Pago 100% seguro y encriptado</p>
                </div>
            </div>
        </div>

        <!-- Resumen -->
        <div class="w-80 flex-shrink-0">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h2 class="font-semibold text-gray-900 mb-4">Tu pedido</h2>
                <div class="space-y-2 mb-4">
                    @foreach($items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 truncate max-w-40">{{ $item->product->name }} × {{ $item->quantity }}</span>
                            <span class="font-medium">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-100 pt-3 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-500"><span>Subtotal</span><span>${{ number_format($subtotal, 2) }}</span></div>
                    <div class="flex justify-between text-gray-500"><span>IVA 16%</span><span>${{ number_format($iva, 2) }}</span></div>
                    <div class="flex justify-between font-bold text-gray-900 text-base pt-1 border-t border-gray-100">
                        <span>Total</span><span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>
                <a href="{{ route('cart.index') }}" class="mt-4 block text-center text-sm text-gray-400 hover:text-gray-600 transition">
                    ← Volver al carrito
                </a>
            </div>
        </div>
    </div>
</div>
@endsection