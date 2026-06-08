@extends('layouts.app')

@section('content')

    @yield('style')

    <div class="layout-wrapper guru-layout">

        {{-- SIDEBAR --}}
        <aside class="sidebar">

            <div class="sidebar-header">
                Menu Guru
            </div>

            <div class="menu">


                <a class="menu-item {{ request()->is('guru-siswa*') ? 'active' : '' }}" href="/guru-siswa">
                    Data Siswa
                </a>

                <a class="menu-item {{ request()->is('guru-nilai*') ? 'active' : '' }}" href="/guru-nilai">
                    Data Nilai
                </a>

                <a class="menu-item {{ request()->is('guru-progres') ? 'active' : '' }}" href="/guru-progres">
                    Progres Siswa
                </a>

            </div>

        </aside>

        {{-- CONTENT --}}
        <main class="main-content">
            @yield('guru-content')
        </main>

    </div>

@endsection