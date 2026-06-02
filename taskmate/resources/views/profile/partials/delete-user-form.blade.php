<section class="space-y-6">
    <header class="pb-4 border-b border-slate-100">
        <h2 class="text-lg font-bold text-slate-800">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-xs text-slate-500">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, silakan unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="font-bold uppercase tracking-wider"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-4">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-800">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h2>

            <p class="text-xs text-slate-500 leading-relaxed">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mt-4">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full sm:w-3/4"
                    placeholder="{{ __('Masukkan Kata Sandi Anda') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <x-secondary-button x-on:click="$dispatch('close')" class="font-bold uppercase tracking-wider">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="font-bold uppercase tracking-wider">
                    {{ __('Hapus Akun Selamanya') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
