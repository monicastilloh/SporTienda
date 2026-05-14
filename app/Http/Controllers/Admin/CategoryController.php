<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    public function index() {
        $categories = Category::withCount('products')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {
        return view('admin.categories.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'icon'        => ['nullable','string','max:10'],
            'description' => ['nullable','string'],
            'active'      => ['boolean'],
        ]);
        $data['slug']   = Str::slug($data['name']) . '-' . uniqid();
        $data['active'] = $request->boolean('active', true);
        Category::create($data);
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Category $categoria) {
        return view('admin.categories.edit', compact('categoria'));
    }

    public function update(Request $request, Category $categoria) {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'icon'        => ['nullable','string','max:10'],
            'description' => ['nullable','string'],
            'active'      => ['boolean'],
        ]);
        $data['active'] = $request->boolean('active');
        $categoria->update($data);
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Category $categoria) {
        if ($categoria->products()->count() > 0) {
            return back()->with('error', 'No puedes eliminar una categoría con productos asociados.');
        }
        $categoria->delete();
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada.');
    }
}