@extends('layouts.admin')

@section('title', 'Voucher')

@section('content')
<div class="header">
    <h1>Voucher</h1>
    <button onclick="openModal('voucherModal')" class="btn btn-secondary">+ Tambah Voucher</button>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Nilai</th>
                <th>Digunakan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vouchers as $voucher)
                <tr>
                    <td><strong>{{ $voucher->code }}</strong></td>
                    <td>{{ $voucher->name }}</td>
                    <td>{{ ucfirst($voucher->type) }}</td>
                    <td>{{ $voucher->type === 'percentage' ? $voucher->value . '%' : 'Rp ' . number_format($voucher->value) }}</td>
                    <td>{{ $voucher->used_count }} / {{ $voucher->usage_limit ?? '∞' }}</td>
                    <td><span class="badge {{ $voucher->is_active ? 'badge-success' : 'badge-danger' }}">{{ $voucher->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td>
                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" style="display: inline;">
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

<div id="voucherModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Voucher</h3>
            <button type="button" class="close-btn" onclick="closeModal('voucherModal')">&times;</button>
        </div>
        <form action="{{ route('admin.vouchers.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Kode Voucher</label>
                <input type="text" name="code" class="form-control" required placeholder="contoh: RAMADHAN2024">
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Tipe</label>
                <select name="type" class="form-control">
                    <option value="percentage">Persentase</option>
                    <option value="fixed">Nominal Tetap</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nilai</label>
                <input type="number" name="value" class="form-control" required>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Min. Order</label>
                    <input type="number" name="min_order" class="form-control">
                </div>
                <div class="form-group">
                    <label>Max. Diskon</label>
                    <input type="number" name="max_discount" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label>Batas Penggunaan</label>
                <input type="number" name="usage_limit" class="form-control">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Berlaku Dari</label>
                    <input type="datetime-local" name="valid_from" class="form-control">
                </div>
                <div class="form-group">
                    <label>Berlaku Sampai</label>
                    <input type="datetime-local" name="valid_until" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" checked> Aktif
                </label>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn" onclick="closeModal('voucherModal')">Batal</button>
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
    }
</script>
@endsection
