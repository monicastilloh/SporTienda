<?php
namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category};

class ProductController extends Controller {
    public function index() {
        $products   = Product::with('category')->where('active', true)->latest()->paginate(20);
        $categories = Category::where('active', true)->get();
        return view('empleado.products.index', compact('products', 'categories'));
    }
}