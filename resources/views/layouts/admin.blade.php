<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — SportTienda</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: { extend: {
            fontFamily: { display:['"Bebas Neue"'], body:['"DM Sans"'] },
            colors: { sport:{ red:'#E53E3E', dark:'#1A1A2E', mid:'#16213E', accent:'#0F3460', gold:'#F6AD55' }}
        }}
    }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-body bg-gray-50 h-full flex">

<!-- Sidebar -->
<aside class="w-64 bg-sport-dark text-white flex-shrink-0 flex flex-col min-h-screen">
    <div class="p-6 border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}" class="font-display text-2xl text-sport-gold tracking-widest">
            ⚡ SPORTIENDA
        </a>
        <p class="text-gray-400 text-xs mt-1">Panel Administrador</p>
    </div>

    <nav class="flex-1 p-4 space-y-1">
        @php
        $links = [
            ['route'=>'admin.dashboard',         'icon'=>'📊', 'label'=>'Dashboard'],
            ['route'=>'admin.productos.index',   'icon'=>'🏅', 'label'=>'Productos'],
            ['route'=>'admin.categorias.index',  'icon'=>'🏷️', 'label'=>'Categorías'],
            ['route'=>'admin.usuarios.index',    'icon'=>'👥', 'label'=>'Usuarios'],
            ['route'=>'admin.pedidos.index',     'icon'=>'📦', 'label'=>'Pedidos'],
            ['route'=>'shop',                    'icon'=>'🛒', 'label'=>'Ver Tienda'],
        ];
        @endphp
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
                      {{ request()->routeIs($link['route'].'*') ? 'bg-sport-accent text-white font-medium' : 'text-gray-300 hover:bg-white/10' }}">
                {{ $link['icon'] }} {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 bg-sport-accent rounded-full flex items-center justify-center text-sm font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400">Administrador</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left text-xs text-red-400 hover:text-red-300 transition">Cerrar sesión →</button>
        </form>
    </div>
</aside>

<!-- Main -->
<div class="flex-1 flex flex-col min-h-screen overflow-hidden">
    <!-- Topbar -->
    <header class="bg-white border-b border-gray-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
        <h1 class="text-lg font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
        <div class="flex items-center gap-3 text-sm text-gray-500">
            <span>{{ now()->format('l, d \d\e F Y') }}</span>
        </div>
    </header>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mx-8 mt-4" x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)">
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 flex justify-between items-center text-sm">
                ✅ {{ session('success') }}
                <button @click="show=false" class="text-green-600 ml-4">✕</button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mx-8 mt-4" x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,5000)">
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 flex justify-between items-center text-sm">
                ❌ {{ session('error') }}
                <button @click="show=false" class="text-red-600 ml-4">✕</button>
            </div>
        </div>
    @endif

    <main class="flex-1 overflow-auto p-8">
        @yield('content')
    </main>
</div>
</body>
</html>
