<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;



class CheckoutController extends Controller {

    /**
     * Calcula los totales del carrito para evitar repetir lógica.
     */
    private function getCartTotals($items) {
        $subtotal = $items->sum(fn($i) => $i->product->price * $i->quantity);
        $iva      = $subtotal * 0.16;
        $total    = $subtotal + $iva;

        return [
            'subtotal' => $subtotal,
            'iva'      => $iva,
            'total'    => $total
        ];
    }

    public function index() {
        $items = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $totals = $this->getCartTotals($items);

        return view('checkout.index', array_merge(['items' => $items], $totals));
    }


    public function paypalRedirect() {
        $items  = Cart::with('product')->where('user_id', Auth::id())->get();
        $totals = $this->getCartTotals($items);

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token    = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $order = $provider->createOrder([
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => 'MXN',
                        'value'         => number_format($totals['total'], 2, '.', ''),
                    ],
                    'description' => 'Compra en SportTienda',
                ]],
                'application_context' => [
                    'return_url' => route('checkout.paypal.success'),
                    'cancel_url' => route('checkout.paypal.cancel'),
                ],
            ]);

            session(['paypal_order' => $order['id']]);

            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error con PayPal: ' . $e->getMessage());
        }

        return back()->with('error', 'No se pudo conectar con PayPal.');
    }

    public function paypalSuccess(Request $request) {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token    = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $result = $provider->capturePaymentOrder(session('paypal_order'));

            if (isset($result['status']) && $result['status'] === 'COMPLETED') {
                $items  = Cart::with('product')->where('user_id', Auth::id())->get();
                $totals = $this->getCartTotals($items);

                $order = $this->createOrder($items, $totals['subtotal'], $totals['iva'], $totals['total'], 'paypal', $result['id']);
                return redirect()->route('checkout.success', $order->id);
            }
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Error al capturar el pago: ' . $e->getMessage());
        }

        return redirect()->route('cart.index')->with('error', 'El pago con PayPal fue cancelado o falló.');
    }

    public function paypalCancel() {
        return redirect()->route('cart.index')->with('error', 'Pago con PayPal cancelado.');
    }

    public function success(int $orderId) {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }

    private function createOrder($items, $subtotal, $iva, $total, $method, $paymentId): Order {
        return DB::transaction(function () use ($items, $subtotal, $iva, $total, $method, $paymentId) {
            $order = Order::create([
                'user_id'          => Auth::id(),
                'order_number'     => 'ORD-' . strtoupper(uniqid()),
                'status'           => 'pagado',
                'payment_method'   => $method,
                'payment_id'       => $paymentId,
                'subtotal'         => $subtotal,
                'iva'              => $iva,
                'total'            => $total,
                'shipping_address' => Auth::user()->address ?? 'Dirección no proporcionada',
                'paid_at'          => now(),
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->product->price,
                    'subtotal'   => $item->product->price * $item->quantity,
                ]);

                // Reducir stock
                Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
            }

            // Limpiar carrito
            Cart::where('user_id', Auth::id())->delete();

            return $order;
        });
    }
}