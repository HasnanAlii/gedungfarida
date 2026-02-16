<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Gedung Farida') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
        <header class="glass-nav fixed w-full top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-orange-500/30">
                    <span class="font-serif font-bold italic">F</span>
                </div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 tracking-tight">
                    Gedung<span class="text-orange-600">Farida</span>
                </h1>
            </div>
            
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#galeri" class="hover:text-orange-600 transition-colors">Galeri</a>
                <a href="#fasilitas" class="hover:text-orange-600 transition-colors">Fasilitas</a>
                <a href="#harga" class="hover:text-orange-600 transition-colors">Harga</a>
                <a href="#pemesanan" class="hover:text-orange-600 transition-colors">Cara Pesan</a>
            </nav>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition-all shadow-lg shadow-gray-900/10">
                           Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-6 py-2.5 bg-orange-600 text-white text-sm font-bold rounded-full hover:bg-orange-700 hover:shadow-lg hover:shadow-orange-600/30 transition-all transform hover:-translate-y-0.5">
                           Masuk / Daftar
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <section class="py-20 md:py-28">
        <div class="max-w-7xl mx-auto px-4 md:px-6">

            {{-- HEADER --}}
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-orange-600 font-bold tracking-widest uppercase text-xs mb-2 block">
                    Our Portfolio
                </span>
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4">
                    Galeri Lengkap
                </h1>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full mb-6"></div>
                <p class="text-gray-500 max-w-xl mx-auto text-lg font-light">
                    Dokumentasi lengkap momen spesial di Gedung Farida.
                </p>
            </div>

            {{-- GRID GALERI --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @forelse ($galleries as $gallery)
                    <div class="group relative overflow-hidden rounded-2xl shadow-md bg-white"
                         data-aos="fade-up">

                        <img src="{{ asset('storage/' . $gallery->image) }}"
                             alt="{{ $gallery->title }}"
                             class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition duration-300"></div>

                        {{-- Title --}}
                        <div class="absolute bottom-0 left-0 p-4 opacity-0 group-hover:opacity-100 transition duration-300">
                            <p class="text-white font-semibold text-sm">
                                {{ $gallery->title }}
                            </p>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-400 text-lg">
                            Belum ada galeri tersedia.
                        </p>
                    </div>
                @endforelse

            </div>

            {{-- BUTTON KEMBALI --}}
            <div class="text-center mt-16" data-aos="fade-up">
                <a href="{{ url('/') }}"
                   class="inline-block px-6 py-3 bg-orange-600 text-white font-semibold rounded-full shadow-md hover:bg-orange-700 transition duration-300">
                    ← Kembali ke Beranda
                </a>
            </div>

        </div>
    </section>

    {{-- AOS SCRIPT --}}
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800
        });
    </script>


  <footer id="kontak" class="bg-gradient-to-b from-orange-100 via-orange-50 to-white pt-20 pb-8 relative overflow-hidden border-t border-orange-100">
    
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[60%] bg-orange-200/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[10%] left-[5%] w-[40%] h-[40%] bg-amber-100/40 rounded-full blur-[80px]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-soft-light"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 md:px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
            
            <div>
                <h4 class="text-3xl font-serif font-bold mb-6 text-gray-900">
                    Gedung<span class="text-orange-500">Farida</span>.
                </h4>
                <p class="text-gray-600 leading-relaxed mb-8 pr-4 font-light">
                    Hadirkan momen tak terlupakan bersama kami. Venue eksklusif dengan pelayanan hangat di jantung kota Cianjur.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-white border border-orange-100 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white hover:-translate-y-1 transition-all shadow-sm">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white border border-orange-100 text-orange-500 flex items-center justify-center hover:bg-green-500 hover:text-white hover:-translate-y-1 transition-all shadow-sm">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white border border-orange-100 text-orange-500 flex items-center justify-center hover:bg-blue-600 hover:text-white hover:-translate-y-1 transition-all shadow-sm">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>
            </div>

            <div>
                <h5 class="text-lg font-bold mb-6 text-gray-900 border-b-2 border-orange-200 pb-2 inline-block">Hubungi Kami</h5>
                <ul class="space-y-5 text-gray-600">
                    <li class="flex items-start gap-4 group">
                        <div class="mt-1 w-9 h-9 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 shrink-0 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <span class="text-sm leading-relaxed group-hover:text-orange-700 transition-colors">
                            Jl. Raya Cipanas No. 123, <br>Kabupaten Cianjur, Jawa Barat
                        </span>
                    </li>
                    <li class="flex items-center gap-4 group">
                        <div class="w-9 h-9 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 shrink-0 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <span class="text-sm group-hover:text-orange-700 transition-colors">0812-3456-7890 (Admin)</span>
                    </li>
                    <li class="flex items-center gap-4 group">
                        <div class="w-9 h-9 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 shrink-0 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <span class="text-sm group-hover:text-orange-700 transition-colors">info@gedungfarida.com</span>
                    </li>
                </ul>
            </div>

            <div>
                <h5 class="text-lg font-bold mb-6 text-gray-900 border-b-2 border-orange-200 pb-2 inline-block">Konsultasi Gratis</h5>
                <p class="text-gray-500 mb-6 text-sm">Masih ragu? Diskusikan kebutuhan dan budget acara Anda dengan tim kami.</p>
                
                <a href="https://wa.me/6281234567890" target="_blank" 
                   class="inline-flex w-full items-center justify-center gap-2 px-6 py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-bold transition-all shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 hover:-translate-y-1">
                    <i class="fab fa-whatsapp text-xl"></i> Chat WhatsApp
                </a>
                
                <p class="mt-4 text-xs text-gray-400 text-center">
                    *Respon cepat dalam hitungan menit
                </p>
            </div>
        </div>

        <div class="border-t border-orange-200/60 pt-8 text-center">
            <p class="text-gray-500 text-sm font-light">
                &copy; {{ date('Y') }} Gedung Farida. Built with <span class="text-orange-500">♥</span> in Cianjur.
            </p>
        </div>
    </div>
</footer>

</body>
</html>
