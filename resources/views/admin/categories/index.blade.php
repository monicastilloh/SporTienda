@extends('layouts.admin')
@section('title', 'Categorías')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">Categorías</h2>
    <a href="{{ route('admin.categorias.create') }}" class="bg-sport-dark text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-sport-accent transition">+ Nueva categoría</a>
</div>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-left">Categoría</th>
                <th class="px-6 py-4 text-left">Productos</th>
                <th class="px-6 py-4 text-left">Estado</th>
                <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($categories as $cat)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $cat->icon ?? '🏅' }}</span>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $cat->name }}</p>
                            <p class="text-xs text-gray-400">{{ $cat->slug }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4"><span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full text-xs">{{ $cat->products_count }} productos</span></td>
                <td class="px-6 py-4">
                    @if($cat->active)
                        <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Activa</span>
                    @else
                        <span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full text-xs font-medium">Inactiva</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.categorias.edit', $cat) }}" class="bg-sport-dark text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-sport-accent transition">Editar</a>
                        <form action="{{ route('admin.categorias.destroy', $cat) }}" method="POST" onsubmit="return confirm('¿Eliminar categoría?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-red-100 transition">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">No hay categorías registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection