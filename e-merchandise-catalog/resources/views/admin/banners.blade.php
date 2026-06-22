@extends('layouts.admin')

@section('title', 'Banner')

@section('content')
<div class="header">
    <h1>Banner</h1>
    <button onclick="openModal('bannerModal')" class="btn btn-secondary">+ Tambah Banner</button>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($banners as $banner)
                <tr>
                    <td><img src="{{ asset('storage/' . $banner->image) }}" alt="" style="width: 100px; height: 50px; object-fit: cover; border-radius: 8px;"></td>
                    <td>{{ $banner->title }}</td>
                    <td>{{ $banner->order }}</td>
                    <td><span class="badge {{ $banner->is_active ? 'badge-success' : 'badge-danger' }}">{{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td>
                        <button onclick="editBanner({{ json_encode($banner) }})" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Edit</button>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display: inline;">
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

<div id="bannerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="bannerModalTitle">Tambah Banner</h3>
            <button type="button" class="close-btn" onclick="closeModal('bannerModal')">&times;</button>
        </div>
        <form id="bannerForm" action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="bannerMethod" value="POST">
            
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="title" id="bannerTitle" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" id="bannerDesc" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="image" id="bannerImage" class="form-control">
            </div>

            <div class="form-group">
                <label>Link</label>
                <input type="url" name="link" id="bannerLink" class="form-control">
            </div>

            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="order" id="bannerOrder" class="form-control" value="0">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" id="bannerActive" value="1" checked> Aktif
                </label>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn" onclick="closeModal('bannerModal')">Batal</button>
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
        document.getElementById('bannerForm').reset();
        document.getElementById('bannerMethod').value = 'POST';
        document.getElementById('bannerForm').action = '{{ route('admin.banners.store') }}';
        document.getElementById('bannerModalTitle').textContent = 'Tambah Banner';
    }

    function editBanner(banner) {
        document.getElementById('bannerTitle').value = banner.title;
        document.getElementById('bannerDesc').value = banner.description;
        document.getElementById('bannerLink').value = banner.link;
        document.getElementById('bannerOrder').value = banner.order;
        document.getElementById('bannerActive').checked = banner.is_active;

        document.getElementById('bannerMethod').value = 'PUT';
        document.getElementById('bannerForm').action = '/admin/banners/' + banner.id;
        document.getElementById('bannerModalTitle').textContent = 'Edit Banner';
        openModal('bannerModal');
    }
</script>
@endsection
