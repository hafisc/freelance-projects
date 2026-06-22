@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 2rem; color: var(--primary);">Pesanan Saya</h1>

    @if($orders->count() > 0)
        @foreach($orders as $order)
            <div class="card" style="margin-bottom: 1rem;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div>
                            <h3>{{ $order->order_number }}</h3>
                            <p style="color: #666;">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div style="text-align: right;">
                            <span class="badge badge-{{ $order->order_status === 'paid' || $order->order_status === 'completed' ? 'success' : 'warning' }}">{{ ucfirst($order->order_status) }}</span>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <p style="font-size: 1.25rem; font-weight: bold; color: var(--primary);">Total: Rp {{ number_format($order->total) }}</p>
                        </div>
                        <a href="{{ route('customer.order.detail', $order->order_number) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <h3>Belum ada pesanan</h3>
            <p style="color: #666; margin: 1rem 0;">Yuk mulai belanja!</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection
