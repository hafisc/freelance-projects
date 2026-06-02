@props(['title', 'value', 'iconBg' => 'bg-blue-50', 'iconColor' => 'text-blue-600'])

<div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition-all duration-300">
    <div class="space-y-1">
        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $title }}</span>
        <h3 class="text-3xl font-bold text-slate-900 leading-none">{{ $value }}</h3>
    </div>
    <div class="w-12 h-12 rounded-xl {{ $iconBg }} {{ $iconColor }} flex items-center justify-center shrink-0">
        {{ $slot }}
    </div>
</div>
