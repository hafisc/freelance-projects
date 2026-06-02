<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold text-slate-700" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-slate-700" />
            <x-text-input id="password" class="block mt-1.5 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer w-4 h-4" name="remember">
                <span class="ms-2 text-xs font-semibold text-slate-500 hover:text-slate-700 transition-colors">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <x-primary-button class="w-full py-3 justify-center text-sm font-bold uppercase tracking-wider">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <!-- Alternative links -->
        <div class="flex items-center justify-between pt-2 text-xs font-semibold border-t border-slate-100 mt-4">
            <a class="text-slate-500 hover:text-blue-600 transition-colors duration-200" href="{{ route('register') }}">
                Belum punya akun? Daftar
            </a>

            @if (Route::has('password.request'))
                <a class="text-slate-500 hover:text-blue-600 transition-colors duration-200" href="{{ route('password.request') }}">
                    Lupa Kata Sandi?
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
