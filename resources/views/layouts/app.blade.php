<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SportTienda') — SportTienda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    display: ['"Bebas Neue"', 'cursive'],
                    body: ['"DM Sans"', 'sans-serif'],
                },
                colors: {
                    sport: {
                        red: '#E53E3E',
                        dark: '#1A1A2E',
                        mid: '#16213E',
                        accent: '#0F3460',
                        gold: '#F6AD55',
                    }
                }
            }
        }
    }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3781133699759960"
     crossorigin="anonymous"></script>

    @stack('styles')
</head>
<body class="font-body bg-gray-50 text-gray-900 h-full flex flex-col">

<!-- Navbar -->
<nav class="bg-sport-dark text-white sticky top-0 z-50 shadow-lg" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <a href="{{ route('shop') }}" class="font-display text-2xl tracking-widest text-sport-gold">
            ⚡ SPORT<span class="text-white">TIENDA</span>
        </a>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-6">
            <a href="{{ route('shop') }}" class="hover:text-sport-gold transition text-sm font-medium">Tienda</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-sport-gold transition text-sm font-medium">Admin</a>
                @elseif(auth()->user()->isEmpleado())
                    <a href="{{ route('empleado.productos') }}" class="hover:text-sport-gold transition text-sm font-medium">Panel</a>
                @endif
            @endauth
        </div>

        <div class="flex items-center gap-4">
            @auth
                <!-- Carrito -->
                <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1 bg-sport-accent px-3 py-2 rounded-lg hover:bg-sport-gold hover:text-sport-dark transition text-sm font-medium">
                    🛒
                    @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $cartCount }}</span>
                    @endif
                    Carrito
                </a>

                <!-- Usuario -->
                <div class="relative" x-data="{ menuOpen: false }">
                    <button @click="menuOpen = !menuOpen" class="flex items-center gap-2 hover:text-sport-gold transition text-sm font-medium">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" class="w-7 h-7 rounded-full object-cover" alt="">
                        @else
                            <span class="w-7 h-7 bg-sport-accent rounded-full flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        @endif
                        {{ explode(' ', auth()->user()->name)[0] }} ▾
                    </button>
                    <div x-show="menuOpen" @click.away="menuOpen = false" x-transition
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                        @if(auth()->user()->isCliente())
                            <a href="{{ route('cliente.perfil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Mi Perfil</a>
                            <a href="{{ route('cliente.pedidos') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Mis Pedidos</a>
                        @endif
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-sport-gold transition">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="bg-sport-gold text-sport-dark px-4 py-2 rounded-lg text-sm font-semibold hover:bg-yellow-400 transition">Registrarse</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Alertas -->
@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 pt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 flex items-center justify-between">
            <span>✅ {{ session('success') }}</span>
            <button @click="show = false" class="text-green-600 hover:text-green-800">✕</button>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 pt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 flex items-center justify-between">
            <span>❌ {{ session('error') }}</span>
            <button @click="show = false" class="text-red-600 hover:text-red-800">✕</button>
        </div>
    </div>
@endif

<main class="flex-1">
    @yield('content')
</main>

<footer class="bg-sport-dark text-gray-400 mt-16 py-10">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="font-display text-2xl text-sport-gold mb-2">⚡ SPORTIENDA</p>
        <p class="text-sm">© {{ date('Y') }} SportTienda — Todos los derechos reservados.</p>
    </div>
</footer>

@stack('scripts')
</body>
</html>