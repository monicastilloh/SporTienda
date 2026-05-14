@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Panel de Administración</h1>
            <p class="text-gray-400 text-sm mt-1">Hola, {{ auth()->user()->name }} — {{ now()->format('d/m/Y') }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.productos.create') }}" class="bg-sport-dark text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-sport-accent transition">+ Nuevo producto</a>
            <a href="{{ route('admin.usuarios.create') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium hover:bg-gray-200 transition">+ Nuevo usuario</a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label'=>'Ventas totales','value'=>'$'.number_format($stats['ventas'],2),'icon'=>'💰','color'=>'bg-emerald-50 border-emerald-200'],
            ['label'=>'Pedidos','value'=>$stats['pedidos'],'icon'=>'📦','color'=>'bg-blue-50 border-blue-200'],
            ['label'=>'Clientes','value'=>$stats['clientes'],'icon'=>'👥','color'=>'bg-purple-50 border-purple-200'],
            ['label'=>'Sin stock','value'=>$stats['sin_stock'],'icon'=>'⚠️','color'=>'bg-red-50 border-red-200'],
        ] as $stat)
        <div class="bg-white rounded-2xl border {{ $stat['color'] }} p-5 shadow-sm">
            <div class="text-3xl mb-2">{{ $stat['icon'] }}</div>
            <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    <!-- Menú admin -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['href'=>route('admin.usuarios.index'),'icon'=>'👥','label'=>'Usuarios','desc'=>$stats['usuarios'].' total'],
            ['href'=>route('admin.productos.index'),'icon'=>'🏅','label'=>'Productos','desc'=>$stats['productos'].' total'],
            ['href'=>route('admin.pedidos.index'),'icon'=>'📦','label'=>'Pedidos','desc'=>$stats['hoy'].' hoy'],
            ['href'=>route('admin.categorias.index'),'icon'=>'🏷️','label'=>'Categorías','desc'=>'Gestionar'],
        ] as $item)
        <a href="{{ $item['href'] }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition group">
            <div class="text-4xl mb-3">{{ $item['icon'] }}</div>
            <p class="font-semibold text-gray-900 group-hover:text-sport-accent transition">{{ $item['label'] }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $item['desc'] }}</p>
        </a>
        @endforeach
    </div>

    <!-- Pedidos recientes -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Pedidos recientes</h2>
            <a href="{{ route('admin.pedidos.index') }}" class="text-sm text-sport-accent hover:underline">Ver todos</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Cliente</th>
                        <th class="px-6 py-3 text-left">Total</th>
                        <th class="px-6 py-3 text-left">Método</th>
                        <th class="px-6 py-3 text-left">Estado</th>
                        <th class="px-6 py-3 text-left">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recientes as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 font-mono text-xs text-gray-500">{{ $order->order_number }}</td>
                        <td class="px-6 py-3 font-medium text-gray-900">{{ $order->user->name }}</td>
                        <td class="px-6 py-3 font-bold text-sport-dark">${{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-3">
                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $order->payment_method }}</span>
                        </td>
                        <td class="px-6 py-3">
                            @php
                                $colors = ['pendiente'=>'yellow','pagado'=>'green','enviado'=>'blue','entregado'=>'emerald','cancelado'=>'red'];
                                $c = $colors[$order->status] ?? 'gray';
                            @endphp
                            <span class="bg-{{ $c }}-100 text-{{ $c }}-700 px-2 py-0.5 rounded-full text-xs font-medium">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection