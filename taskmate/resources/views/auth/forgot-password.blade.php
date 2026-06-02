<x-guest-layout>
    <div class="mb-4 text-xs font-semibold text-slate-500 leading-relaxed text-center">
        {{ __('Lupa kata sandi Anda? Tidak masalah. Cukup masukkan alamat email Anda di bawah, dan kami akan mengirimkan tautan penyetelan ulang kata sandi melalui email.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold text-slate-700" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <x-primary-button class="w-full py-3 justify-center text-sm font-bold uppercase tracking-wider">
                {{ __('Kirim Tautan Setel Ulang') }}
            </x-primary-button>
        </div>

        <!-- Alternative link -->
        <div class="flex items-center justify-center pt-3 border-t border-slate-100 mt-4 text-xs font-semibold">
            <a class="text-slate-500 hover:text-blue-600 transition-colors duration-200" href="{{ route('login') }}">
                {{ __('Kembali ke Halaman Masuk') }}
            </a>
        </div>
    </form>
</x-guest-layout>
