<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Cliente\ProfileController;
use App\Http\Controllers\Cliente\OrderController as ClienteOrderController;

// Autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// OAuth
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

// Tienda pública (requiere login)
Route::middleware('auth')->group(function () {

    Route::get('/', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('shop.category');
    Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');

    // Carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/paypal', [CheckoutController::class, 'paypalRedirect'])->name('checkout.paypal');
    Route::get('/checkout/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('checkout.paypal.success');
    Route::get('/checkout/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('checkout.paypal.cancel');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Cliente
    Route::middleware('role:cliente')->prefix('mi-cuenta')->name('cliente.')->group(function () {
        Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil');
        Route::put('/perfil', [ProfileController::class, 'update'])->name('perfil.update');
        Route::get('/pedidos', [ClienteOrderController::class, 'index'])->name('pedidos');
        Route::get('/pedidos/{id}', [ClienteOrderController::class, 'show'])->name('pedidos.show');
    });

    // Empleado
    Route::middleware('role:empleado,admin')->prefix('empleado')->name('empleado.')->group(function () {
        Route::get('/productos', [\App\Http\Controllers\Empleado\ProductController::class, 'index'])->name('productos');
        Route::get('/clientes', [\App\Http\Controllers\Empleado\ClienteController::class, 'index'])->name('clientes');
        Route::get('/historial', [\App\Http\Controllers\Empleado\OrderController::class, 'index'])->name('historial');
    });

    // Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('usuarios', UserController::class);
        Route::resource('productos', ProductController::class);
        Route::resource('categorias', CategoryController::class);
        Route::resource('pedidos', AdminOrderController::class)->only(['index','show','update']);
        Route::patch('/pedidos/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('pedidos.status');
    });
});