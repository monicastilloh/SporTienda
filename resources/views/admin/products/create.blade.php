@extends('layouts.admin')
@section('title', 'Nuevo Producto')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.productos.index') }}" class="text-gray-400 hover:text-gray-600 transition">← Volver</a>
        <h2 class="text-xl font-bold text-gray-900">Nuevo Producto</h2>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-5">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del producto *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent"
                           placeholder="Ej: Balón Profesional Adidas">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                    <select name="category_id" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                        <option value="">Seleccionar categoría</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio (MXN) *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
                        <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" required
                               class="w-full border border-gray-200 rounded-xl pl-7 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent"
                               placeholder="0.00">
                    </div>
                    @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock inicial *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                    @error('stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <label class="flex items-center gap-3 mt-3 cursor-pointer">
                        <input type="checkbox" name="active" value="1" checked
                               class="w-4 h-4 rounded border-gray-300 text-sport-accent">
                        <span class="text-sm text-gray-700">Producto activo (visible en tienda)</span>
                    </label>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="description" rows="3"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent resize-none"
                              placeholder="Descripción del producto...">{{ old('description') }}</textarea>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagen del producto</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-sport-accent transition" x-data="{ preview: null }">
                        <input type="file" name="image" accept="image/*" class="hidden" id="img-input"
                               @change="preview = URL.createObjectURL($event.target.files[0])">
                        <template x-if="!preview">
                            <label for="img-input" class="cursor-pointer">
                                <div class="text-4xl mb-2">🖼️</div>
                                <p class="text-sm text-gray-500">Haz clic para subir imagen</p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP — máx. 2MB</p>
                            </label>
                        </template>
                        <template x-if="preview">
                            <div class="relative">
                                <img :src="preview" class="w-32 h-32 object-cover rounded-xl mx-auto">
                                <button type="button" @click="preview = null; document.getElementById('img-input').value = ''"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center mx-auto" style="left:calc(50% + 48px)">✕</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-sport-dark text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-sport-accent transition">
                    Crear producto
                </button>
                <a href="{{ route('admin.productos.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection