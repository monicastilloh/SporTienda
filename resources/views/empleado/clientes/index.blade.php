@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center gap-3 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">👥 Clientes</h1>
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Solo lectura</span>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b">
                <tr>
                    <th class="px-6 py-4 text-left">Cliente</th>
                    <th class="px-6 py-4 text-left">Teléfono</th>
                    <th class="px-6 py-4 text-left">Dirección</th>
                    <th class="px-6 py-4 text-left">Registro</th>
                    <th class="px-6 py-4 text-left">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($clientes as $cliente)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-sport-dark text-sport-gold rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($cliente->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $cliente->name }}</p>
                                <p class="text-xs text-gray-400">{{ $cliente->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $cliente->phone ?? '—' }}</td>
                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $cliente->address ?? '—' }}</td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $cliente->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        @if($cliente->active)
                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Activo</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full text-xs font-medium">Inactivo</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">No hay clientes registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-50">{{ $clientes->links() }}</div>
    </div>
</div>
@endsection