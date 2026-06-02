<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-semibold text-slate-700" />
            <x-text-input id="name" class="block mt-1.5 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold text-slate-700" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-slate-700" />
            <x-text-input id="password" class="block mt-1.5 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-semibold text-slate-700" />
            <x-text-input id="password_confirmation" class="block mt-1.5 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <x-primary-button class="w-full py-3 justify-center text-sm font-bold uppercase tracking-wider">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>

        <!-- Alternative link -->
        <div class="flex items-center justify-center pt-3 border-t border-slate-100 mt-4 text-xs font-semibold">
            <a class="text-slate-500 hover:text-blue-600 transition-colors duration-200" href="{{ route('login') }}">
                {{ __('Sudah punya akun? Masuk') }}
            </a>
        </div>
    </form>
</x-guest-layout>
