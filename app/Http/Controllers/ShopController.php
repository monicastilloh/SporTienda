<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ShopController extends Controller {
    public function index() {
        $categories = Category::where('active', true)->get();
        $products   = Product::with('category')
            ->where('active', true)
            ->latest()
            ->paginate(12);

        return view('shop.index', compact('categories', 'products'));
    }

    public function category(string $slug) {
        $category   = Category::where('slug', $slug)->where('active', true)->firstOrFail();
        $categories = Category::where('active', true)->get();
        $products   = Product::with('category')
            ->where('category_id', $category->id)
            ->where('active', true)
            ->paginate(12);

        return view('shop.index', compact('categories', 'products', 'category'));
    }

    public function show(int $id) {
        $product = Product::with('category')->findOrFail($id);
        return view('shop.show', compact('product'));
    }
}