@extends('layouts.admin')

@section('title', 'Verifikasi Pengambilan')

@section('content')
<div class="header">
    <h1>Verifikasi Pengambilan Merchandise</h1>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto; text-align: center;">
    <div class="card-body">
        <h2 style="color: var(--primary); margin-bottom: 1rem;">{{ $order->order_number }}</h2>
        <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
        <p><strong>Tipe:</strong> {{ ucfirst($order->customer_type) }}</p>
        @if($order->customer_class)
            <p><strong>Kelas:</strong> {{ $order->customer_class }}</p>
        @endif

        <hr style="margin: 1.5rem 0;">

        <h3 style="margin-bottom: 1rem;">Produk</h3>
        @foreach($order->items as $item)
            <div style="text-align: left; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                <strong>{{ $item->product_name }}</strong>
                @if($item->size)
                    <span style="color: #666;">({{ $item->size }})</span>
                @endif
                <span style="float: right;">x{{ $item->quantity }}</span>
            </div>
        @endforeach

        <hr style="margin: 1.5rem 0;">

        @if($order->is_picked_up)
            <div class="alert alert-success">
                <strong>Pesanan ini sudah diambil!</strong><br>
                Pada: {{ $order->picked_up_at?->format('d M Y H:i') }}
            </div>
        @else
            <form action="{{ route('admin.orders.pickup', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success" style="width: 100%; font-size: 1.1rem; padding: 1rem;">
                    ✓ Tandai Sudah Diambil
                </button>
            </form>
        @endif

        <div style="margin-top: 1.5rem;">
            <a href="{{ route('admin.orders') }}" class="btn btn-primary">← Kembali ke Daftar Pesanan</a>
        </div>
    </div>
</div>
@endsection
