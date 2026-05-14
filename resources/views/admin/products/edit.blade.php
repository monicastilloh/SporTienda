@extends('layouts.admin')
@section('title', 'Editar Producto')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.productos.index') }}" class="text-gray-400 hover:text-gray-600 transition">← Volver</a>
        <h2 class="text-xl font-bold text-gray-900">Editar: {{ $producto->name }}</h2>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-5">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del producto *</label>
                    <input type="text" name="name" value="{{ old('name', $producto->name) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                    <select name="category_id" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $producto->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio (MXN) *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
                        <input type="number" name="price" value="{{ old('price', $producto->price) }}" min="0" step="0.01" required
                               class="w-full border border-gray-200 rounded-xl pl-7 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" min="0" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <label class="flex items-center gap-3 mt-3 cursor-pointer">
                        <input type="checkbox" name="active" value="1" {{ $producto->active ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 text-sport-accent">
                        <span class="text-sm text-gray-700">Producto activo</span>
                    </label>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="description" rows="3"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent resize-none">{{ old('description', $producto->description) }}</textarea>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen actual</label>
                    @if($producto->image)
                        <div class="flex items-center gap-4 mb-3">
                            <img src="{{ Storage::url($producto->image) }}" class="w-20 h-20 object-cover rounded-xl border border-gray-100">
                            <p class="text-sm text-gray-500">Sube una nueva imagen para reemplazarla.</p>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-600 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700 file:text-xs file:font-medium hover:file:bg-gray-200">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-sport-dark text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-sport-accent transition">
                    Guardar cambios
                </button>
                <a href="{{ route('admin.productos.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection