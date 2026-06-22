@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="container" style="max-width: 600px; text-align: center;">
    <div class="card">
        <div class="card-body">
            <div style="margin-bottom: 2rem;">
                <svg style="width: 100px; height: 100px; fill: var(--success);" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            
            <h1 style="color: var(--primary); margin-bottom: 1rem;">Pembayaran Berhasil!</h1>
            <p style="color: #666; margin-bottom: 0.5rem;">Terima kasih telah berbelanja!</p>
            <p style="color: #666; margin-bottom: 2rem;">No. Pesanan: {{ $order->order_number }}</p>

            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
                <a href="{{ route('customer.order.detail', $order->order_number) }}" class="btn btn-secondary">Lihat Pesanan</a>
            </div>
        </div>
    </div>
</div>
@endsection
