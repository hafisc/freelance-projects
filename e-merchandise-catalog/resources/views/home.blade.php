@extends('layouts.app')

@section('title', 'CMB Merch - Beranda')

@section('styles')
<style>
    .banner-slider {
        height: 400px;
        overflow: hidden;
        position: relative;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .banner-slide {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .product-card {
        transition: transform 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--primary);
    }

    .product-promo {
        text-decoration: line-through;
        color: #999;
        font-size: 0.875rem;
    }

    .promo-badge {
        background: var(--danger);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .categories-section {
        margin-bottom: 2rem;
    }

    .category-list {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding: 0.5rem 0;
    }

    .category-item {
        background: var(--white);
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        text-decoration: none;
        color: var(--primary);
        white-space: nowrap;
        border: 2px solid var(--primary);
        transition: all 0.3s;
    }

    .category-item:hover, .category-item.active {
        background: var(--primary);
        color: var(--white);
    }
</style>
@endsection

@section('content')
<div class="container">
    @if($banners->count() > 0)
        <div class="banner-slider">
            <img src="{{ asset('storage/' . $banners[0]->image) }}" alt="{{ $banners[0]->title }}" class="banner-slide">
        </div>
    @endif

    <section class="categories-section">
        <h2>Kategori</h2>
        <div class="category-list">
            <a href="{{ route('home') }}" class="category-item {{ !request('category') ? 'active' : '' }}">Semua</a>
            @foreach($categories as $category)
                <a href="{{ route('search', ['category' => $category->id]) }}" class="category-item {{ request('category') == $category->id ? 'active' : '' }}">{{ $category->name }}</a>
            @endforeach
        </div>
    </section>

    <h2>Produk Terbaru</h2>
    <div class="products-grid">
        @foreach($products as $product)
            <div class="card product-card">
                <div style="position: relative;">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                    @if($product->is_promo)
                        <span class="promo-badge">PROMO</span>
                    @endif
                </div>
                <div class="card-body">
                    <h3 style="margin-bottom: 0.5rem;">{{ $product->name }}</h3>
                    <div class="product-price">
                        @if($product->is_promo && $product->promo_price)
                            <span class="product-promo">Rp {{ number_format($product->price) }}</span>
                            Rp {{ number_format($product->promo_price) }}
                        @else
                            Rp {{ number_format($product->price) }}
                        @endif
                    </div>
                    <p style="color: #666; font-size: 0.875rem; margin: 0.5rem 0;">
                        Stok: {{ $product->stock }}
                    </p>
                    <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-primary" style="width: 100%;">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>

    {{ $products->links() }}
</div>

<div id="infoModal" class="modal">
    <div class="modal-content">
        <h2>Selamat Datang di CMB Merch!</h2>
        <p>Temukan berbagai merchandise eksklusif Cresta Mandala Bhakti!</p>
        <button onclick="document.getElementById('infoModal').classList.remove('active')" class="btn btn-primary">OK</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    setTimeout(() => {
        document.getElementById('infoModal').classList.add('active');
    }, 1000);
</script>
@endsection
