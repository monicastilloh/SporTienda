@extends('layouts.app')
@section('title', 'Detalle del Pedido')

@section('content')
@php $colors=['pendiente'=>'yellow','pagado'=>'green','enviado'=>'blue','entregado'=>'emerald','cancelado'=>'red']; @endphp

<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('cliente.pedidos') }}" class="text-gray-400 hover:text-gray-600 transition">← Mis pedidos</a>
        <h1 class="text-xl font-bold text-gray-900">Pedido {{ $order->order_number }}</h1>
        <span class="bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700 px-3 py-1 rounded-full text-xs font-semibold">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <!-- Info del pedido -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Fecha del pedido</p>
            <p class="font-semibold text-gray-900">{{ $order->created_at->format('d \d\e F Y') }}</p>
            <p class="text-sm text-gray-500">{{ $order->created_at->format('H:i') }} hrs</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Método de pago</p>
            <p class="font-semibold text-gray-900">
                {{ $order->payment_method === 'paypal' ? '🅿️ PayPal' : '💳 Tarjeta' }}
            </p>
            @if($order->paid_at)
                <p class="text-sm text-green-600">✅ Pagado el {{ $order->paid_at->format('d/m/Y') }}</p>
            @endif
        </div>
    </div>

    <!-- Productos -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-50">
            <h2 class="font-semibold text-gray-900">Productos</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($order->items as $item)
            <div class="px-6 py-4 flex items-center gap-4">
                <div class="w-16 h-16 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0">
                    @if($item->product->image)
                        <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover" alt="">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-2xl">🏅</div>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                    <p class="text-sm text-gray-400">{{ $item->product->category->name ?? '' }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $item->quantity }} unidad(es) × ${{ number_format($item->unit_price, 2) }}</p>
                </div>
                <p class="font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
            </div>
            @endforeach
        </div>

        <!-- Totales -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 space-y-2">
            <div class="flex justify-between text-sm text-gray-500">
                <span>Subtotal</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-500">
                <span>IVA (16%)</span>
                <span>${{ number_format($order->iva, 2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-gray-900 text-base pt-2 border-t border-gray-200">
                <span>Total pagado</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('cliente.pedidos') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
            ← Mis pedidos
        </a>
        <a href="{{ route('shop') }}" class="bg-sport-dark text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-sport-accent transition">
            Seguir comprando
        </a>
    </div>
</div>
@endsection