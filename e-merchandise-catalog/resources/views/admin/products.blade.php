@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="header">
    <h1>Produk</h1>
    <button onclick="openModal('productModal')" class="btn btn-secondary">+ Tambah Produk</button>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>Rp {{ number_format($product->final_price) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td><span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td>
                        <button onclick="editProduct({{ json_encode($product) }})" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Edit</button>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" onclick="return confirm('Yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="productModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="productModalTitle">Tambah Produk</h3>
            <button type="button" class="close-btn" onclick="closeModal('productModal')">&times;</button>
        </div>
        <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="productMethod" value="POST">
            
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" id="productName" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" id="productDesc" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="image" id="productImage" class="form-control">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" id="productPrice" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Harga Promo</label>
                    <input type="number" name="promo_price" id="productPromo" class="form-control">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Tipe</label>
                    <select name="type" id="productType" class="form-control">
                        <option value="non-kaos">Non-Kaos</option>
                        <option value="kaos">Kaos</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" id="productStock" class="form-control" value="0">
                </div>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" id="productCategory" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Ukuran (untuk kaos, pisahkan dengan koma)</label>
                <input type="text" name="sizes" id="productSizes" class="form-control" placeholder="S, M, L, XL">
            </div>

            <div class="form-group">
                <label>Tags (pisahkan dengan koma)</label>
                <input type="text" name="tags" id="productTags" class="form-control" placeholder="baru, bestseller">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" id="productActive" value="1" checked> Aktif
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_promo" id="productPromoCheck" value="1"> Promo
                    </label>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn" onclick="closeModal('productModal')">Batal</button>
                <button type="submit" class="btn btn-secondary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.getElementById('productForm').reset();
        document.getElementById('productMethod').value = 'POST';
        document.getElementById('productForm').action = '{{ route('admin.products.store') }}';
        document.getElementById('productModalTitle').textContent = 'Tambah Produk';
    }

    function editProduct(product) {
        document.getElementById('productName').value = product.name;
        document.getElementById('productDesc').value = product.description;
        document.getElementById('productPrice').value = product.price;
        document.getElementById('productPromo').value = product.promo_price;
        document.getElementById('productType').value = product.type;
        document.getElementById('productStock').value = product.stock;
        document.getElementById('productCategory').value = product.category_id;
        document.getElementById('productSizes').value = product.sizes ? product.sizes.join(', ') : '';
        document.getElementById('productTags').value = product.tags ? product.tags.join(', ') : '';
        document.getElementById('productActive').checked = product.is_active;
        document.getElementById('productPromoCheck').checked = product.is_promo;

        document.getElementById('productMethod').value = 'PUT';
        document.getElementById('productForm').action = '/admin/products/' + product.id;
        document.getElementById('productModalTitle').textContent = 'Edit Produk';
        openModal('productModal');
    }
</script>
@endsection
