<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Gloria Job</title>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS v3 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brandNavy: '#1e3a8a',
                        brandBlue: '#2563eb',
                    }
                }
            }
        }
    </script>
    <style>
        .left-bg-gradient {
            background-color: #1e3a8a;
            background-image: radial-gradient(at 100% 50%, rgba(37, 99, 235, 0.15) 0px, transparent 60%);
        }
    </style>
</head>
<body class="bg-[#fafbfc] font-sans text-slate-800 antialiased h-screen overflow-hidden">

<div class="h-screen flex">
    <!-- Left Side: Brand Panel (Matches JelajahKode style) -->
    <div class="hidden lg:flex flex-col justify-between w-7/12 left-bg-gradient p-20 text-white relative overflow-hidden">
        
        <!-- Logo -->
        <div class="z-10 flex items-center gap-3">
            <img src="{{ asset('assets/images/logo.jpg') }}" alt="Gloria Job Logo" class="h-9 w-9 object-contain rounded shadow-sm">
            <span class="font-extrabold text-xl tracking-wider uppercase">GLORIA JOB</span>
        </div>
        
        <!-- Main Header Text -->
        <div class="z-10 max-w-lg my-auto">
            <h1 class="text-[42px] font-extrabold tracking-tight leading-[1.2] mb-6">
                Kelola lowongan & <br>
                <span class="text-[#38bdf8]">pelamar kerja</span> <br>
                Anda dari satu <br>
                panel.
            </h1>
            <p class="text-slate-400 text-sm leading-relaxed max-w-md">
                Masuk aman untuk mengelola data pekerjaan, memverifikasi berkas pelamar, serta memperbarui hasil seleksi rekrutmen — perubahan langsung terlihat di aplikasi pencari kerja.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="z-10 text-slate-500 text-xs font-semibold">
            &copy; 2026 PT. Gloria Jasa Mandiri.
        </div>
    </div>

    <!-- Right Side: Form Panel -->
    <div class="flex-grow flex items-center justify-center p-8 lg:p-16 bg-[#fafbfc]">
        <!-- Floating Login Card (Exactly like reference) -->
        <div class="w-full max-w-[460px] bg-white p-12 rounded-[2.5rem] shadow-[0_15px_50px_rgba(15,23,42,0.04)] border border-slate-100/60">
            
            <!-- Mobile Logo Header (Only Visible on Mobile) -->
            <div class="lg:hidden flex items-center gap-3 mb-8">
                <img src="{{ asset('assets/images/logo.jpg') }}" alt="Gloria Job Logo" class="h-9 w-9 object-contain rounded">
                <span class="font-black text-xl tracking-wider text-brandNavy">GLORIA JOB</span>
            </div>

            <!-- Header -->
            <div class="mb-10">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h2>
                <p class="text-sm text-slate-400 mt-2">Silakan masuk untuk mengelola portal Gloria Job.</p>
            </div>

            <!-- Error Alerts -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-800 rounded-2xl text-xs font-semibold">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-base text-emerald-600"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Email Admin</label>
                    <input type="email" 
                           class="w-full bg-[#f8fafc] border border-slate-100 rounded-2xl px-4 py-4 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-brandBlue focus:ring-4 focus:ring-brandBlue/5 transition-all duration-150" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="admin@gmail.com" 
                           required 
                           autofocus>
                </div>
                
                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Password</label>
                    <div class="relative">
                        <input type="password" 
                               class="w-full bg-[#f8fafc] border border-slate-100 rounded-2xl pl-4 pr-12 py-4 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-brandBlue focus:ring-4 focus:ring-brandBlue/5 transition-all duration-150" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••" 
                               required>
                        <!-- Password Visibility Toggle -->
                        <button type="button" 
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors duration-150">
                            <i class="fa-regular fa-eye text-base" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-brandBlue border-slate-200 rounded focus:ring-brandBlue/20">
                    <label for="remember" class="text-xs text-slate-500 font-medium ml-2 cursor-pointer select-none">Ingat saya di perangkat ini</label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-4 bg-brandNavy hover:bg-[#1554b8] text-white font-bold text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-brandNavy/10 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150 mt-8">
                    Masuk Ke Panel Admin
                </button>
            </form>
            
            <!-- Footer Link -->
            <div class="mt-8 text-center text-xs text-slate-400 font-medium">
                Butuh akses? <a href="#" class="text-brandBlue hover:underline font-semibold">Hubungi kami</a>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle eye icon
        if (type === 'password') {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    });
</script>

</body>
</html>
