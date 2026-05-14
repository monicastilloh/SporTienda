@extends('layouts.admin')
@section('title', 'Pedidos')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Historial de Pedidos</h2>
        <p class="text-sm text-gray-400 mt-0.5">{{ $orders->total() }} pedidos totales</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Pedido</th>
                    <th class="px-6 py-4 text-left">Cliente</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Método</th>
                    <th class="px-6 py-4 text-left">Estado</th>
                    <th class="px-6 py-4 text-left">Fecha</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                @php $colors=['pendiente'=>'yellow','pagado'=>'green','enviado'=>'blue','entregado'=>'emerald','cancelado'=>'red']; @endphp
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-mono text-xs text-gray-500 font-semibold">{{ $order->order_number }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">${{ number_format($order->total, 2) }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">
                            {{ $order->payment_method === 'paypal' ? '🅿️ PayPal' : '💳 Tarjeta' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.pedidos.show', $order) }}"
                           class="bg-sport-dark text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-sport-accent transition">
                            Ver detalle
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">No hay pedidos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">{{ $orders->links() }}</div>
    @endif
</div>
@endsection