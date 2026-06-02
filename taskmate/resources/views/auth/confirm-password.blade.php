<x-guest-layout>
    <div class="mb-4 text-xs font-semibold text-slate-500 leading-relaxed text-center">
        {{ __('Ini adalah area aman aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-slate-700" />
            <x-text-input id="password" class="block mt-1.5 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <x-primary-button class="w-full py-3 justify-center text-sm font-bold uppercase tracking-wider">
                {{ __('Konfirmasi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
