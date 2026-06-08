<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Media Pembelajaran')</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="{{ asset('css/style_gelombang.css') }}">
    @yield('style')

    <!-- JS GLOBAL -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
</head>

<body>

    <!-- TOP BAR USER -->
    <div class="topbar">

        <div class="topbar-left">
            @auth
                <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle Sidebar">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            @endauth
            <span class="app-name">FisiTera</span>
        </div>

        <div class="topbar-right">

            @auth
                <span class="user-name">
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Logout
                    </button>
                </form>
            @endauth

        </div>
    </div>

    @auth
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    @endauth

    @yield('content')
    @yield('scripts')




    <script>
        let startTime = Date.now();

        function kirimProgress(halaman, urutan) {
            let duration = Math.floor((Date.now() - startTime) / 1000);

            fetch('/simpan-progress', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    halaman: halaman,
                    urutan: urutan,
                    duration: duration
                })
            });
        }
    </script>
</body>

</html>