<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-white border border-slate-200 rounded-xl font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition-all duration-200 cursor-pointer']) }}>
    {{ $slot }}
</button>
