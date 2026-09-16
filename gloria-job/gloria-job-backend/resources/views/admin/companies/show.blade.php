@extends('admin.layouts.admin')

@section('title', 'Detail Perusahaan: ' . $company->name)

@section('content')
<!-- Back Link & Title -->
<div class="mb-8">
    <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 border border-slate-200 rounded-xl text-xs font-bold transition-all duration-150 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Company Profile Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-10 mb-8">
    <div class="flex flex-col md:flex-row gap-6 items-start">
        @if($company->logo)
            <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" class="h-24 w-24 object-cover rounded-2xl border border-slate-200 shadow-sm">
        @else
            <div class="h-24 w-24 rounded-2xl bg-blue-50 text-primaryBlue flex items-center justify-center font-extrabold text-3xl border border-blue-100">
                {{ strtoupper(substr($company->name, 0, 2)) }}
            </div>
        @endif
        <div class="flex-grow">
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight mb-1">{{ $company->name }}</h2>
            @if($company->industry)
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-primaryBlue border border-blue-100 mb-3">
                    <i class="fa-solid fa-industry"></i> {{ $company->industry }}
                </span>
            @endif
            @if($company->description)
                <p class="text-sm text-slate-500 leading-relaxed mt-2">{{ $company->description }}</p>
            @endif
        </div>
        <div class="flex gap-2 flex-shrink-0">
            <a href="{{ route('admin.companies.edit', $company->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-xl text-xs font-bold transition-all">
                <i class="fa-regular fa-pen-to-square"></i> Edit
            </a>
            <form action="{{ route('admin.companies.share', $company->id) }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-xl text-xs font-bold transition-all" onclick="return confirm('Export dan tandai semua data pelamar sebagai shared ke {{ $company->name }}?')">
                    <i class="fa-solid fa-share-nodes"></i> Share Data Pelamar
                </button>
            </form>
        </div>
    </div>

    <!-- Contact Details Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6 pt-6 border-t border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center"><i class="fa-regular fa-envelope"></i></div>
            <div><div class="text-xs text-slate-400 font-medium">Email</div><div class="text-sm font-semibold text-slate-700">{{ $company->email ?? '-' }}</div></div>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center"><i class="fa-solid fa-phone"></i></div>
            <div><div class="text-xs text-slate-400 font-medium">Telepon</div><div class="text-sm font-semibold text-slate-700">{{ $company->phone ?? '-' }}</div></div>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center"><i class="fa-solid fa-globe"></i></div>
            <div><div class="text-xs text-slate-400 font-medium">Website</div><div class="text-sm font-semibold text-slate-700">{{ $company->website ?? '-' }}</div></div>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center"><i class="fa-solid fa-location-dot"></i></div>
            <div><div class="text-xs text-slate-400 font-medium">Alamat</div><div class="text-sm font-semibold text-slate-700">{{ Str::limit($company->address, 40) ?? '-' }}</div></div>
        </div>
    </div>

    @if($company->pic_name || $company->pic_phone)
    <div class="mt-4 pt-4 border-t border-slate-100">
        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Contact Person (PIC)</h4>
        <div class="flex items-center gap-4">
            <span class="text-sm font-semibold text-slate-700"><i class="fa-solid fa-user-tie text-primaryBlue mr-1"></i> {{ $company->pic_name ?? '-' }}</span>
            <span class="text-sm text-slate-500"><i class="fa-solid fa-phone text-slate-300 mr-1"></i> {{ $company->pic_phone ?? '-' }}</span>
        </div>
    </div>
    @endif
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
        <div class="text-2xl font-extrabold text-primaryBlue">{{ $totalJobs }}</div>
        <div class="text-xs text-slate-400 font-semibold uppercase mt-1">Lowongan</div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
        <div class="text-2xl font-extrabold text-purple-600">{{ $totalApplications }}</div>
        <div class="text-xs text-slate-400 font-semibold uppercase mt-1">Total Pelamar</div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
        <div class="text-2xl font-extrabold text-amber-500">{{ $pendingApplications }}</div>
        <div class="text-xs text-slate-400 font-semibold uppercase mt-1">Menunggu</div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
        <div class="text-2xl font-extrabold text-emerald-500">{{ $acceptedApplications }}</div>
        <div class="text-xs text-slate-400 font-semibold uppercase mt-1">Diterima</div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
        <div class="text-2xl font-extrabold text-rose-500">{{ $rejectedApplications }}</div>
        <div class="text-xs text-slate-400 font-semibold uppercase mt-1">Ditolak</div>
    </div>
</div>

<!-- Jobs & Applications List -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-briefcase text-primaryBlue"></i> Daftar Lowongan & Pelamar
        </h3>
    </div>

    @forelse($company->jobs as $job)
        <div class="border-b border-slate-50 last:border-0">
            <div class="p-4 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <span class="font-bold text-sm text-slate-800">{{ $job->title }}</span>
                    <span class="text-xs text-slate-400 ml-2">{{ $job->category ?? '' }} · {{ $job->location }}</span>
                    @if($job->salary_display)
                        <span class="ml-2 text-xs font-semibold text-emerald-600">{{ $job->salary_display }}</span>
                    @endif
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold {{ $job->status === 'Aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                    {{ $job->status }}
                </span>
            </div>

            @if($job->applications->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="px-4 py-2">Pelamar</th>
                                <th class="px-4 py-2">No. HP</th>
                                <th class="px-4 py-2">Tanggal</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">CV</th>
                                <th class="px-4 py-2">Shared</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($job->applications as $app)
                                <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                                    <td class="px-4 py-2">
                                        <div class="font-semibold text-slate-700">{{ $app->full_name }}</div>
                                        <div class="text-xs text-slate-400">{{ $app->email }}</div>
                                    </td>
                                    <td class="px-4 py-2 text-slate-500">{{ $app->phone }}</td>
                                    <td class="px-4 py-2 text-slate-400 text-xs">{{ $app->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-2">
                                        @php $sc = ['Menunggu'=>'bg-slate-50 text-slate-600','Diproses'=>'bg-blue-50 text-blue-600','Diterima'=>'bg-emerald-50 text-emerald-600','Ditolak'=>'bg-rose-50 text-rose-600']; @endphp
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold {{ $sc[$app->status] ?? 'bg-slate-50 text-slate-600' }}">{{ $app->status }}</span>
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($app->cv_path)
                                            <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="text-primaryBlue text-xs font-semibold hover:underline"><i class="fa-solid fa-file-pdf mr-1"></i>Lihat</a>
                                        @elseif($app->user && $app->user->cv)
                                            <a href="{{ asset('storage/' . $app->user->cv) }}" target="_blank" class="text-slate-400 text-xs font-semibold hover:underline"><i class="fa-solid fa-file mr-1"></i>Profil</a>
                                        @else
                                            <span class="text-xs text-slate-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($app->cv_shared_at)
                                            <span class="text-xs text-emerald-500 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i>{{ $app->cv_shared_at->format('d/m/Y') }}</span>
                                        @else
                                            <span class="text-xs text-slate-300">Belum</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-4 py-3 text-xs text-slate-400 italic">Belum ada pelamar untuk lowongan ini.</div>
            @endif
        </div>
    @empty
        <div class="p-12 text-center text-slate-400">
            <i class="fa-regular fa-folder-open text-4xl mb-3 block text-slate-300"></i>
            <span class="font-medium text-sm">Perusahaan ini belum memiliki lowongan kerja.</span>
        </div>
    @endforelse
</div>
@endsection
