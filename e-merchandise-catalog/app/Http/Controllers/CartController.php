<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        return view('cart', compact('carts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->when($product->is_kaos, function ($q) use ($request) {
                $q->where('size', $request->size);
            })
            ->first();

        if ($cart) {
            $cart->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'size' => $product->is_kaos ? $request->size : null,
                'quantity' => $request->quantity
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cart->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function destroy($id)
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cart->delete();
        return back()->with('success', 'Produk dihapus dari keranjang!');
    }
}
