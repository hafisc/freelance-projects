@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-50 border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-sm transition-all duration-200']) }}>
