@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
<div class="header">
    <h1>Pesanan</h1>
    <div style="display: flex; gap: 1rem;">
        <form action="{{ route('admin.export') }}" method="GET">
            <input type="date" name="start_date" value="{{ request('start_date') }}" style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ddd;">
            <input type="date" name="end_date" value="{{ request('end_date') }}" style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ddd;">
            <select name="type" style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ddd;">
                <option value="pdf">PDF</option>
                <option value="excel">Excel</option>
            </select>
            <button type="submit" class="btn btn-primary">Export</button>
        </form>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Total</th>
                <th>Status</th>
                <th>Diambil</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ ucfirst($order->customer_type) }}</td>
                    <td>Rp {{ number_format($order->total) }}</td>
                    <td><span class="badge badge-{{ $order->order_status === 'paid' || $order->order_status === 'completed' ? 'success' : 'warning' }}">{{ ucfirst($order->order_status) }}</span></td>
                    <td>{{ $order->is_picked_up ? 'Sudah' : 'Belum' }}</td>
                    <td>
                        <button onclick="viewOrder({{ json_encode($order) }})" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Detail</button>
                        @if(!$order->is_picked_up && $order->order_status === 'paid')
                            <form action="{{ route('admin.orders.pickup', $order->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Tandai Diambil</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="orderModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Pesanan</h3>
            <button type="button" class="close-btn" onclick="closeModal('orderModal')">&times;</button>
        </div>
        <div id="orderModalContent"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    function viewOrder(order) {
        let html = `
            <p><strong>No. Pesanan:</strong> ${order.order_number}</p>
            <p><strong>Nama:</strong> ${order.customer_name}</p>
            <p><strong>Tipe:</strong> ${order.customer_type}</p>
            <p><strong>Email:</strong> ${order.customer_email}</p>
            <p><strong>HP:</strong> ${order.customer_phone}</p>
            ${order.customer_address ? `<p><strong>Alamat:</strong> ${order.customer_address}</p>` : ''}
            ${order.customer_class ? `<p><strong>Kelas:</strong> ${order.customer_class}</p>` : ''}
            <hr>
            <p><strong>Total:</strong> Rp ${Number(order.total).toLocaleString('id-ID')}</p>
            <p><strong>Status:</strong> <span class="badge badge-${order.order_status === 'paid' ? 'success' : 'warning'}">${order.order_status}</span></p>
            <p><strong>Sudah diambil:</strong> ${order.is_picked_up ? 'Ya' : 'Tidak'}</p>
        `;
        
        document.getElementById('orderModalContent').innerHTML = html;
        document.getElementById('orderModal').classList.add('active');
    }
</script>
@endsection
