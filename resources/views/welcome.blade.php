<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
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

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5 { font-family: 'Playfair Display', serif; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(254, 215, 170, 0.3); /* orange-200 opacity */
        }
        
        /* Pattern Titik-titik Orange */
        .bg-dots-pattern-orange {
            background-image: radial-gradient(#f97316 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="bg-white text-gray-700 antialiased overflow-x-hidden">

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

    <section class="relative min-h-[800px] mt-14 flex items-center bg-white overflow-hidden py-20 lg:py-0">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[5%] w-[40%] h-[40%] bg-orange-200/30 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-[5%] right-[0%] w-[45%] h-[45%] bg-amber-100/50 rounded-full blur-[120px]"></div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <div class="lg:col-span-7 flex flex-col items-start text-left" data-aos="fade-right">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="h-[2px] w-12 bg-orange-500"></span>
                        <span class="text-orange-600 font-bold tracking-[0.2em] text-sm uppercase bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                            The Perfect Venue
                        </span>
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-bold text-gray-900 leading-[1.1] mb-6">
                        Gedung <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500">Farida</span>
                        <br>
                        <span class="font-serif font-thin italic text-gray-400 text-4xl lg:text-6xl block mt-3">
                            Where Stories Begin.
                        </span>
                    </h1>

                    <p class="text-gray-600 text-lg leading-relaxed max-w-xl mb-10 border-l-4 border-orange-200 pl-6">
                        Hadirkan kemewahan dalam suasana yang hangat. Venue premium dengan pencahayaan alami, desain interior modern, dan pelayanan sepenuh hati.
                    </p>

                    <div class="flex flex-wrap gap-4 mb-12">
                        <a href="#pemesanan" class="px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-all shadow-xl shadow-orange-600/20 hover:shadow-orange-600/40 hover:-translate-y-1 flex items-center gap-2">
                            Reservasi Tanggal
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                        {{-- <a href="#virtual-tour" class="px-8 py-4 bg-white border border-gray-200 hover:border-orange-500 text-gray-600 hover:text-orange-600 rounded-lg font-medium transition-all hover:bg-orange-50">
                            <i class="fa-solid fa-video mr-2"></i> Virtual Tour
                        </a> --}}
                    </div>
                </div>

                <div class="lg:col-span-5 relative mt-10 lg:mt-0" data-aos="fade-left">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-gray-200 aspect-[4/5] group border-4 border-white">
                        <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80" 
                            alt="Gedung Interior" 
                            class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105 saturate-120">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-80"></div>
                        
                        <div class="absolute bottom-6 right-6 left-6 z-20">
                            <div class="bg-white/95 backdrop-blur-md shadow-lg p-5 rounded-xl flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                                        <i class="fa-solid fa-medal"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-900 text-sm font-bold">Best Venue</p>
                                        <p class="text-orange-600 text-xs font-semibold">Cianjur Area</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-gray-400 text-xs">Rating</span>
                                    <div class="flex text-amber-500 text-sm">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -z-10 top-8 -right-8 w-full h-full border-2 border-orange-200 rounded-2xl hidden lg:block"></div>
                    <div class="absolute -z-10 -bottom-12 -left-12 w-48 h-48 bg-dots-pattern-orange opacity-40"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="galeri" class="py-20 md:py-28 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-orange-600 font-bold tracking-widest uppercase text-xs mb-2 block">Our Portfolio</span>
                <h3 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4">Galeri Momen</h3>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full mb-6"></div>
                <p class="text-gray-500 max-w-xl mx-auto text-lg font-light">
                    Setiap sudut Gedung Farida dirancang untuk menangkap keindahan visual acara spesial Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-4 md:h-[600px]">
                @php
                    $limitedGalleries = $galleries->take(5);
                @endphp

                @forelse ($limitedGalleries as $index => $gallery)
                    @if ($index === 0)
                        <div class="md:col-span-2 md:row-span-2 group relative overflow-hidden rounded-2xl cursor-pointer shadow-lg" data-aos="fade-right">
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-80"></div>
                            <div class="absolute bottom-0 left-0 p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="bg-orange-600 text-white text-xs px-3 py-1 rounded-full mb-2 inline-block">Featured</span>
                                <p class="text-white font-serif text-2xl italic">{{ $gallery->title }}</p>
                            </div>
                        </div>
                    @else
                        <div class="group relative overflow-hidden rounded-2xl shadow-md" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300"></div>
                        </div>
                    @endif
                @empty
                    <div class="col-span-full py-12 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <p class="text-gray-400">Belum ada galeri yang diunggah.</p>
                    </div>
                @endforelse
            </div>
            {{-- Tombol --}}
            @if($galleries->count() > 5)
                <div class="text-center mt-10" data-aos="fade-up">
                    <a href="{{ route('galleries.full') }}"
                    class="inline-block px-6 py-3 bg-orange-600 text-white font-semibold rounded-full shadow-md hover:bg-orange-700 transition duration-300">
                        Lihat Selengkapnya →
                    </a>
                </div>
            @endif

        </div>
    </section>

    <section id="fasilitas" class="py-20 bg-orange-50/50">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-orange-600 font-bold tracking-wider uppercase text-xs bg-orange-100 px-3 py-1 rounded-full">Amenities</span>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Fasilitas Lengkap</h3>
                <p class="text-gray-500 mt-2">Semua yang Anda butuhkan untuk kenyamanan tamu.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $facilities = [
                        ['icon' => 'fa-mosque', 'title' => 'Musholla', 'desc' => 'Nyaman & Bersih'],
                        ['icon' => 'fa-car', 'title' => 'Parkir Luas', 'desc' => 'Kapasitas Besar'],
                        ['icon' => 'fa-utensils', 'title' => 'Dapur Besar', 'desc' => 'Area Catering Luas'],
                        ['icon' => 'fa-snowflake', 'title' => 'Full AC', 'desc' => 'Pendingin Ruangan'],
                        ['icon' => 'fa-bed', 'title' => '2 Kamar', 'desc' => 'Ruang Rias & Istirahat'],
                        ['icon' => 'fa-chair', 'title' => '150 Kursi', 'desc' => 'Futura + Cover'],
                        ['icon' => 'fa-wifi', 'title' => 'Free Wifi', 'desc' => 'Koneksi High Speed'],
                        ['icon' => 'fa-broom', 'title' => 'Kebersihan', 'desc' => 'Petugas Standby'],
                    ];
                @endphp

                @foreach($facilities as $index => $item)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-orange-200/40 hover:border-orange-200 transition-all duration-300 transform hover:-translate-y-2 group" 
                     data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center text-2xl mb-4 text-orange-500 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-1 text-gray-900">{{ $item['title'] }}</h4>
                    <p class="text-sm text-gray-500 group-hover:text-gray-600">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="harga" class="py-20 md:py-28 relative overflow-hidden bg-white">
        <div class="absolute top-0 right-0 w-2/3 h-full bg-gradient-to-l from-orange-50 to-white -skew-x-12 translate-x-32 -z-10"></div>

        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-12 lg:gap-20">
                
                <div class="md:w-1/2" data-aos="fade-right">
                    <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        Penawaran Terbaik <br> 
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500 font-serif italic">Hari Spesial Anda</span>
                    </h3>
                    <p class="text-gray-600 mb-8 text-lg leading-relaxed">
                        Kami menawarkan paket gedung dengan harga kompetitif tanpa biaya tersembunyi. Transparansi adalah kunci kenyamanan Anda.
                    </p>
                    
                    <div class="space-y-5">
                         <div class="flex items-center gap-4 group">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-check text-sm"></i>
                            </div>
                            <span class="text-gray-700 font-medium group-hover:text-orange-600 transition-colors">Sound System Standar Included</span>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-bolt text-sm"></i>
                            </div>
                            <span class="text-gray-700 font-medium group-hover:text-orange-600 transition-colors">Listrik Hingga 5000 Watt</span>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-file-shield text-sm"></i>
                            </div>
                            <span class="text-gray-700 font-medium group-hover:text-orange-600 transition-colors">Izin Keramaian Lingkungan</span>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2 w-full" data-aos="fade-left">
                    @php $mainHall = $halls->first(); @endphp

                    @if ($mainHall)
                    <div class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200 p-8 md:p-10 border border-orange-100 relative group overflow-hidden">
                        {{-- <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-500 to-amber-500"></div> --}}
                        
                        <div class="absolute top-6 right-6 bg-orange-50 text-orange-700 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-widest border border-orange-100">
                            Most Popular
                        </div>

                        <p class="text-gray-400 font-medium mb-1 uppercase tracking-wide text-sm">Paket Sewa Harian</p>
                        <h4 class="text-2xl font-bold text-gray-900 mb-6">{{ $mainHall->name }}</h4>

                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-lg text-gray-500 font-medium">Rp</span>
                            <span class="text-5xl font-serif font-bold text-gray-900 tracking-tight">
                                {{ number_format($mainHall->price / 1000000, 1, ',', '.') }}<span class="text-3xl text-gray-900">Juta</span>
                            </span>
                        </div>

                        <div class="space-y-4 mb-8 bg-gray-50 p-6 rounded-xl">
                            <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                                <span class="text-gray-500"><i class="fa-solid fa-users mr-2"></i>Kapasitas</span>
                                <span class="font-bold text-gray-900">s/d {{ $mainHall->capacity }} Tamu</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500"><i class="fa-regular fa-clock mr-2"></i>Durasi</span>
                                <span class="font-bold text-gray-900">08.00 - 17.00 WIB</span>
                            </div>
                        </div>

                        <a href="#pemesanan"
                        class="block w-full py-4 bg-gray-900 text-white text-center font-bold rounded-xl hover:bg-orange-600 transition-all shadow-lg hover:shadow-orange-600/30 transform hover:-translate-y-1">
                            Booking Sekarang
                        </a>
                        
                        <p class="text-center text-xs text-gray-400 mt-4">*Syarat & ketentuan berlaku</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section id="pemesanan" class="bg-gradient-to-b from-white to-orange-100 py-20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Cara Mudah Reservasi</h3>
                <p class="text-gray-500">Langkah praktis mengamankan tanggal impian Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $steps = [
                        ['num' => '01', 'title' => 'Daftar Akun', 'desc' => 'Buat akun baru atau login untuk memulai.'],
                        ['num' => '02', 'title' => 'Pilih Tanggal', 'desc' => 'Cek ketersediaan tanggal di kalender.'],
                        ['num' => '03', 'title' => 'Isi Data', 'desc' => 'Lengkapi form pemesanan acara Anda.'],
                        ['num' => '04', 'title' => 'Verifikasi', 'desc' => 'Admin kami akan mengecek pesanan Anda.'],
                        ['num' => '05', 'title' => 'Bayar DP', 'desc' => 'Transfer DP untuk mengunci jadwal.'],
                        ['num' => '06', 'title' => 'Pelunasan', 'desc' => 'Selesaikan pembayaran sebelum Hari-H.'],
                    ];
                @endphp

                @foreach ($steps as $step)
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-orange-200 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="text-4xl font-black text-gray-100 group-hover:text-orange-100 transition-colors font-sans">
                            {{ $step['num'] }}
                        </div>
                        <div class="h-px bg-gray-200 flex-grow group-hover:bg-orange-200"></div>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors">{{ $step['title'] }}</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white rounded-full font-bold shadow-xl shadow-orange-600/20 transition-all transform hover:scale-105">
                    Mulai Reservasi Online <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

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

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-out-cubic',
        });
    </script>
</body>
</html>