@extends('layouts.admin')
@section('title', 'Productos')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Gestión de Productos</h2>
        <p class="text-sm text-gray-400 mt-0.5">{{ $products->total() }} productos en total</p>
    </div>
    <a href="{{ route('admin.productos.create') }}" class="bg-sport-dark text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-sport-accent transition">
        + Nuevo producto
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Producto</th>
                    <th class="px-6 py-4 text-left">Categoría</th>
                    <th class="px-6 py-4 text-left">Precio</th>
                    <th class="px-6 py-4 text-left">Stock</th>
                    <th class="px-6 py-4 text-left">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl">{{ $product->category->icon ?? '🏅' }}</div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 max-w-xs truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $product->description }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full text-xs font-medium">
                            {{ $product->category->icon }} {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">${{ number_format($product->price, 2) }}</td>
                    <td class="px-6 py-4">
                        @if($product->stock === 0)
                            <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full text-xs font-medium">Sin stock</span>
                        @elseif($product->stock <= 5)
                            <span class="bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full text-xs font-medium">{{ $product->stock }} pocos</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">{{ $product->stock }} disponibles</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($product->active)
                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Activo</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full text-xs font-medium">Inactivo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.productos.edit', $product) }}"
                               class="bg-sport-dark text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-sport-accent transition">
                                Editar
                            </a>
                            <form action="{{ route('admin.productos.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-red-100 transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No hay productos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">{{ $products->links() }}</div>
    @endif
</div>
@endsection