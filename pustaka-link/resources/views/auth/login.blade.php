<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PustakaLink</title>
    
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
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-libcream min-h-screen flex items-center justify-center p-4">

    <!-- Card Login -->
    <div class="bg-white rounded-lg border border-libborder shadow-sm max-w-md w-full p-8 md:p-10">
        
        <!-- Logo / Nama Aplikasi -->
        <div class="text-center mb-8">
            <img src="{{ asset('logo.png') }}" alt="Logo PustakaLink" class="w-16 h-16 mx-auto mb-3 object-contain">
            <h2 class="text-2xl font-bold text-libnavy tracking-tight">PustakaLink</h2>
            <p class="text-xs text-libmuted mt-1 font-medium">Sistem Informasi Perpustakaan Internal</p>
        </div>

        <!-- Form Login -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <!-- Email Input -->
            <div>
                <label for="email" class="block text-xs font-semibold text-libdark uppercase tracking-wider mb-2">Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 bg-white border @error('email') border-libdanger @else border-libborder @enderror rounded-md text-sm text-libdark focus:outline-none focus:border-libgold transition"
                        placeholder="contoh@email.com">
                </div>
                @error('email')
                    <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-xs font-semibold text-libdark uppercase tracking-wider mb-2">Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-3 bg-white border @error('password') border-libdanger @else border-libborder @enderror rounded-md text-sm text-libdark focus:outline-none focus:border-libgold transition"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Lupa Password Bantuan -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-libmuted cursor-pointer font-medium select-none">
                    <input type="checkbox" name="remember" class="mr-2 rounded text-libgold focus:ring-libgold border-libborder">
                    Ingat Sesi Saya
                </label>
                <span class="text-libmuted font-medium hover:text-libgold transition cursor-pointer" onclick="alert('Silakan hubungi administrator TI perpustakaan untuk mereset kata sandi Anda.')">
                    Bantuan?
                </span>
            </div>

            <!-- Button Submit -->
            <button type="submit" id="btn-login" class="w-full py-3 bg-libnavy text-white rounded-md text-sm font-semibold tracking-wide hover:bg-libnavy/90 hover:shadow-sm transition duration-200 flex items-center justify-center">
                <span>Masuk ke Sistem</span>
            </button>
        </form>

        <!-- Kredensial Bantuan Instan (Bagus untuk Praktik Demonstrasi) -->
        <div class="mt-8 pt-6 border-t border-libborder text-center">
            <span class="text-[10px] font-bold text-libgold uppercase tracking-wider block mb-2">Akun Demo Praktik</span>
            <div class="text-xs text-libmuted bg-libcream/50 rounded p-2.5 space-y-1 font-mono text-left inline-block w-full">
                <div><span class="font-semibold text-libnavy">Email:</span> admin@pustakalink.com</div>
                <div><span class="font-semibold text-libnavy">Sandi:</span> password</div>
            </div>
        </div>
    </div>

</body>
</html>
