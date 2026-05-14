@extends('layouts.admin')
@section('title', 'Usuarios')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Gestión de Usuarios</h2>
        <p class="text-sm text-gray-400 mt-0.5">{{ $users->total() }} usuarios registrados</p>
    </div>
    <a href="{{ route('admin.usuarios.create') }}" class="bg-sport-dark text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-sport-accent transition">
        + Nuevo usuario
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Usuario</th>
                    <th class="px-6 py-4 text-left">Rol</th>
                    <th class="px-6 py-4 text-left">Teléfono</th>
                    <th class="px-6 py-4 text-left">Proveedor</th>
                    <th class="px-6 py-4 text-left">Estado</th>
                    <th class="px-6 py-4 text-left">Registro</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="">
                            @else
                                <div class="w-9 h-9 bg-sport-dark text-sport-gold rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $rolColors = ['admin'=>'bg-red-100 text-red-700','empleado'=>'bg-blue-100 text-blue-700','cliente'=>'bg-green-100 text-green-700'];
                        @endphp
                        <span class="{{ $rolColors[$user->role] ?? 'bg-gray-100 text-gray-600' }} px-2.5 py-1 rounded-full text-xs font-semibold">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->phone ?? '—' }}</td>
                    <td class="px-6 py-4">
                        @if($user->provider)
                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ ucfirst($user->provider) }}</span>
                        @else
                            <span class="text-gray-300 text-xs">email</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->active)
                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Activo</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full text-xs font-medium">Inactivo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.usuarios.edit', $user) }}"
                               class="bg-sport-dark text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-sport-accent transition">
                                Editar
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.usuarios.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar usuario {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-red-100 transition">
                                    Eliminar
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">No hay usuarios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">{{ $users->links() }}</div>
    @endif
</div>
@endsection