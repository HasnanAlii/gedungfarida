<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gedung Farida') }}</title>
    <link rel.icon" href="{{ asset('assets/logo.png') }}?v=2" type="image/png">

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
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<style>
    /* PERBAIKAN: 
      - .nav-item: Dibuat lebih kontras (putih opacity 80%)
      - .nav-item.active: 'color' diubah menjadi 'text-orange-600' agar terlihat
    */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem; /* rounded-xl */
        font-weight: 500;
        color: rgba(255, 255, 255, 0.8); /* Teks putih pudar */
        transition: all 0.2s ease;
    }
    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: white; /* Teks putih solid saat hover */
    }
    .nav-item.active {
        background-color: white;
        color: #EA580C; /* PERBAIKAN: Ini adalah text-orange-600 */
        font-weight: 600; /* Dibuat tebal */
    }

    /* Style untuk SweetAlert Error List */
    .swal-error-list {
        text-align: left;
        padding-left: 1.5rem;
    }
    .swal-error-list li {
        margin-bottom: 0.5rem;
    }
</style>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">
        {{-- Navigation --}}
        @include('layouts.navigation')

        @isset($header)
            {{-- PERBAIKAN: Header dibuat lebih rapi dengan border --}}
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center sm:text-left">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- PERBAIKAN: Padding ditambah agar tidak terlalu mepet --}}
        <main class="flex-1 w-full bg-gradient-to-b from-gray-100 to-orange-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </div>
        </main>

        <script>
            // 1. Panggil saat DOM dimuat (halaman awal)
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            });
        
            // 2. Panggil lagi setelah Alpine.js dimuat
            document.addEventListener('alpine:init', () => {
                // Panggil saat inisialisasi
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
        
                // 3. Panggil setiap kali Alpine memperbarui DOM (paling penting)
                Alpine.effect(() => {
                    // $nextTick menunggu Alpine selesai melakukan perubahan DOM
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
    </div>
</body>
</html>