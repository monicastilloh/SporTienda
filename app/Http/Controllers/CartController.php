<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller {
    public function index() {
        $items = Cart::with('product.category')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $items->sum(fn($i) => $i->product->price * $i->quantity);
        $iva      = $subtotal * 0.16;
        $total    = $subtotal + $iva;

        return view('cart.index', compact('items', 'subtotal', 'iva', 'total'));
    }

    public function add(Request $request) {
        $request->validate([
            'product_id' => ['required','exists:products,id'],
            'quantity'   => ['required','integer','min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->isAvailable()) {
            return back()->with('error', 'Producto no disponible.');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        $newQty = ($cartItem ? $cartItem->quantity : 0) + $request->quantity;

        if ($newQty > $product->stock) {
            return back()->with('error', "Solo hay {$product->stock} unidades disponibles.");
        }

        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['quantity' => $newQty]
        );

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function update(Request $request, int $id) {
        $request->validate(['quantity' => ['required','integer','min:1']]);

        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $product  = $cartItem->product;

        if ($request->quantity > $product->stock) {
            return back()->with('error', "Máximo {$product->stock} unidades disponibles.");
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Carrito actualizado.');
    }

    public function remove(int $id) {
        Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail()->delete();
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function clear() {
        Cart::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Carrito vaciado.');
    }
}