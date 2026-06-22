@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="header">
    <h1>Dashboard</h1>
    <div>
        <span>Selamat datang, {{ auth()->user()->name }}!</span>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total_orders'] }}</div>
        <div class="stat-label">Total Pesanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">Rp {{ number_format($stats['total_revenue']) }}</div>
        <div class="stat-label">Total Pendapatan</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $stats['pending_orders'] }}</div>
        <div class="stat-label">Pesanan Pending</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total_products'] }}</div>
        <div class="stat-label">Total Produk</div>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Grafik Pesanan Bulanan</h3>
        <div class="chart-container" style="margin-top: 1rem;">
            <canvas id="orderChart"></canvas>
        </div>
    </div>

    <div class="card">
        <h3>Pesanan Terbaru</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Nama</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>Rp {{ number_format($order->total) }}</td>
                        <td><span class="badge badge-{{ $order->order_status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->order_status) }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('orderChart').getContext('2d');
    const monthlyData = @json($monthlyOrders);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const data = months.map((m, i) => monthlyData[i + 1] || 0);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Jumlah Pesanan',
                data: data,
                backgroundColor: '#1E3A07',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endsection
