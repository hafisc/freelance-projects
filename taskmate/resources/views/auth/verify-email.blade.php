<x-guest-layout>
    <div class="mb-4 text-xs font-semibold text-slate-500 leading-relaxed text-center">
        {{ __('Terima kasih telah mendaftar! Sebelum mulai menggunakan TaskMate, silakan verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan ke email Anda. Jika Anda tidak menerimanya, kami dengan senang hati akan mengirimkan email verifikasi yang baru.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-semibold text-xs text-emerald-600 text-center bg-emerald-50 border border-emerald-100 p-3 rounded-2xl">
            {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat mendaftar.') }}
        </div>
    @endif

    <div class="mt-6 space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full py-3 justify-center text-sm font-bold uppercase tracking-wider">
                {{ __('Kirim Ulang Email Verifikasi') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center pt-2 border-t border-slate-100">
            @csrf
            <button type="submit" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition-colors duration-200 cursor-pointer">
                {{ __('Keluar Aplikasi') }}
            </button>
        </form>
    </div>
</x-guest-layout>
