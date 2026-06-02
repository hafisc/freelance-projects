@props(['priority'])

@php
    $classes = [
        'tinggi' => 'bg-rose-50 text-rose-700 border-rose-200/50',
        'sedang' => 'bg-amber-50 text-amber-700 border-amber-200/50',
        'rendah' => 'bg-blue-50 text-blue-700 border-blue-200/50',
    ][$priority] ?? 'bg-slate-50 text-slate-700 border-slate-200/50';

    $label = [
        'tinggi' => 'Tinggi',
        'sedang' => 'Sedang',
        'rendah' => 'Rendah',
    ][$priority] ?? 'Tidak Diketahui';
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $classes }} shrink-0">
    {{ $label }}
</span>
