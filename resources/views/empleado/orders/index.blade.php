@extends('layouts.app')
@section('title', 'Historial de Ventas')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center gap-3 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">📦 Historial de Ventas</h1>
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Solo lectura</span>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b">
                <tr>
                    <th class="px-6 py-4 text-left">Pedido</th>
                    <th class="px-6 py-4 text-left">Cliente</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Método</th>
                    <th class="px-6 py-4 text-left">Estado</th>
                    <th class="px-6 py-4 text-left">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                @php $colors=['pendiente'=>'yellow','pagado'=>'green','enviado'=>'blue','entregado'=>'emerald','cancelado'=>'red']; @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-mono text-xs font-semibold text-gray-600">{{ $order->order_number }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $order->user->name }}</td>
                    <td class="px-6 py-4 font-bold">${{ number_format($order->total, 2) }}</td>
                    <td class="px-6 py-4"><span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $order->payment_method }}</span></td>
                    <td class="px-6 py-4">
                        <span class="bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No hay pedidos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-50">{{ $orders->links() }}</div>
    </div>
</div>
@endsection