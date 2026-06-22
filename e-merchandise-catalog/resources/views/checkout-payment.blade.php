@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container" style="max-width: 600px; text-align: center;">
    <div class="card">
        <div class="card-body">
            <div style="margin-bottom: 2rem;">
                <svg style="width: 80px; height: 80px; fill: var(--secondary);" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            
            <h1 style="color: var(--primary); margin-bottom: 1rem;">Pesanan Dibuat!</h1>
            <p style="color: #666; margin-bottom: 2rem;">No. Pesanan: {{ $order->order_number }}</p>

            <button id="payButton" class="btn btn-secondary" style="width: 100%;">Bayar Sekarang</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('payButton').addEventListener('click', function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = '{{ route('checkout.success', $order->order_number) }}';
            },
            onPending: function(result) {
                window.location.href = '{{ route('checkout.success', $order->order_number) }}';
            },
            onError: function(result) {
                alert('Pembayaran gagal!');
            }
        });
    });
</script>
@endsection
