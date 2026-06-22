@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="card">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; border-radius: 12px;">
            </div>
            <div class="card-body">
                <h1 style="color: var(--primary); margin-bottom: 1rem;">{{ $product->name }}</h1>
                
                <div style="margin-bottom: 1rem;">
                    @if($product->is_promo && $product->promo_price)
                        <span style="text-decoration: line-through; color: #999; font-size: 1.25rem;">Rp {{ number_format($product->price) }}</span>
                        <div style="font-size: 2rem; color: var(--primary); font-weight: bold;">Rp {{ number_format($product->promo_price) }}</div>
                    @else
                        <div style="font-size: 2rem; color: var(--primary); font-weight: bold;">Rp {{ number_format($product->price) }}</div>
                    @endif
                </div>

                <p style="margin-bottom: 1rem;">{{ $product->description }}</p>

                <p style="margin-bottom: 1rem;">
                    <strong>Stok:</strong> {{ $product->stock }}
                </p>

                @if($product->is_kaos && $product->sizes)
                    <div style="margin-bottom: 1rem;">
                        <strong>Ukuran:</strong>
                        <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                            @foreach($product->sizes as $size)
                                <label style="cursor: pointer;">
                                    <input type="radio" name="size" value="{{ $size }}" class="size-radio" style="display: none;">
                                    <span class="size-option" style="padding: 0.5rem 1rem; border: 2px solid #ddd; border-radius: 8px; display: inline-block;">{{ $size }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div style="margin-bottom: 1rem;">
                    <label><strong>Jumlah:</strong></label>
                    <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 100px; padding: 0.5rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                @auth
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="size" id="selectedSize">
                        <input type="hidden" name="quantity" id="hiddenQuantity">
                        <button type="submit" class="btn btn-secondary" style="width: 100%;" onclick="document.getElementById('hiddenQuantity').value = document.getElementById('quantity').value;">+ Tambah ke Keranjang</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="width: 100%; display: block;">Login untuk Membeli</a>
                @endauth
            </div>
        </div>
    </div>

    @if($related->count() > 0)
        <h2 style="margin-top: 3rem; margin-bottom: 1rem;">Produk Terkait</h2>
        <div class="products-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
            @foreach($related as $item)
                <div class="card">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="width: 100%; height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h3 style="margin-bottom: 0.5rem;">{{ $item->name }}</h3>
                        <div style="color: var(--primary); font-weight: bold;">Rp {{ number_format($item->final_price) }}</div>
                        <a href="{{ route('product.detail', $item->slug) }}" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">Lihat</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.size-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.size-option').forEach(opt => {
                opt.style.borderColor = '#ddd';
                opt.style.background = 'white';
            });
            if (this.checked) {
                this.nextElementSibling.style.borderColor = 'var(--primary)';
                this.nextElementSibling.style.background = 'var(--primary)';
                this.nextElementSibling.style.color = 'white';
                document.getElementById('selectedSize').value = this.value;
            }
        });
    });
</script>
@endsection
