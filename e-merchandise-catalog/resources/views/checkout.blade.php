@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 2rem; color: var(--primary);">Checkout</h1>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <div>
                <div class="card" style="margin-bottom: 1rem;">
                    <div class="card-body">
                        <h3 style="margin-bottom: 1rem;">Data Diri</h3>
                        
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem;">Tipe Pembeli</label>
                            <div style="display: flex; gap: 1rem;">
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                    <input type="radio" name="customer_type" value="internal" {{ $user->type === 'internal' ? 'checked' : '' }} onchange="toggleCheckoutFields()"> Internal (Siswa/Guru)
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                    <input type="radio" name="customer_type" value="external" {{ $user->type === 'external' ? 'checked' : '' }} onchange="toggleCheckoutFields()"> Eksternal
                                </label>
                            </div>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem;">Nama</label>
                            <input type="text" name="customer_name" value="{{ $user->name }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem;">Email</label>
                            <input type="email" name="customer_email" value="{{ $user->email }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem;">Nomor HP</label>
                            <input type="text" name="customer_phone" value="{{ $user->phone }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>

                        <div id="checkoutClassField" style="margin-bottom: 1rem; {{ $user->type === 'external' ? 'display: none;' : '' }}">
                            <label style="display: block; margin-bottom: 0.5rem;">Kelas</label>
                            <input type="text" name="customer_class" value="{{ $user->class }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>

                        <div id="checkoutAddressField" style="margin-bottom: 1rem; {{ $user->type === 'internal' ? 'display: none;' : '' }}">
                            <label style="display: block; margin-bottom: 0.5rem;">Alamat</label>
                            <textarea name="customer_address" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">{{ $user->address }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-bottom: 1rem;">
                    <div class="card-body">
                        <h3 style="margin-bottom: 1rem;">Voucher</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" name="voucher_code" placeholder="Masukkan kode voucher" style="flex: 1; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 style="margin-bottom: 1rem;">Pesanan</h3>
                        @foreach($carts as $cart)
                            <div style="display: flex; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
                                <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                <div style="flex: 1;">
                                    <h4>{{ $cart->product->name }}</h4>
                                    @if($cart->size)
                                        <p style="color: #666; font-size: 0.875rem;">Ukuran: {{ $cart->size }}</p>
                                    @endif
                                    <p style="color: #666; font-size: 0.875rem;">Jumlah: {{ $cart->quantity }}</p>
                                </div>
                                <div style="text-align: right;">
                                    <p style="font-weight: bold;">Rp {{ number_format($cart->subtotal) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                <div class="card">
                    <div class="card-body">
                        <h3 style="margin-bottom: 1rem;">Ringkasan</h3>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($carts->sum(fn($c) => $c->subtotal)) }}</span>
                        </div>
                        <hr style="margin: 1rem 0;">
                        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.25rem;">
                            <span>Total</span>
                            <span style="color: var(--primary);">Rp {{ number_format($carts->sum(fn($c) => $c->subtotal)) }}</span>
                        </div>
                        <button type="submit" class="btn btn-secondary" style="width: 100%; margin-top: 1rem;">Buat Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleCheckoutFields() {
        const type = document.querySelector('input[name="customer_type"]:checked').value;
        document.getElementById('checkoutClassField').style.display = type === 'internal' ? 'block' : 'none';
        document.getElementById('checkoutAddressField').style.display = type === 'external' ? 'block' : 'none';
    }
</script>
@endsection
