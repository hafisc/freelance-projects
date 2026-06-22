@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 2rem; color: var(--primary);">Keranjang Belanja</h1>

    @if($carts->count() > 0)
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <div>
                @foreach($carts as $cart)
                    <div class="card" style="margin-bottom: 1rem;">
                        <div style="display: flex; gap: 1rem; padding: 1rem;">
                            <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                            <div style="flex: 1;">
                                <h3>{{ $cart->product->name }}</h3>
                                @if($cart->size)
                                    <p>Ukuran: {{ $cart->size }}</p>
                                @endif
                                <p style="color: var(--primary); font-weight: bold;">Rp {{ number_format($cart->product->final_price) }}</p>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="quantity" value="{{ $cart->quantity - 1 }}" class="btn" style="padding: 0.25rem 0.75rem;" onclick="if({{ $cart->quantity }} <= 1) return false;">-</button>
                                    </form>
                                    <span style="padding: 0 1rem; font-weight: bold;">{{ $cart->quantity }}</span>
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="quantity" value="{{ $cart->quantity + 1 }}" class="btn" style="padding: 0.25rem 0.75rem;">+</button>
                                    </form>
                                </div>
                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background: var(--danger); color: white; padding: 0.25rem 0.75rem; font-size: 0.75rem;">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                <div class="card">
                    <div class="card-body">
                        <h3 style="margin-bottom: 1rem;">Ringkasan Pesanan</h3>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($carts->sum(fn($c) => $c->subtotal)) }}</span>
                        </div>
                        <hr style="margin: 1rem 0;">
                        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.25rem;">
                            <span>Total</span>
                            <span style="color: var(--primary);">Rp {{ number_format($carts->sum(fn($c) => $c->subtotal)) }}</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-secondary" style="width: 100%; margin-top: 1rem;">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <h3>Keranjang kosong</h3>
            <p style="color: #666; margin: 1rem 0;">Yuk belanja terlebih dahulu!</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection
