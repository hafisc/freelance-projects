<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong!');
        }

        $user = auth()->user();
        $vouchers = Voucher::where('is_active', true)->get();

        return view('checkout', compact('carts', 'user', 'vouchers'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_type' => 'required|in:internal,external',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'customer_address' => 'nullable|required_if:customer_type,external',
            'customer_class' => 'nullable|required_if:customer_type,internal',
            'voucher_code' => 'nullable|string'
        ]);

        $carts = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $subtotal = $carts->sum(function ($cart) {
            return $cart->subtotal;
        });

        $discount = 0;
        $voucher = null;
        if ($request->voucher_code) {
            $voucher = Voucher::where('code', $request->voucher_code)->first();
            if ($voucher && $voucher->isAvailable()) {
                $discount = $voucher->calculateDiscount($subtotal);
            }
        }

        $total = $subtotal - $discount;

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => auth()->id(),
            'voucher_id' => $voucher->id ?? null,
            'customer_type' => $request->customer_type,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'customer_class' => $request->customer_class,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'qr_code' => uniqid()
        ]);

        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'product_name' => $cart->product->name,
                'product_image' => $cart->product->image,
                'size' => $cart->size,
                'quantity' => $cart->quantity,
                'price' => $cart->product->final_price,
                'subtotal' => $cart->subtotal
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $order->total
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        $order->update(['midtrans_order_id' => $snapToken]);

        Cart::where('user_id', auth()->id())->delete();

        if ($voucher) {
            $voucher->increment('used_count');
        }

        return view('checkout-payment', compact('order', 'snapToken'));
    }

    public function callback(Request $request)
    {
        $order = Order::where('order_number', $request->order_id)->first();
        
        if ($order && $request->transaction_status == 'settlement') {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => 'paid',
                'midtrans_response' => $request->all()
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('checkout-success', compact('order'));
    }
}
