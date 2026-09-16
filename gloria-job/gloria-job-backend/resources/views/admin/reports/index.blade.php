@extends('admin.layouts.admin')

@section('title', 'Laporan & Statistik')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Laporan & Statistik Pelamar</h2>
    <p class="text-sm text-slate-500">Analisis data pelamar per perusahaan dan per kategori pekerjaan.</p>
</div>

<!-- Filter Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mb-8">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Perusahaan</label>
            <select name="company_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-primaryBlue">
                <option value="">Semua Perusahaan</option>
                @foreach($companies as $c)
                    <option value="{{ $c->id }}" {{ $companyId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori</label>
            <select name="category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-primaryBlue">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-primaryBlue">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-primaryBlue">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-grow inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primaryBlue hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-500 rounded-xl text-sm font-bold transition-all" title="Reset">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </form>
    <div class="mt-4 pt-4 border-t border-slate-100 flex gap-3">
        <a href="{{ route('admin.reports.export', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-xl text-xs font-bold transition-all">
            <i class="fa-solid fa-file-excel"></i> Export Excel (Terfilter)
        </a>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Chart: Lamaran Per Bulan -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2"><i class="fa-solid fa-chart-bar text-primaryBlue"></i> Tren Lamaran per Bulan</h4>
        <canvas id="monthlyChart" height="200"></canvas>
    </div>
    <!-- Chart: Distribusi Status -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2"><i class="fa-solid fa-chart-pie text-primaryBlue"></i> Distribusi Status Lamaran</h4>
        <canvas id="statusChart" height="200"></canvas>
    </div>
</div>

<!-- Ringkasan Per Perusahaan -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2"><i class="fa-solid fa-building text-primaryBlue"></i> Ringkasan Per Perusahaan</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50">
                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-3">Perusahaan</th>
                    <th class="px-6 py-3 text-center">Lowongan</th>
                    <th class="px-6 py-3 text-center">Total Pelamar</th>
                    <th class="px-6 py-3 text-center">Menunggu</th>
                    <th class="px-6 py-3 text-center">Diproses</th>
                    <th class="px-6 py-3 text-center">Diterima</th>
                    <th class="px-6 py-3 text-center">Ditolak</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($companyStats as $stat)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-3 font-semibold text-slate-800">{{ $stat['name'] }}</td>
                        <td class="px-6 py-3 text-center text-primaryBlue font-bold">{{ $stat['total_jobs'] }}</td>
                        <td class="px-6 py-3 text-center font-bold text-slate-700">{{ $stat['total_applications'] }}</td>
                        <td class="px-6 py-3 text-center text-amber-500 font-semibold">{{ $stat['pending'] }}</td>
                        <td class="px-6 py-3 text-center text-blue-500 font-semibold">{{ $stat['processing'] }}</td>
                        <td class="px-6 py-3 text-center text-emerald-500 font-semibold">{{ $stat['accepted'] }}</td>
                        <td class="px-6 py-3 text-center text-rose-500 font-semibold">{{ $stat['rejected'] }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-8 text-center text-slate-400">Belum ada data perusahaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Ringkasan Per Kategori -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2"><i class="fa-solid fa-tags text-primaryBlue"></i> Ringkasan Per Kategori Pekerjaan</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50">
                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3 text-center">Lowongan</th>
                    <th class="px-6 py-3 text-center">Total Pelamar</th>
                    <th class="px-6 py-3 text-center">Menunggu</th>
                    <th class="px-6 py-3 text-center">Diproses</th>
                    <th class="px-6 py-3 text-center">Diterima</th>
                    <th class="px-6 py-3 text-center">Ditolak</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($categoryStats as $stat)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-3 font-semibold text-slate-800">{{ $stat['category'] }}</td>
                        <td class="px-6 py-3 text-center text-primaryBlue font-bold">{{ $stat['total_jobs'] }}</td>
                        <td class="px-6 py-3 text-center font-bold text-slate-700">{{ $stat['total_applications'] }}</td>
                        <td class="px-6 py-3 text-center text-amber-500 font-semibold">{{ $stat['pending'] }}</td>
                        <td class="px-6 py-3 text-center text-blue-500 font-semibold">{{ $stat['processing'] }}</td>
                        <td class="px-6 py-3 text-center text-emerald-500 font-semibold">{{ $stat['accepted'] }}</td>
                        <td class="px-6 py-3 text-center text-rose-500 font-semibold">{{ $stat['rejected'] }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-8 text-center text-slate-400">Belum ada data kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Data Pelamar Terfilter -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2"><i class="fa-solid fa-list text-primaryBlue"></i> Data Pelamar ({{ $applications->total() }} hasil)</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-4 py-3">Pelamar</th>
                    <th class="px-4 py-3">Posisi</th>
                    <th class="px-4 py-3">Perusahaan</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($applications as $app)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-3">
                            <div class="font-semibold text-slate-800">{{ $app->full_name }}</div>
                            <div class="text-xs text-slate-400">{{ $app->email }}</div>
                        </td>
                        <td class="px-4 py-3 text-primaryBlue font-medium">{{ $app->job->title ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $app->job->company_display_name ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $app->job->category ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $app->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @php $sc = ['Menunggu'=>'bg-slate-50 text-slate-600','Diproses'=>'bg-blue-50 text-blue-600','Diterima'=>'bg-emerald-50 text-emerald-600','Ditolak'=>'bg-rose-50 text-rose-600']; @endphp
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold {{ $sc[$app->status] ?? '' }}">{{ $app->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-slate-400">Tidak ada data pelamar sesuai filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($applications->hasPages())
        <div class="p-4 border-t border-slate-100">{{ $applications->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Fetch stats from API
    fetch('{{ route("admin.reports.statistics") }}')
        .then(r => r.json())
        .then(data => {
            // Monthly Chart
            new Chart(document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: data.monthly.map(d => d.month),
                    datasets: [{
                        label: 'Jumlah Lamaran',
                        data: data.monthly.map(d => d.count),
                        backgroundColor: 'rgba(37, 99, 235, 0.7)',
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });

            // Status Chart
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(data.status),
                    datasets: [{
                        data: Object.values(data.status),
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                        borderWidth: 0,
                        spacing: 2,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '60%',
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, pointStyle: 'circle' } }
                    }
                }
            });
        });
</script>
@endsection
