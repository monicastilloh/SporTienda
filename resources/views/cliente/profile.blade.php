@extends('layouts.app')
@section('title', 'Mi Perfil')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">👤 Mi Cuenta</h1>

    <div class="grid grid-cols-3 gap-6">
        <!-- Formulario de perfil -->
        <div class="col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                <h2 class="font-semibold text-gray-900 mb-5">Información personal</h2>
                <form action="{{ route('cliente.perfil.update') }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                   class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-3 text-sm text-gray-400 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent"
                                   placeholder="+52 xxx xxx xxxx">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección de envío</label>
                            <textarea name="address" rows="2"
                                      class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent resize-none"
                                      placeholder="Calle, número, colonia, ciudad, código postal...">{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="bg-sport-dark text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-sport-accent transition">
                        Guardar cambios
                    </button>
                </form>
            </div>

            <!-- Cambiar contraseña -->
            @if(!$user->provider)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-semibold text-gray-900 mb-5">Cambiar contraseña</h2>
                <form action="{{ route('cliente.perfil.update') }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña actual</label>
                        <input type="password" name="current_password"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                        @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña</label>
                            <input type="password" name="password"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent">
                        </div>
                    </div>
                    <button type="submit" class="bg-gray-800 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-700 transition">
                        Cambiar contraseña
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- Resumen lateral -->
        <div class="space-y-4">
            <div class="bg-sport-dark text-white rounded-2xl p-5">
                <div class="w-14 h-14 bg-sport-accent rounded-full flex items-center justify-center font-display text-2xl text-sport-gold mb-3">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <p class="font-semibold text-lg">{{ $user->name }}</p>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                <p class="text-sport-gold text-xs mt-2">Cliente desde {{ $user->created_at->format('M Y') }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-3">Resumen</p>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total pedidos</span>
                        <span class="font-bold">{{ $orders->total() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total gastado</span>
                        <span class="font-bold text-sport-dark">${{ number_format($user->orders()->where('status','pagado')->sum('total'), 2) }}</span>
                    </div>
                </div>
                <a href="{{ route('cliente.pedidos') }}" class="mt-4 block text-center text-sm text-sport-accent hover:underline font-medium">
                    Ver mis pedidos →
                </a>
            </div>
        </div>
    </div>

    <!-- Historial de pedidos compacto -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mt-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Pedidos recientes</h2>
            <a href="{{ route('cliente.pedidos') }}" class="text-sm text-sport-accent hover:underline">Ver todos</a>
        </div>
        @forelse($orders as $order)
        @php $colors=['pendiente'=>'yellow','pagado'=>'green','enviado'=>'blue','entregado'=>'emerald','cancelado'=>'red']; @endphp
        <div class="px-6 py-4 border-b border-gray-50 last:border-0 flex items-center justify-between hover:bg-gray-50 transition">
            <div>
                <p class="font-mono text-xs text-gray-500 font-semibold">{{ $order->order_number }}</p>
                <p class="text-sm text-gray-600 mt-0.5">{{ $order->items->count() }} producto(s) · {{ $order->created_at->format('d/m/Y') }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</p>
                <span class="bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700 px-2 py-0.5 rounded-full text-xs font-medium">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        @empty
        <div class="px-6 py-10 text-center text-gray-400">
            <div class="text-4xl mb-2">📦</div>
            <p class="text-sm">Aún no tienes pedidos.</p>
            <a href="{{ route('shop') }}" class="inline-block mt-3 text-sm text-sport-accent hover:underline font-medium">Ver productos →</a>
        </div>
        @endforelse
    </div>
</div>
@endsection