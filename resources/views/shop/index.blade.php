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

    <div class="flex gap-8">

        <!-- Sidebar categorías -->
        <aside class="w-64 flex-shrink-0">
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
                <div class="grid grid-cols-2 xl:grid-cols-3 gap-5">
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
    <div class="px-6 py-4 border-b border-gray-50">
        <h2 class="font-semibold text-gray-900">📍 Nuestra tienda física</h2>
        <p class="text-sm text-gray-400 mt-0.5">Visítanos y prueba el equipo antes de comprar</p>
    </div>
    <div id="map" style="height: 320px; width: 100%;"></div>
    <div class="px-6 py-4 bg-gray-50 flex items-center gap-4 text-sm text-gray-600">
        <span>📍 Av. Deportiva 123, Col. Centro — Oaxaca, Oax.</span>
        <span>🕐 Lun–Sáb 9:00–20:00</span>
        <span>📞 (951) 123-4567</span>
    </div>
</div>

@push('scripts')
<script>
function initMap() {
    const tienda = { lat: 17.0654, lng: -96.7236 }; // Coordenadas Oaxaca
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: tienda,
        styles: [
            { elementType: "geometry", stylers: [{ color: "#f5f5f5" }] },
            { featureType: "road", elementType: "geometry", stylers: [{ color: "#ffffff" }] },
            { featureType: "road.arterial", elementType: "geometry", stylers: [{ color: "#dadada" }] },
        ]
    });
    new google.maps.Marker({
        position: tienda,
        map,
        title: "SportTienda",
        label: { text: "⚡", fontSize: "20px" }
    });
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap">
</script>
@endpush

@endsection