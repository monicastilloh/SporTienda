@extends('layouts.app')
@section('title', 'Productos')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center gap-3 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">📋 Vista de Productos</h1>
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Solo lectura</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-3xl font-bold text-gray-900">{{ $products->total() }}</p>
            <p class="text-sm text-gray-400 mt-1">Productos activos</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-3xl font-bold text-amber-600">{{ $products->where('stock', '<=', 5)->count() }}</p>
            <p class="text-sm text-gray-400 mt-1">Stock bajo (≤5 unidades)</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-3xl font-bold text-red-600">{{ $products->where('stock', 0)->count() }}</p>
            <p class="text-sm text-gray-400 mt-1">Sin stock</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Producto</th>
                    <th class="px-6 py-4 text-left">Categoría</th>
                    <th class="px-6 py-4 text-left">Precio</th>
                    <th class="px-6 py-4 text-left">Stock</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">{{ $product->category->icon ?? '🏅' }}</div>
                                @endif
                            </div>
                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $product->category->icon }} {{ $product->category->name }}</td>
                    <td class="px-6 py-4 font-bold">${{ number_format($product->price, 2) }}</td>
                    <td class="px-6 py-4">
                        @if($product->stock === 0)
                            <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full text-xs font-medium">Sin stock</span>
                        @elseif($product->stock <= 5)
                            <span class="bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full text-xs font-medium">{{ $product->stock }} — bajo</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">{{ $product->stock }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-50">{{ $products->links() }}</div>
    </div>
</div>
@endsection