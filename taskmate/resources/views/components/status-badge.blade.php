@props(['status'])

@php
    $classes = [
        'belum_dikerjakan' => 'bg-red-50 text-red-700 border-red-200/50',
        'sedang_dikerjakan' => 'bg-amber-50 text-amber-700 border-amber-200/50',
        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200/50',
    ][$status] ?? 'bg-slate-50 text-slate-700 border-slate-200/50';

    $label = [
        'belum_dikerjakan' => 'Belum Dikerjakan',
        'sedang_dikerjakan' => 'Sedang Dikerjakan',
        'selesai' => 'Selesai',
    ][$status] ?? 'Tidak Diketahui';
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $classes }} shrink-0">
    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ str_replace('text', 'bg', explode(' ', $classes)[1]) }}"></span>
    {{ $label }}
</span>
