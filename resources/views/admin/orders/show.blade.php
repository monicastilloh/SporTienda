@extends('layouts.admin')
@section('title', 'Detalle del Pedido')
@section('content')
@php $colors=['pendiente'=>'yellow','pagado'=>'green','enviado'=>'blue','entregado'=>'emerald','cancelado'=>'red']; @endphp

<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.pedidos.index') }}" class="text-gray-400 hover:text-gray-600 transition">← Volver</a>
        <h2 class="text-xl font-bold text-gray-900">Pedido {{ $pedido->order_number }}</h2>
        <span class="bg-{{ $colors[$pedido->status] ?? 'gray' }}-100 text-{{ $colors[$pedido->status] ?? 'gray' }}-700 px-3 py-1 rounded-full text-xs font-semibold">
            {{ ucfirst($pedido->status) }}
        </span>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Cliente</p>
            <p class="font-semibold text-gray-900">{{ $pedido->user->name }}</p>
            <p class="text-sm text-gray-500">{{ $pedido->user->email }}</p>
            <p class="text-sm text-gray-500">{{ $pedido->user->phone ?? '—' }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Pago</p>
            <p class="font-semibold text-gray-900">{{ $pedido->payment_method === 'paypal' ? '🅿️ PayPal' : '💳 Tarjeta' }}</p>
            <p class="text-xs text-gray-400 font-mono mt-1 break-all">{{ $pedido->payment_id }}</p>
            @if($pedido->paid_at)
                <p class="text-sm text-green-600 mt-1">✅ Pagado el {{ $pedido->paid_at->format('d/m/Y H:i') }}</p>
            @endif
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Actualizar estado</p>
            <form action="{{ route('admin.pedidos.status', $pedido) }}" method="POST" class="flex gap-2 mt-1">
                @csrf @method('PATCH')
                <select name="status" class="flex-1 border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-sport-accent">
                    @foreach(['pendiente','pagado','enviado','entregado','cancelado'] as $s)
                        <option value="{{ $s }}" {{ $pedido->status === $s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="bg-sport-dark text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-sport-accent transition">
                    OK
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50">
            <h3 class="font-semibold text-gray-900">Productos del pedido</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Producto</th>
                    <th class="px-6 py-3 text-right">Precio unitario</th>
                    <th class="px-6 py-3 text-right">Cantidad</th>
                    <th class="px-6 py-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($pedido->items as $item)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($item->product->image)
                                    <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-lg">🏅</div>
                                @endif
                            </div>
                            <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right text-gray-600">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="px-6 py-4 text-right font-medium">× {{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 text-sm">
                <tr><td colspan="3" class="px-6 py-3 text-right text-gray-500">Subtotal</td><td class="px-6 py-3 text-right">${{ number_format($pedido->subtotal, 2) }}</td></tr>
                <tr><td colspan="3" class="px-6 py-3 text-right text-gray-500">IVA 16%</td><td class="px-6 py-3 text-right">${{ number_format($pedido->iva, 2) }}</td></tr>
                <tr class="font-bold text-gray-900"><td colspan="3" class="px-6 py-3 text-right">Total</td><td class="px-6 py-3 text-right text-sport-dark">${{ number_format($pedido->total, 2) }}</td></tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection