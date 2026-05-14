@extends('layouts.app')
@section('title', 'Carrito de compras')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">🛒 Mi Carrito</h1>

    @if($items->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
            <div class="text-7xl mb-4">🛒</div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Tu carrito está vacío</h2>
            <p class="text-gray-400 mb-6">Agrega productos para comenzar tu compra</p>
            <a href="{{ route('shop') }}" class="inline-block bg-sport-dark text-white px-8 py-3 rounded-xl font-semibold hover:bg-sport-accent transition">
                Ver productos
            </a>
        </div>
    @else
    <div class="flex gap-6 items-start">

        <!-- Lista de productos -->
        <div class="flex-1 space-y-3">
            @foreach($items as $item)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex gap-4 items-center">
                <!-- Imagen -->
                <div class="w-20 h-20 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0">
                    @if($item->product->image)
                        <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover" alt="">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-3xl">{{ $item->product->category->icon ?? '🏅' }}</div>
                    @endif
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $item->product->name }}</h3>
                    <p class="text-sport-accent font-bold text-lg">${{ number_format($item->product->price, 2) }}</p>
                    <p class="text-gray-400 text-xs">Stock disponible: {{ $item->product->stock }}</p>
                </div>

                <!-- Cantidad -->
                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                    @csrf @method('PATCH')
                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                           min="1" max="{{ $item->product->stock }}"
                           class="w-16 border border-gray-200 rounded-lg px-2 py-1 text-center text-sm focus:outline-none focus:ring-1 focus:ring-sport-accent"
                           onchange="this.form.submit()">
                </form>

                <!-- Subtotal -->
                <div class="text-right w-24">
                    <p class="font-bold text-gray-900">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                </div>

                <!-- Eliminar -->
                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 transition p-2 rounded-lg hover:bg-red-50">
                        🗑️
                    </button>
                </form>
            </div>
            @endforeach

            <!-- Vaciar carrito -->
            <form action="{{ route('cart.clear') }}" method="POST" class="text-right">
                @csrf @method('DELETE')
                <button type="submit" class="text-sm text-red-400 hover:text-red-600 hover:underline transition">
                    Vaciar carrito
                </button>
            </form>
        </div>

        <!-- Resumen -->
        <div class="w-80 flex-shrink-0 sticky top-24">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-semibold text-gray-900 text-lg mb-5">Resumen del pedido</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>IVA (16%)</span>
                        <span>${{ number_format($iva, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3 flex justify-between font-bold text-gray-900 text-base">
                        <span>Total</span>
                        <span class="text-sport-dark">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}"
                   class="mt-6 block w-full bg-sport-dark text-white text-center font-semibold py-3 rounded-xl hover:bg-sport-accent transition text-sm">
                    Finalizar compra →
                </a>

                <a href="{{ route('shop') }}" class="mt-3 block text-center text-sm text-gray-400 hover:text-gray-600 transition">
                    ← Seguir comprando
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection