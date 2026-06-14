<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kaprodi Dashboard') | EduManage</title>
    
    <!-- Link Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    
    @yield('styles')
</head>
<body>

    <!-- Sidebar Kaprodi -->
    @include('kaprodi.partials.sidebar')

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Topbar Kaprodi -->
        @include('kaprodi.partials.topbar')

        <!-- Content Area -->
        <div class="content-wrapper">
            <!-- Flash Alert Success / Error -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Main Yield Content -->
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
