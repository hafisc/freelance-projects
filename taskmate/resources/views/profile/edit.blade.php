<x-app-layout>
    <!-- Header Halaman -->
    <x-slot name="header">
        Profil Pengguna
    </x-slot>

    <!-- Konten Formulir Profil -->
    <div class="space-y-6 max-w-4xl mx-auto">
        <!-- Informasi Profil -->
        <div class="p-6 sm:p-8 bg-white border border-slate-100 shadow-sm rounded-3xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Ubah Password -->
        <div class="p-6 sm:p-8 bg-white border border-slate-100 shadow-sm rounded-3xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Hapus Akun -->
        <div class="p-6 sm:p-8 bg-white border border-slate-100 shadow-sm rounded-3xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
