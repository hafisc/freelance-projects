<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SI-PBM Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#204a82] min-h-screen flex flex-col items-center justify-center p-4 font-sans">

    <div class="max-w-[420px] w-full">
        <!-- Login Card -->
        <div class="bg-white rounded-[24px] p-8 sm:p-10 shadow-2xl border border-slate-100">
            
            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-50 text-[#204a82] text-3xl mb-4">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-[#204a82] tracking-tight">SI-PBM Portal</h2>
                <p class="text-slate-400 text-xs mt-1">Sistem Informasi Manajemen Belajar Mengajar</p>
            </div>
            
            @if(session()->has('loginError'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm flex items-start gap-3">
                    <i class="bi bi-exclamation-triangle-fill text-base mt-0.5"></i>
                    <div>
                        <span class="font-semibold">Login Gagal:</span> {{ session('loginError') }}
                    </div>
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-5">
                @csrf 
                
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" 
                            class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200 text-sm" 
                            placeholder="nama@sipbm.ac.id" required autofocus>
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" 
                            class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200 text-sm" 
                            placeholder="Masukkan password anda" required>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-3 px-6 rounded-xl shadow-lg shadow-blue-800/10 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                    Masuk Sistem <i class="bi bi-arrow-right text-base"></i>
                </button>
            </form>
            
        </div>
        
        <div class="text-center mt-6 text-white/60 text-xs">
            &copy; 2026 Portal Akademik Kampus &bull; SI-PBM
        </div>
    </div>

</body>
</html>