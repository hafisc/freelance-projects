<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskMate') }}</title>

        <!-- Fonts (Inter) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="h-full antialiased text-slate-900">
        <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 bg-slate-100">
            <div class="w-full sm:max-w-md bg-white border border-slate-200/60 shadow-2xl shadow-slate-300/30 p-8 rounded-3xl">
                <!-- Branding Header -->
                <div class="flex flex-col items-center mb-6">
                    <img src="{{ asset('logo.png') }}" alt="TaskMate Logo" class="w-14 h-14 rounded-2xl shadow-lg shadow-blue-500/10 mb-3 object-contain">
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Task<span class="text-blue-600">Mate</span></h2>
                    <p class="text-sm text-slate-500 mt-1 text-center">Kelola tugas, deadline, dan aktivitas harian dengan lebih rapi</p>
                </div>

                <!-- Form Content Slot -->
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
