@extends('layouts.admin')
@section('title', 'Nuevo Usuario')
@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.usuarios.index') }}" class="text-gray-400 hover:text-gray-600 transition">← Volver</a>
        <h2 class="text-xl font-bold text-gray-900">Nuevo Usuario</h2>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña *</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent"
                           placeholder="+52 xxx xxx xxxx">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rol *</label>
                <select name="role" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                    <option value="cliente" {{ old('role')=='cliente' ? 'selected':'' }}>Cliente</option>
                    <option value="empleado" {{ old('role')=='empleado' ? 'selected':'' }}>Empleado</option>
                    <option value="admin" {{ old('role')=='admin' ? 'selected':'' }}>Administrador</option>
                </select>
            </div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="active" value="1" checked class="w-4 h-4 rounded border-gray-300 text-sport-accent">
                <span class="text-sm text-gray-700">Usuario activo</span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-sport-dark text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-sport-accent transition">
                    Crear usuario
                </button>
                <a href="{{ route('admin.usuarios.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection