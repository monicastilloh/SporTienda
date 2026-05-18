@extends('layouts.app')
@section('title', 'Mis Pedidos')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">📦 Mis Pedidos</h1>
        <a href="{{ route('shop') }}" class="text-sm text-sport-accent hover:underline">← Seguir comprando</a>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
            <div class="text-6xl mb-4">📦</div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">No tienes pedidos aún</h2>
            <p class="text-gray-400 mb-6">Cuando realices una compra aparecerá aquí.</p>
            <a href="{{ route('shop') }}" class="inline-block bg-sport-dark text-white px-8 py-3 rounded-xl font-semibold hover:bg-sport-accent transition text-sm">
                Ver productos
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            @php $colors=['pendiente'=>'yellow','pagado'=>'green','enviado'=>'blue','entregado'=>'emerald','cancelado'=>'red']; @endphp
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <!-- Header del pedido -->
                <div class="px-6 py-4 border-b border-gray-50 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-mono text-xs text-gray-400 font-semibold">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $order->created_at->format('d \d\e F Y, H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ ucfirst($order->status) }}
                        </span>
                        <span class="font-bold text-gray-900">${{ number_format($order->total, 2) }} MXN</span>
                    </div>
                </div>

                <!-- Productos del pedido -->
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0">
                                @if($item->product->image)
                                    <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xl">🏅</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 text-sm truncate">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-400">Cantidad: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                            </div>
                            <p class="font-semibold text-gray-900 text-sm">${{ number_format($item->subtotal, 2) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer del pedido -->
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-sm">
                    <div class="flex items-center gap-4 text-gray-500">
                        <span>Subtotal: ${{ number_format($order->subtotal, 2) }}</span>
                        <span>IVA: ${{ number_format($order->iva, 2) }}</span>
                        <span class="font-bold text-gray-900">Total: ${{ number_format($order->total, 2) }}</span>
                    </div>
                    <span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full text-xs">
                        {{ $order->payment_method === 'paypal' ? '🅿️ PayPal' : '💳 Tarjeta' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection