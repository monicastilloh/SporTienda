@extends('layouts.app')
@section('title', 'Tienda')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Hero -->
    <div class="bg-gradient-to-r from-sport-dark to-sport-accent rounded-2xl p-8 mb-8 text-white flex items-center justify-between overflow-hidden relative">
        <div class="relative z-10">
            <h1 class="font-display text-5xl tracking-wider text-sport-gold mb-2">EQUIPAMIENTO DEPORTIVO</h1>
            <p class="text-gray-300 text-lg">Encuentra todo lo que necesitas para rendir al máximo</p>
        </div>
        <div class="text-8xl opacity-20 absolute right-8">🏋️</div>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
    <aside class="w-full md:w-56 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sticky top-20">
                <h3 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wide">Categorías</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('shop') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm transition
                                  {{ !isset($category) ? 'bg-sport-dark text-white font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            🏪 Todos los productos
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('shop.category', $cat->slug) }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm transition
                                      {{ (isset($category) && $category->id === $cat->id) ? 'bg-sport-dark text-white font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                {{ $cat->icon ?? '🏅' }} {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Productos -->
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">
                    {{ isset($category) ? $category->name : 'Todos los productos' }}
                    <span class="text-sm font-normal text-gray-400 ml-2">{{ $products->total() }} productos</span>
                </h2>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-20 text-gray-400">
                    <div class="text-6xl mb-4">🏪</div>
                    <p class="text-lg">No hay productos disponibles en esta categoría.</p>
                </div>
            @else
                
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                            <!-- Imagen -->
                            <div class="relative h-52 bg-gray-50 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-6xl">
                                        {{ $product->category->icon ?? '🏅' }}
                                    </div>
                                @endif
                                @if($product->stock === 0)
                                    <div class="absolute inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center">
                                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Sin stock</span>
                                    </div>
                                @elseif($product->stock <= 5)
                                    <span class="absolute top-2 right-2 bg-amber-100 text-amber-700 text-xs font-semibold px-2 py-1 rounded-full">
                                        Solo {{ $product->stock }} disponibles
                                    </span>
                                @endif
                                <span class="absolute top-2 left-2 bg-sport-dark text-sport-gold text-xs font-semibold px-2 py-1 rounded-full">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            <!-- Info -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2">{{ $product->name }}</h3>
                                @if($product->description)
                                    <p class="text-gray-400 text-xs mb-3 line-clamp-2">{{ $product->description }}</p>
                                @endif

                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-xl font-bold text-sport-dark">${{ number_format($product->price, 2) }}</span>
                                </div>

                                @if($product->isAvailable())
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                                class="w-full bg-sport-dark text-white text-sm font-semibold py-2.5 rounded-xl hover:bg-sport-accent transition-colors">
                                            🛒 Agregar al carrito
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                            class="w-full mt-3 bg-gray-100 text-gray-400 text-sm font-medium py-2.5 rounded-xl cursor-not-allowed">
                                        Sin stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mapa de la tienda -->
<div class="mt-12 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between flex-wrap gap-3">
        <div>
            <h2 class="font-semibold text-gray-900">📍 Nuestra tienda física</h2>
            <p class="text-sm text-gray-400 mt-0.5">Activa tu ubicación para ver la ruta hasta nosotros</p>
        </div>
        <div id="estado-ubicacion" class="flex items-center gap-2 text-sm text-gray-400">
            <div class="w-2 h-2 rounded-full bg-gray-300 animate-pulse"></div>
            Obteniendo ubicación...
        </div>
    </div>

    <!-- Panel de ruta -->
    <div id="panel-ruta" class="hidden px-6 py-3 bg-blue-50 border-b border-blue-100">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <p id="resumen-ruta" class="text-sm font-semibold text-blue-800"></p>
            <a href="#" id="link-maps" target="_blank"
               class="text-xs text-blue-600 hover:underline font-medium">
                Abrir en Google Maps →
            </a>
        </div>
        <div id="instrucciones-ruta" class="mt-2 text-xs text-blue-600 space-y-1 max-h-32 overflow-y-auto"></div>
    </div>

    <!-- Mensaje si deniega ubicación -->
    <div id="panel-sin-ubicacion" class="hidden px-6 py-3 bg-amber-50 border-b border-amber-100">
        <p class="text-sm text-amber-700">
            ⚠️ Activaste el bloqueo de ubicación. Para ver la ruta,
            <strong>activa la ubicación en tu navegador</strong> y recarga la página.
            También puedes
            <a id="link-maps-manual" href="https://www.google.com/maps/dir/?api=1&destination=17.0654,-96.7236"
               target="_blank" class="underline font-semibold">abrir la ruta en Google Maps</a>.
        </p>
    </div>

    <div id="map" style="height: 420px; width: 100%;"></div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center gap-4 text-sm text-gray-600">
        <span>📍 <strong>Av. Deportiva 123, Col. Centro — Oaxaca, Oax.</strong></span>
        <span>🕐 Lun–Sáb 9:00–20:00</span>
        <span>📞 (951) 123-4567</span>
    </div>
</div>

@push('scripts')
<script>
let map, directionsService, directionsRenderer;

const TIENDA = { lat: 17.0654, lng: -96.7236 };
const TIENDA_NOMBRE = "SportTienda — Av. Deportiva 123, Oaxaca";

function initMap() {
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({
        polylineOptions: {
            strokeColor: '#0F3460',
            strokeWeight: 5,
            strokeOpacity: 0.8,
        },
    });

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: TIENDA,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: true,
        styles: [
            { elementType: "geometry", stylers: [{ color: "#f5f5f5" }] },
            { featureType: "road", elementType: "geometry", stylers: [{ color: "#ffffff" }] },
            { featureType: "road.arterial", elementType: "geometry", stylers: [{ color: "#dadada" }] },
            { featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] },
        ]
    });

    directionsRenderer.setMap(map);

    // Marcador de la tienda
    const marker = new google.maps.Marker({
        position: TIENDA,
        map: map,
        title: TIENDA_NOMBRE,
        animation: google.maps.Animation.DROP,
        icon: {
            url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
            scaledSize: new google.maps.Size(44, 44),
        }
    });

    // Info window
    const infoWindow = new google.maps.InfoWindow({
        content: `
            <div style="font-family:'DM Sans',sans-serif;padding:8px;max-width:200px">
                <p style="font-weight:700;font-size:14px;margin:0 0 4px">⚡ SportTienda</p>
                <p style="color:#666;font-size:12px;margin:0 0 2px">Av. Deportiva 123, Col. Centro</p>
                <p style="color:#666;font-size:12px;margin:0 0 2px">Oaxaca, Oax.</p>
                <p style="color:#666;font-size:12px;margin:0 0 8px">🕐 Lun–Sáb 9:00–20:00</p>
            </div>
        `
    });

    // Abrir info window automáticamente
    infoWindow.open(map, marker);
    marker.addListener("click", () => infoWindow.open(map, marker));

    // Pedir ubicación automáticamente al cargar
    pedirUbicacion();
}

function pedirUbicacion() {
    if (!navigator.geolocation) {
        mostrarSinUbicacion();
        return;
    }

    // El navegador pide permiso automáticamente aquí
    navigator.geolocation.getCurrentPosition(
        (position) => {
            // Usuario aceptó — trazar ruta
            const origen = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            trazarRuta(origen);
        },
        (error) => {
            // Usuario rechazó o error
            mostrarSinUbicacion();
        },
        {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 0
        }
    );
}

function trazarRuta(origen) {
    const request = {
        origin: origen,
        destination: TIENDA,
        travelMode: google.maps.TravelMode.DRIVING,
        language: 'es',
        region: 'MX',
    };

    directionsService.route(request, (result, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsRenderer.setDirections(result);

            const leg = result.routes[0].legs[0];

            // Actualizar estado
            const estado = document.getElementById('estado-ubicacion');
            estado.innerHTML = `
                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                <span class="text-green-600 font-medium">📍 Ubicación activa</span>
            `;

            // Mostrar panel de ruta
            const panel = document.getElementById('panel-ruta');
            panel.classList.remove('hidden');

            // Resumen
            document.getElementById('resumen-ruta').textContent =
                `🚗 ${leg.distance.text} — aprox. ${leg.duration.text} en auto`;

            // Link a Google Maps con origen real
            const linkMaps = document.getElementById('link-maps');
            linkMaps.href = `https://www.google.com/maps/dir/?api=1&origin=${origen.lat},${origen.lng}&destination=${TIENDA.lat},${TIENDA.lng}&travelmode=driving`;

            // Instrucciones paso a paso
            const instrucciones = document.getElementById('instrucciones-ruta');
            let html = '';
            leg.steps.forEach((paso, i) => {
                const texto = paso.instructions.replace(/<[^>]*>/g, '');
                html += `<p>${i + 1}. ${texto} <span style="opacity:0.6">(${paso.distance.text})</span></p>`;
            });
            instrucciones.innerHTML = html;

        } else {
            mostrarSinUbicacion();
        }
    });
}

function mostrarSinUbicacion() {
    // Mostrar panel de advertencia
    document.getElementById('panel-sin-ubicacion').classList.remove('hidden');

    // Actualizar estado
    const estado = document.getElementById('estado-ubicacion');
    estado.innerHTML = `
        <div class="w-2 h-2 rounded-full bg-amber-400"></div>
        <span class="text-amber-600">Ubicación no disponible</span>
    `;

    // El mapa igual muestra la tienda centrada
    map.setCenter(TIENDA);
    map.setZoom(15);
}
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap&loading=async"
    async defer>
</script>
@endpush

@endsection