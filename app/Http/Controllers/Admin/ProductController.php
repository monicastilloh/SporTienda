<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller {
    public function index() {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        $categories = Category::where('active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'image'       => ['nullable','image','max:2048'],
            'active'      => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        Product::create($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $producto) {
        $categories = Category::where('active', true)->get();
        return view('admin.products.edit', compact('producto', 'categories'));
    }

    public function update(Request $request, Product $producto) {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'image'       => ['nullable','image','max:2048'],
            'active'      => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($producto->image) Storage::disk('public')->delete($producto->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['active'] = $request->boolean('active');
        $producto->update($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $producto) {
        if ($producto->image) Storage::disk('public')->delete($producto->image);
        $producto->delete();
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado.');
    }
}