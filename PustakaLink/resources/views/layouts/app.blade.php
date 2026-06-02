<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PustakaLink - Sistem Informasi Perpustakaan' }}</title>
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        libnavy: '#1E3A5F',
                        libcream: '#F8F5EF',
                        libgold: '#D9A441',
                        libdark: '#1F2937',
                        libmuted: '#6B7280',
                        libborder: '#E5E7EB',
                        libsuccess: '#16A34A',
                        libdanger: '#DC2626',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        html {
            font-size: 15px;
        }
        @media (min-width: 768px) {
            html {
                font-size: 16px;
            }
        }
        @media (min-width: 1200px) {
            html {
                font-size: 17px;
            }
        }
        @media (min-width: 1600px) {
            html {
                font-size: 18px;
            }
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F5EF; /* libcream */
            color: #1F2937; /* libdark */
            -webkit-font-smoothing: antialiased;
        }
        /* Custom scrollbar untuk tampilan modern */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F8F5EF;
        }
        ::-webkit-scrollbar-thumb {
            background: #E5E7EB;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #D9A441;
        }
        
        /* Animasi Transisi Halus */
        .fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row overflow-x-hidden">

    <!-- Sidebar Kiri -->
    @include('layouts.sidebar')

    <!-- Konten Utama (Kanan) -->
    <div class="flex-1 flex flex-col min-w-0 md:pl-64">
        
        <!-- Topbar -->
        @include('layouts.topbar')

        <!-- Area Konten Utama -->
        <main class="flex-1 p-6 md:p-10 max-w-[1600px] w-full mx-auto fade-in">
            @yield('content')
        </main>
        
        
    </div>

    <!-- Sistem Toast Notification Global -->
    @if(session('toast_success') || session('toast_error') || $errors->any())
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-md w-full sm:w-auto">
        
        @if(session('toast_success'))
        <div class="toast-item flex items-center p-4 bg-white border-l-4 border-libsuccess shadow-md rounded-md transform transition-all duration-300 translate-y-10 opacity-0" role="alert">
            <svg class="w-5 h-5 text-libsuccess mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm font-medium text-libdark">{{ session('toast_success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-libmuted hover:text-libdark transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @endif

        @if(session('toast_error'))
        <div class="toast-item flex items-center p-4 bg-white border-l-4 border-libdanger shadow-md rounded-md transform transition-all duration-300 translate-y-10 opacity-0" role="alert">
            <svg class="w-5 h-5 text-libdanger mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span class="text-sm font-medium text-libdark">{{ session('toast_error') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-libmuted hover:text-libdark transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast-item');
            toasts.forEach((toast, index) => {
                setTimeout(() => {
                    toast.classList.remove('translate-y-10', 'opacity-0');
                    toast.classList.add('translate-y-0', 'opacity-100');
                }, index * 150 + 100);

                // Auto close setelah 4 detik
                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-y-[-10px]');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 4500);
            });
        });
    </script>
    @endif

    @yield('scripts')
</body>
</html>
