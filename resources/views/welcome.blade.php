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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5 { font-family: 'Playfair Display', serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-[#FCFCFA] text-gray-800 antialiased overflow-x-hidden">

    <header class="glass-nav fixed w-full top-0 z-50 border-b border-orange-100/50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-orange-600 rounded-tr-xl rounded-bl-xl"></div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 tracking-tight">Gedung<span class="text-orange-600">Farida</span></h1>
            </div>
            
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#galeri" class="hover:text-orange-600 transition-colors">Galeri</a>
                <a href="#fasilitas" class="hover:text-orange-600 transition-colors">Fasilitas</a>
                <a href="#harga" class="hover:text-orange-600 transition-colors">Harga</a>
                <a href="#pemesanan" class="hover:text-orange-600 transition-colors">Cara Pesan</a>
                <a href="#kontak" class="hover:text-orange-600 transition-colors">Kontak</a>
            </nav>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-full hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20">
                           Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-5 py-2.5 bg-orange-600 text-white text-sm font-medium rounded-full hover:bg-orange-700 hover:shadow-lg hover:shadow-orange-600/30 transition-all transform hover:-translate-y-0.5">
                           Masuk
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <section class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=1920&q=80" 
                 alt="Luxury Hall" 
                 class="w-full h-full object-cover animate-[ping_30s_linear_infinite] scale-110 transition-transform duration-[20s] hover:scale-100">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/30"></div>
        </div>

        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-4 mt-16" data-aos="fade-up" data-aos-duration="1200">
            <span class="inline-block py-1 px-3 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-orange-200 text-sm font-medium mb-6 uppercase tracking-wider">
                The Perfect Venue
            </span>
            <h2 class="text-4xl md:text-7xl font-bold mb-6 leading-tight drop-shadow-lg">
                Wujudkan Acara <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-200 to-orange-400 font-serif italic">Impian Anda</span> Disini
            </h2>
            <p class="text-lg md:text-xl mb-10 text-gray-200 font-light max-w-2xl mx-auto leading-relaxed">
                Gedung Farida menghadirkan nuansa elegan dan fasilitas lengkap untuk pernikahan, resepsi, dan momen spesial yang tak terlupakan.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#harga" 
                   class="px-8 py-4 bg-orange-600 hover:bg-orange-700 rounded-full text-white font-semibold shadow-xl shadow-orange-600/30 transition-all transform hover:-translate-y-1">
                   Lihat Paket & Harga
                </a>
                <a href="#galeri" 
                   class="px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 rounded-full text-white font-semibold transition-all">
                   Jelajahi Galeri
                </a>
            </div>
        </div>
        
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce text-white/70">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </div>
    </section>

    <section id="galeri" class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h3 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4">Galeri Momen</h3>
                <p class="text-gray-500 max-w-xl mx-auto">Setiap sudut Gedung Farida dirancang untuk keindahan visual acara Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-4 h-auto md:h-[600px]">
          <div class="md:col-span-2 md:row-span-2 group relative overflow-hidden rounded-2xl cursor-pointer" data-aos="fade-right">
    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80" 
         alt="Wedding Decoration" 
         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">

    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-all"></div>
    <div class="absolute bottom-0 left-0 p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
        <p class="text-white font-serif text-2xl italic">Wedding Decoration</p>
    </div>
</div>
                
                <div class="md:col-span-1 group relative overflow-hidden rounded-2xl" data-aos="fade-down" data-aos-delay="100">
                    <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                </div>
                <div class="md:col-span-1 group relative overflow-hidden rounded-2xl" data-aos="fade-down" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                </div>
                
                <div class="md:col-span-2 group relative overflow-hidden rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                    <img src="https://images.unsplash.com/photo-1505944357431-27579db47558?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur px-4 py-2 rounded-lg">
                        <span class="text-sm font-bold text-gray-800">Ruang Resepsi Luas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fasilitas" class="py-20 bg-orange-50/50">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-orange-600 font-bold tracking-wider uppercase text-sm">Amenities</span>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Fasilitas Lengkap</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-2xl mb-4">🕌</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">Musholla</h4>
                    <p class="text-sm text-gray-500">Nyaman & Bersih untuk beribadah.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-2xl mb-4">🚗</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">Parkir Luas</h4>
                    <p class="text-sm text-gray-500">Aman menampung banyak kendaraan.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-2xl mb-4">🍳</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">Dapur Besar</h4>
                    <p class="text-sm text-gray-500">Siap untuk kebutuhan catering.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-2xl mb-4">❄️</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">Full AC</h4>
                    <p class="text-sm text-gray-500">Suhu ruangan tetap sejuk.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-2xl mb-4">🛏️</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">2 Kamar</h4>
                    <p class="text-sm text-gray-500">Ruang istirahat / makeup.</p>
                </div>

                 <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-2xl mb-4">💺</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">150 Kursi</h4>
                    <p class="text-sm text-gray-500">Futura cover kursi tersedia.</p>
                </div>
                 <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-2xl mb-4">📶</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">Free Wifi</h4>
                    <p class="text-sm text-gray-500">Koneksi internet cepat.</p>
                </div>
                 <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="700">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-2xl mb-4">🧹</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">Kebersihan</h4>
                    <p class="text-sm text-gray-500">Petugas standby saat acara.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="harga" class="py-20 md:py-28 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-orange-50 -skew-x-12 translate-x-32 -z-10"></div>

        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-10">
                
                <div class="md:w-1/2" data-aos="fade-right">
                    <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        Penawaran Terbaik <br> Untuk <span class="text-orange-600 font-serif italic">Hari Spesial</span>
                    </h3>
                    <p class="text-gray-600 mb-8 text-lg">
                        Dapatkan paket lengkap dengan harga kompetitif. Tanpa biaya tersembunyi, semua transparan untuk kenyamanan Anda.
                    </p>
                    
                    <div class="space-y-4">
                         <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">✓</div>
                            <span class="text-gray-700 font-medium">Include Sound System Standar</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">✓</div>
                            <span class="text-gray-700 font-medium">Listrik Hingga 5000 Watt</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">✓</div>
                            <span class="text-gray-700 font-medium">Izin Keramaian Lingkungan</span>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2 w-full" data-aos="fade-left">
                    <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border-2 border-orange-100 relative">
                        <div class="absolute top-0 right-0 bg-orange-600 text-white text-xs font-bold px-4 py-2 rounded-bl-xl rounded-tr-xl uppercase tracking-widest">
                            Best Choice
                        </div>
                        
                        <p class="text-gray-500 font-medium mb-2 uppercase tracking-wide">Paket Gedung Full Day</p>
                        <div class="flex items-baseline gap-1 mb-6">
                            <span class="text-sm text-gray-500 align-top">Rp</span>
                            <span class="text-5xl font-bold text-gray-900">5.300.000</span>
                            <span class="text-gray-400">/ hari</span>
                        </div>

                        <div class="h-px bg-gray-100 w-full mb-6"></div>

                        <div class="space-y-3 mb-8">
                            <p class="text-gray-600 flex justify-between">
                                <span>Kapasitas</span>
                                <span class="font-semibold text-gray-900">s/d 150 Tamu</span>
                            </p>
                            <p class="text-gray-600 flex justify-between">
                                <span>Durasi</span>
                                <span class="font-semibold text-gray-900">08.00 - 17.00 WIB</span>
                            </p>
                        </div>

                        <div class="bg-orange-50 p-4 rounded-xl mb-8">
                            <p class="text-orange-800 text-sm text-center">
                                🍽️ Tambahan Catering mulai <span class="font-bold">Rp 50rb/porsi</span>
                            </p>
                        </div>

                        <a href="#pemesanan" class="block w-full py-4 bg-gray-900 text-white text-center font-bold rounded-xl hover:bg-orange-600 transition-colors shadow-lg">
                            Reservasi Tanggal Sekarang
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="pemesanan" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold text-gray-900">Proses Reservasi Mudah</h3>
                <p class="text-gray-500 mt-2">Hanya 4 langkah mudah untuk mengamankan tanggal Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="relative p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition text-center group" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-14 h-14 mx-auto bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-xl mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">1</div>
                    <h4 class="font-bold text-lg mb-2">Buat Akun</h4>
                    <p class="text-sm text-gray-500">Daftar atau login ke sistem untuk memulai pemesanan.</p>
                </div>
                <div class="relative p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition text-center group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 mx-auto bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-xl mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">2</div>
                    <h4 class="font-bold text-lg mb-2">Pilih Tanggal</h4>
                    <p class="text-sm text-gray-500">Cek ketersediaan tanggal dan isi formulir acara.</p>
                </div>
                <div class="relative p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition text-center group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 mx-auto bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-xl mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">3</div>
                    <h4 class="font-bold text-lg mb-2">Bayar DP</h4>
                    <p class="text-sm text-gray-500">Lakukan pembayaran uang muka untuk lock jadwal.</p>
                </div>
                <div class="relative p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition text-center group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 mx-auto bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold text-xl mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors">4</div>
                    <h4 class="font-bold text-lg mb-2">Selesai</h4>
                    <p class="text-sm text-gray-500">Lakukan pelunasan H-7 acara. Siap digunakan!</p>
                </div>
            </div>

            <div class="text-center mt-12">
                 <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-orange-600 font-bold hover:underline">
                    Mulai Reservasi Online <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <footer id="kontak" class="bg-gray-900 text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                <div>
                    <h4 class="text-2xl font-serif font-bold mb-6">Gedung<span class="text-orange-500">Farida</span>.</h4>
                    <p class="text-gray-400 leading-relaxed mb-6">
                        Menyediakan tempat terbaik untuk momen berharga Anda. Kenyamanan dan kepuasan Anda adalah prioritas utama kami.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-orange-600 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-orange-600 transition"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>

                <div>
                    <h5 class="text-lg font-bold mb-6 text-white">Hubungi Kami</h5>
                    <ul class="space-y-4 text-gray-400">
                        <li class="flex items-start gap-3">
                            <span class="text-orange-500 mt-1">📍</span>
                            <span>Jl. Raya Cipanas No. 123, Kabupaten Cianjur, Jawa Barat</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-orange-500">📞</span>
                            <span>0812-3456-7890 (Admin)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-orange-500">📧</span>
                            <span>marketing@gedungfarida.com</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-lg font-bold mb-6 text-white">Ada Pertanyaan?</h5>
                    <p class="text-gray-400 mb-6">Jangan ragu untuk berkonsultasi mengenai kebutuhan acara Anda.</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center justify-center w-full px-6 py-3 bg-green-600 hover:bg-green-700 rounded-lg text-white font-semibold transition">
                        Chat WhatsApp
                    </a>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Gedung Farida. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, // animasi hanya sekali saat scroll
            offset: 100,
            duration: 800,
            easing: 'ease-out-cubic',
        });
    </script>
</body>
</html>