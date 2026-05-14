<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — SportTienda</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: { extend: {
            fontFamily: { display: ['"Bebas Neue"'], body: ['"DM Sans"'] },
            colors: { sport: { red:'#E53E3E', dark:'#1A1A2E', mid:'#16213E', accent:'#0F3460', gold:'#F6AD55' }}
        }}
    }
    </script>
</head>
<body class="font-body bg-sport-dark min-h-screen flex">

    <!-- Panel izquierdo -->
    <div class="hidden lg:flex flex-col justify-center items-center w-1/2 bg-sport-mid px-16"
         style="background: linear-gradient(135deg, #1A1A2E 0%, #16213E 50%, #0F3460 100%);">
        <h1 class="font-display text-7xl text-sport-gold tracking-widest mb-4">SPORT<br>TIENDA</h1>
        <p class="text-gray-300 text-lg text-center max-w-sm">Tu destino para equipamiento deportivo de alto rendimiento.</p>
        <div class="mt-12 flex gap-6 text-4xl">
            <span>⚽</span><span>🏀</span><span>🎾</span><span>🏊</span><span>🚴</span>
        </div>
    </div>

    <!-- Panel derecho -->
    <div class="flex-1 flex items-center justify-center px-8 py-12">
        <div class="w-full max-w-md">
            <div class="lg:hidden font-display text-4xl text-sport-gold text-center mb-8">⚡ SPORTIENDA</div>

            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-1">Bienvenido de vuelta</h2>
                <p class="text-gray-500 text-sm mb-6">Ingresa tus credenciales para continuar</p>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent focus:border-transparent transition"
                               placeholder="tu@correo.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input type="password" name="password" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sport-accent focus:border-transparent transition"
                               placeholder="••••••••">
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-sport-accent">
                            Recordarme
                        </label>
                    </div>
                    <button type="submit"
                            class="w-full bg-sport-dark text-white font-semibold rounded-xl py-3 text-sm hover:bg-sport-accent transition-colors duration-200">
                        Iniciar sesión
                    </button>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                    <div class="relative flex justify-center"><span class="bg-white px-3 text-xs text-gray-400">O continúa con</span></div>
                </div>

               <div>
    <a href="{{ route('social.redirect', 'google') }}"
       class="flex items-center justify-center gap-2 border border-gray-200 rounded-xl py-2.5 text-sm font-medium hover:bg-gray-50 transition w-full">
        <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
        Continuar con Google
    </a>
</div> 

                <p class="text-center text-sm text-gray-500 mt-6">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-sport-accent font-semibold hover:underline">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>