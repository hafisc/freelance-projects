<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EduManage</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (Play CDN for instant rendering in user environment) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        'primary-dark': '#1E40AF',
                        slate: {
                            50: '#F8FAFC',
                            100: '#F1F5F9',
                            200: '#E2E8F0',
                            500: '#64748B',
                            800: '#1E293B',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden selection:bg-blue-100 selection:text-blue-600">

    <!-- Subtle Background Dot Pattern -->
    <div class="absolute inset-0 bg-[radial-gradient(#e2e8f0_1.2px,transparent_1.2px)] [background-size:20px_20px] opacity-70 pointer-events-none z-0"></div>

    <!-- Main Container -->
    <div class="w-full max-w-[450px] bg-white border border-slate-200/80 rounded-3xl shadow-xl shadow-slate-100/60 p-8 md:p-10 z-10 relative">
        
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-xl text-blue-600 text-xs font-semibold uppercase tracking-wider mb-4">
                <i class="fas fa-graduation-cap"></i> EduManage Portal
            </div>
            <h1 class="font-outfit font-bold text-3xl text-slate-800 tracking-tight">Selamat Datang</h1>
            <p class="text-sm text-slate-500 mt-1">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <!-- Session Alert Notification -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200/50 text-emerald-800 px-4 py-3 rounded-2xl text-sm mb-6 flex items-start gap-3">
                <div class="text-emerald-500 shrink-0 mt-0.5"><i class="fas fa-check-circle"></i></div>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200/50 text-rose-800 px-4 py-3 rounded-2xl text-sm mb-6 flex items-start gap-3">
                <div class="text-rose-500 shrink-0 mt-0.5"><i class="fas fa-exclamation-circle"></i></div>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login.process') }}" method="POST" id="loginForm" class="space-y-5">
            @csrf
            
            <!-- Email Input -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                <div class="relative flex items-center">
                    <input type="email" name="email" id="email" class="w-full bg-slate-50 border border-slate-200 focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100 rounded-2xl px-4 py-3.5 pl-11 text-sm text-slate-900 placeholder:text-slate-400 outline-none transition-all duration-200" placeholder="contoh@gmail.com" value="{{ old('email') }}" required autofocus>
                    <i class="fas fa-envelope absolute left-4 text-slate-400 text-sm transition-colors duration-200 input-icon"></i>
                </div>
                @error('email')
                    <span class="text-rose-600 text-xs font-medium mt-1.5 flex items-center gap-1.5"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kata Sandi</label>
                <div class="relative flex items-center">
                    <input type="password" name="password" id="password" class="w-full bg-slate-50 border border-slate-200 focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100 rounded-2xl px-4 py-3.5 pl-11 pr-11 text-sm text-slate-900 placeholder:text-slate-400 outline-none transition-all duration-200" placeholder="Masukkan kata sandi" required>
                    <i class="fas fa-lock absolute left-4 text-slate-400 text-sm transition-colors duration-200 input-icon"></i>
                    <button type="button" class="absolute right-4 text-slate-400 hover:text-slate-600 outline-none focus:outline-none transition-colors" id="passwordToggle" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-rose-600 text-xs font-medium mt-1.5 flex items-center gap-1.5"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Checkbox & Link Row -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600 font-medium">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded-full border-slate-300 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 transition-colors">
                    <span>Ingat Saya</span>
                </label>
                {{-- <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">Lupa Kata Sandi?</a> --}}
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.99] text-white py-3.5 px-4 rounded-2xl text-sm font-bold shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 flex items-center justify-center gap-2 transition-all duration-200 mt-2">
                <span>Masuk</span> <i class="fas fa-arrow-right text-xs"></i>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative flex py-5 items-center">
            <div class="flex-grow border-t border-slate-200/80"></div>
            <span class="flex-shrink mx-4 text-slate-400 text-[10px] font-bold uppercase tracking-wider">ATAU</span>
            <div class="flex-grow border-t border-slate-200/80"></div>
        </div>

        <!-- Quick Demo Credentials Drawer -->
        <div>
            <div class="flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">
                <span>Klik untuk Masuk Demo</span>
                <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded font-semibold text-[9px] lowercase tracking-normal">auto-fill</span>
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <button type="button" onclick="fillCredential('admin@edumanage.test')" class="text-left bg-slate-50 hover:bg-blue-50/40 border border-slate-200/85 hover:border-blue-300 rounded-2xl p-3 transition-all duration-200 group outline-none">
                    <div class="text-[11px] font-bold text-slate-800 flex items-center justify-between">
                        Admin 
                        <i class="fas fa-user-cog text-slate-400 group-hover:text-blue-500 text-[10px] transition-colors"></i>
                    </div>
                    <div class="text-[10px] text-slate-500 mt-0.5 overflow-hidden text-ellipsis whitespace-nowrap">admin@edumanage.test</div>
                </button>

                <button type="button" onclick="fillCredential('dosen@edumanage.test')" class="text-left bg-slate-50 hover:bg-blue-50/40 border border-slate-200/85 hover:border-blue-300 rounded-2xl p-3 transition-all duration-200 group outline-none">
                    <div class="text-[11px] font-bold text-slate-800 flex items-center justify-between">
                        Dosen 
                        <i class="fas fa-chalkboard-teacher text-slate-400 group-hover:text-blue-500 text-[10px] transition-colors"></i>
                    </div>
                    <div class="text-[10px] text-slate-500 mt-0.5 overflow-hidden text-ellipsis whitespace-nowrap">dosen@edumanage.test</div>
                </button>

                <button type="button" onclick="fillCredential('mahasiswa@edumanage.test')" class="text-left bg-slate-50 hover:bg-blue-50/40 border border-slate-200/85 hover:border-blue-300 rounded-2xl p-3 transition-all duration-200 group outline-none">
                    <div class="text-[11px] font-bold text-slate-800 flex items-center justify-between">
                        Mahasiswa 
                        <i class="fas fa-user-graduate text-slate-400 group-hover:text-blue-500 text-[10px] transition-colors"></i>
                    </div>
                    <div class="text-[10px] text-slate-500 mt-0.5 overflow-hidden text-ellipsis whitespace-nowrap">mahasiswa@edumanage.test</div>
                </button>

                <button type="button" onclick="fillCredential('kaprodi@edumanage.test')" class="text-left bg-slate-50 hover:bg-blue-50/40 border border-slate-200/85 hover:border-blue-300 rounded-2xl p-3 transition-all duration-200 group outline-none">
                    <div class="text-[11px] font-bold text-slate-800 flex items-center justify-between">
                        Kaprodi 
                        <i class="fas fa-user-tie text-slate-400 group-hover:text-blue-500 text-[10px] transition-colors"></i>
                    </div>
                    <div class="text-[10px] text-slate-500 mt-0.5 overflow-hidden text-ellipsis whitespace-nowrap">kaprodi@edumanage.test</div>
                </button>
            </div>
        </div>

    </div>

    <!-- Scripting for UI Interactive elements -->
    <script>
        // Input Icon Highlight on focus helper
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                const icon = input.parentElement.querySelector('.input-icon');
                if (icon) icon.classList.replace('text-slate-400', 'text-blue-600');
            });
            input.addEventListener('blur', () => {
                const icon = input.parentElement.querySelector('.input-icon');
                if (icon) icon.classList.replace('text-blue-600', 'text-slate-400');
            });
        });

        // Toggle Password Visibility
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }

        // Auto-fill Credentials for Demo Mode
        function fillCredential(email) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const submitBtn = document.querySelector('button[type="submit"]');
            
            emailInput.value = email;
            passwordInput.value = 'password';
            
            // Add a visual highlight effect
            emailInput.classList.add('ring-4', 'ring-blue-100', 'border-blue-600', 'bg-white');
            passwordInput.classList.add('ring-4', 'ring-blue-100', 'border-blue-600', 'bg-white');
            
            setTimeout(() => {
                emailInput.classList.remove('ring-4', 'ring-blue-100', 'border-blue-600', 'bg-white');
                passwordInput.classList.remove('ring-4', 'ring-blue-100', 'border-blue-600', 'bg-white');
                // Focus the submit button
                submitBtn.focus();
            }, 400);
        }
    </script>

</body>
</html>
