@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container">
    <a href="{{ route('customer.orders') }}" style="color: var(--primary); text-decoration: none; display: inline-block; margin-bottom: 1rem;">← Kembali</a>

    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body">
            <h2 style="color: var(--primary); margin-bottom: 1rem;">{{ $order->order_number }}</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <p><strong>Status:</strong> <span class="badge badge-{{ $order->order_status === 'paid' || $order->order_status === 'completed' ? 'success' : 'warning' }}">{{ ucfirst($order->order_status) }}</span></p>
                    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <div style="text-align: right;">
                    <a href="{{ route('customer.order.invoice', $order->order_number) }}" class="btn btn-primary">Download Invoice</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body">
            <h3 style="margin-bottom: 1rem;">Data Pembeli</h3>
            <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
            <p><strong>Tipe:</strong> {{ ucfirst($order->customer_type) }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>HP:</strong> {{ $order->customer_phone }}</p>
            @if($order->customer_address)
                <p><strong>Alamat:</strong> {{ $order->customer_address }}</p>
            @endif
            @if($order->customer_class)
                <p><strong>Kelas:</strong> {{ $order->customer_class }}</p>
            @endif
        </div>
    </div>

    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body">
            <h3 style="margin-bottom: 1rem;">Produk</h3>
            @foreach($order->items as $item)
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
                    <img src="{{ asset('storage/' . $item->product_image) }}" alt="{{ $item->product_name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                    <div style="flex: 1;">
                        <h4>{{ $item->product_name }}</h4>
                        @if($item->size)
                            <p style="color: #666; font-size: 0.875rem;">Ukuran: {{ $item->size }}</p>
                        @endif
                        <p style="color: #666; font-size: 0.875rem;">Jumlah: {{ $item->quantity }}</p>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-weight: bold;">Rp {{ number_format($item->subtotal) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 style="margin-bottom: 1rem;">Ringkasan</h3>
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->subtotal) }}</span>
            </div>
            @if($order->discount > 0)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: var(--success);">
                    <span>Diskon</span>
                    <span>-Rp {{ number_format($order->discount) }}</span>
                </div>
            @endif
            <hr style="margin: 1rem 0;">
            <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.25rem;">
                <span>Total</span>
                <span style="color: var(--primary);">Rp {{ number_format($order->total) }}</span>
            </div>
        </div>
    </div>

    @if($order->qr_code)
        <div class="card" style="margin-top: 1.5rem; text-align: center;">
            <div class="card-body">
                <h3 style="margin-bottom: 1rem;">QR Code Pengambilan</h3>
                <p style="color: #666; margin-bottom: 1rem;">Tunjukkan QR code ini saat mengambil merchandise di sekolah</p>
                <div style="display: inline-block; padding: 1rem; background: white; border: 1px solid #eee; border-radius: 8px;">
                    {!! QrCode::size(200)->generate($order->qr_code) !!}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
