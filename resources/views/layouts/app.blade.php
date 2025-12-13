<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gedung Farida') }}</title>
    <link rel="icon" href="{{ asset('assets/logo.png') }}?v=2" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Select2 (membutuhkan jQuery) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- Flatpickr (datepicker) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    {{-- Font Awesome (untuk ikon solid) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Alpine JS --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    /* CSS Nav-Item Anda tetap dipertahankan */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem; 
        font-weight: 500;
        color: rgba(255, 255, 255, 0.8); 
        transition: all 0.2s ease;
    }
    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: white; 
    }
    .nav-item.active {
        background-color: white;
        color: #EA580C; 
        font-weight: 600; 
    }

    /* Style untuk SweetAlert Error List */
    .swal-error-list {
        text-align: left;
        padding-left: 1.5rem;
    }
    .swal-error-list li {
        margin-bottom: 0.5rem;
    }
    
    /* Tambahan agar scrollbar di sidebar lebih rapi (opsional) */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 4px;
    }
</style>

<body class="font-sans antialiased bg-gray-100">

<div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

    {{-- MOBILE HEADER --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 z-30 bg-white border-b border-gray-100">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-2">
                <x-application-logo class="h-8 w-8 text-orange-600" />
                <span class="font-bold text-lg text-gray-800">Gedung Farida</span>
            </div>
            <button @click="sidebarOpen = true"
                class="p-2 rounded-md text-gray-600 hover:text-orange-600 hover:bg-orange-50">
                <i data-feather="menu"></i>
            </button>
        </div>
    </div>

    {{-- OVERLAY --}}
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-transition
         class="fixed inset-0 bg-black/50 z-40 lg:hidden">
    </div>

    {{-- SIDEBAR --}}
    <nav
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100
               transform transition-transform duration-300 lg:static lg:translate-x-0
               flex flex-col">

        {{-- Sidebar kamu (TIDAK diubah desainnya) --}}
        @include('layouts.navigation')
    </nav>

    {{-- CONTENT --}}
    <div class="flex-1 flex flex-col overflow-hidden ">

        {{-- HEADER DESKTOP --}}
        @isset($header)
            <header class="hidden lg:block bg-white border-b border-gray-200 sticky top-0 z-20">
                <div class="px-6 py-4">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- MAIN --}}
        <main class="flex-1 overflow-y-auto bg-gray-100 p-6 mt-16 lg:mt-0">
            {{ $slot }}
        </main>

    </div>

</div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    
        document.addEventListener('alpine:init', () => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
    
            Alpine.effect(() => {
                Alpine.nextTick(() => {
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                });
            });
        });
    </script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });

        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    Toast.fire({ icon: 'info', title: "{{ Session::get('message') }}" }); break;
                case 'success':
                    Toast.fire({ icon: 'success', title: "{{ Session::get('message') }}" }); break;
                case 'warning':
                    Toast.fire({ icon: 'warning', title: "{{ Session::get('message') }}" }); break;
                case 'error':
                    Toast.fire({ icon: 'error', title: "{{ Session::get('message') }}" }); break;
            }
        @endif

        @if ($errors->any())
            let errors = `<ul class="swal-error-list">`;
            @foreach ($errors->all() as $error)
                errors += `<li>{{ $error }}</li>`;
            @endforeach
            errors += `</ul>`;
            Swal.fire({ icon: 'error', title: "Terjadi Kesalahan", html: errors });
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>