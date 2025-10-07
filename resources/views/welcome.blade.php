<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] font-sans">

    <!-- Navbar -->
    <header class="bg-white shadow-md fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg md:text-xl font-bold text-orange-700">Gedung Farida</h1>
            <nav class="flex items-center gap-4 md:gap-6 text-gray-700 font-medium">
                <!-- Selalu tampil -->
                <a href="#galeri" class="relative group">
                    Galeri
                    <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-orange-600 transition-all group-hover:w-full"></span>
                </a>

                <!-- Menu tambahan hanya desktop -->
                <a href="#harga" class="relative group hidden md:inline-block ">Harga  
                    <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-orange-600 transition-all group-hover:w-full"></span></a>
                <a href="#fasilitas" class="relative group hidden md:inline-block">Fasilitas
                      <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-orange-600 transition-all group-hover:w-full"></span></a>
                <a href="#kontak" class="relative group hidden md:inline-block">Kontak 
                     <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-orange-600 transition-all group-hover:w-full"></span></a>

                <!-- Login -->
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="px-3 md:px-4 py-2 bg-orange-600 text-white rounded-lg shadow-md hover:bg-orange-700 transition">
                           Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-3 md:px-4 py-2 border border-orange-600 text-orange-600 rounded-lg hover:bg-orange-600 hover:text-white transition">
                           Log in
                        </a>
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-28 md:pt-32 pb-32 md:pb-40">
        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1600&q=80" 
             alt="Hotel Background" 
             class="absolute inset-0 w-full h-full object-cover brightness-75">
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10 text-center text-white max-w-3xl mx-auto px-4">
            <h2 class="text-3xl md:text-6xl font-extrabold mb-6 drop-shadow-lg">Gedung Farida</h2>
            <p class="text-base md:text-xl mb-8 opacity-90">
                Tempat terbaik untuk pernikahan, resepsi, dan acara spesial Anda ✨
            </p>
            <a href="#harga" 
               class="px-6 md:px-8 py-3 md:py-4 bg-orange-500 hover:bg-orange-700 rounded-full text-white font-semibold shadow-xl transition transform hover:scale-105">
               Lihat Harga
            </a>
        </div>
    </section>

  
<!-- Galeri -->
<section id="galeri" class="bg-gradient-to-b from-white to-orange-50 py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <h3 class="text-2xl md:text-3xl font-bold mb-10 md:mb-12 text-center text-gray-800">Galeri Gedung</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-6">
            <!-- Baris Atas (3 foto) -->
            <div class="md:col-span-2 overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80" 
                     alt="Interior" class="w-full h-48 md:h-64 object-cover">
            </div>
            <div class="md:col-span-2 overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                <img src="https://images.unsplash.com/photo-1508921912186-1d1a45ebb3c1?auto=format&fit=crop&w=800&q=80" 
                     alt="Outdoor Wedding Garden" class="w-full h-48 md:h-64 object-cover">
            </div>
            <div class="md:col-span-2 overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                <img src="https://images.unsplash.com/photo-1529636798458-92182e662485?auto=format&fit=crop&w=800&q=80" 
                     alt="Dekorasi Wedding" class="w-full h-48 md:h-64 object-cover">
            </div>

            <!-- Baris Bawah (2 foto tengah) -->
            <div class="md:col-span-2 md:col-start-2 overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                <img src="https://images.unsplash.com/photo-1529636798458-92182e662485?auto=format&fit=crop&w=800&q=80" 
                     alt="Ruang Resepsi" class="w-full h-48 md:h-64 object-cover">
            </div>
            <div class="md:col-span-2 overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition transform hover:scale-105">
               <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" 
                     alt="Pelaminan Elegan" class="w-full h-48 md:h-64 object-cover">
            </div>
        </div>
    </div>
</section>
<!-- Fasilitas -->
<section id="fasilitas" class="bg-gradient-to-b from-orange-50 to-orange-100 py-16 md:py-20">
  <div class="max-w-6xl mx-auto px-4 md:px-6">
    <h3 class="text-2xl md:text-3xl font-bold mb-10 md:mb-12 text-center text-gray-800">
      Fasilitas
    </h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-6">

      <!-- Baris Atas (3 foto) -->
      <div class="md:col-span-2 bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition transform hover:-translate-y-2">
        <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=800&q=80" 
             alt="Musholla" class="w-full h-48 md:h-64 object-cover">
        <div class="p-4 text-center">
          <p class="font-semibold text-gray-800 text-lg">🕌 Musholla</p>
          <p class="text-sm text-gray-600 mt-1">Tempat ibadah yang nyaman dan bersih.</p>
        </div>
      </div>

      <div class="md:col-span-2 bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition transform hover:-translate-y-2">
        <img src="https://images.unsplash.com/photo-1506521781263-d8422e82f27a?auto=format&fit=crop&w=800&q=80" 
             alt="Tempat Parkir" class="w-full h-48 md:h-64 object-cover">
        <div class="p-4 text-center">
          <p class="font-semibold text-gray-800 text-lg">🚗 Tempat Parkir Luas</p>
          <p class="text-sm text-gray-600 mt-1">Area parkir luas dan aman.</p>
        </div>
      </div>

      <div class="md:col-span-2 bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition transform hover:-translate-y-2">
        <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=800&q=80" 
             alt="Dapur" class="w-full h-48 md:h-64 object-cover">
        <div class="p-4 text-center">
          <p class="font-semibold text-gray-800 text-lg">🍳 Dapur</p>
          <p class="text-sm text-gray-600 mt-1">Dapur lengkap untuk catering & acara.</p>
        </div>
      </div>

      <!-- Baris Bawah (2 fasilitas tengah) -->
        <div class="md:col-span-2 md:col-start-2 bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition transform hover:-translate-y-2">
        <div class="p-4 text-center">
            <p class="font-semibold text-gray-800 text-lg">📶 Wi-Fi Gratis</p>
            <p class="text-sm text-gray-600 mt-1">Akses internet gratis untuk tamu.</p>
        </div>
        </div>

        <div class="md:col-span-2 bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition transform hover:-translate-y-2">
        <div class="p-4 text-center">
            <p class="font-semibold text-orange-700 text-xl">✨ Free Kebersihan</p>
            <p class="text-sm text-gray-600 mt-1">Tim kebersihan siap menjaga kenyamanan acara.</p>
        </div>
        </div>


      <!-- Baris Bawah Tambahan (opsional jika mau 3 item lagi) -->
      <div class="md:col-span-2 bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition transform hover:-translate-y-2">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" 
             alt="Kamar" class="w-full h-48 md:h-64 object-cover">
        <div class="p-4 text-center">
          <p class="font-semibold text-gray-800 text-lg">🛏️ 2 Kamar</p>
          <p class="text-sm text-gray-600 mt-1">Tersedia 2 kamar nyaman untuk istirahat.</p>
        </div>
      </div>

      <div class="md:col-span-2 bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition transform hover:-translate-y-2">
       <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" 
             alt="Kursi" class="w-full h-48 md:h-64 object-cover">
        <div class="p-4 text-center">
          <p class="font-semibold text-gray-800 text-lg">💺 150 Kursi</p>
          <p class="text-sm text-gray-600 mt-1">Disediakan 150 kursi untuk tamu.</p>
        </div>
      </div>

      <div class="md:col-span-2 bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition transform hover:-translate-y-2">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" 
             alt="Tenda" class="w-full h-48 md:h-64 object-cover">
        <div class="p-4 text-center">
          <p class="font-semibold text-gray-800 text-lg">⛺ Tenda</p>
          <p class="text-sm text-gray-600 mt-1">Fasilitas tenda untuk kegiatan outdoor.</p>
        </div>
      </div>

    </div>
  </div>
</section>





<!-- Harga -->
<section id="harga" class="bg-gradient-to-b from-orange-100 to-white py-16 md:py-20">
  <div class="max-w-6xl mx-auto px-4">
    <h3 class="text-2xl md:text-3xl font-bold mb-10 text-gray-800 text-center">Harga Sewa</h3>

    <!-- Card -->
    <div class="bg-white shadow-xl rounded-2xl border border-orange-200 
                hover:shadow-2xl transition transform duration-300 
                flex flex-col md:flex-row items-stretch 
                max-w-4xl mx-auto overflow-hidden">
      
      <!-- Kiri: Detail Harga -->
      <div class="flex-1 p-8 text-left">
        <h4 class="text-xl font-semibold mb-4 text-orange-700">Paket Gedung</h4>
        <p class="text-3xl font-extrabold text-gray-800 mb-2">Rp 5.300.000 / Hari</p>
        <p class="text-sm text-gray-600 mb-6">(Include Wedding)</p>

        <!-- Fasilitas -->
        <ul class="space-y-3 text-gray-700 mb-6">
          <li>✅ 2 Kamar</li>
          <li>✅ 150 Kursi</li>
          <li>✅ Tenda</li>
        </ul>

        <!-- Catering -->
        <p class="text-base md:text-lg">
          🍽️ Catering mulai dari 
          <span class="font-bold text-orange-700">Rp 50.000</span> / porsi
        </p>
      </div>

      <!-- Kanan: Tombol Reservasi -->
      <div class="p-8 flex-shrink-0 flex items-center justify-center w-full md:w-72 bg-orange-50 border-t md:border-t-0 md:border-l border-orange-100">
        <a href="#pemesanan" 
           class="inline-flex items-center justify-center gap-2 px-8 py-4 
                  bg-orange-600 hover:bg-orange-700 
                  rounded-full text-white text-lg font-semibold shadow-lg 
                  transition transform hover:scale-105">
                 Reservasi Sekarang
        </a>
      </div>
    </div>
  </div>
</section>



    <!-- Tata Cara Pemesanan -->
<!-- Tata Cara Pemesanan -->
<section id="pemesanan" class="bg-gradient-to-b from-white to-gray-50 py-16 md:py-20">
  <div class="max-w-5xl mx-auto px-4">
    <h3 class="text-2xl md:text-3xl font-bold mb-10 md:mb-12 text-center text-gray-800">
      Tata Cara Pemesanan Online
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Langkah 1 -->
      <div class="flex items-start gap-4 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-orange-600 text-white font-bold">1</div>
        <div>
          <h4 class="text-lg font-semibold text-gray-800 mb-1">Login atau Daftar Akun</h4>
          <p class="text-gray-600 text-sm md:text-base">Masuk ke sistem dengan akun yang sudah terdaftar atau buat akun baru untuk memulai reservasi.</p>
        </div>
      </div>

      <!-- Langkah 2 -->
      <div class="flex items-start gap-4 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-orange-600 text-white font-bold">2</div>
        <div>
          <h4 class="text-lg font-semibold text-gray-800 mb-1">Pilih Menu Reservasi</h4>
          <p class="text-gray-600 text-sm md:text-base">Akses menu reservasi untuk memulai proses pemesanan gedung sesuai kebutuhan acara Anda.</p>
        </div>
      </div>

      <!-- Langkah 3 -->
      <div class="flex items-start gap-4 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-orange-600 text-white font-bold">3</div>
        <div>
          <h4 class="text-lg font-semibold text-gray-800 mb-1">Isi Formulir Reservasi</h4>
          <p class="text-gray-600 text-sm md:text-base">Lengkapi data diri, tanggal acara, paket, serta jumlah tamu pada formulir online.</p>
        </div>
      </div>

      <!-- Langkah 4 -->
      <div class="flex items-start gap-4 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-orange-600 text-white font-bold">4</div>
        <div>
          <h4 class="text-lg font-semibold text-gray-800 mb-1">Tunggu Konfirmasi</h4>
          <p class="text-gray-600 text-sm md:text-base">Reservasi Anda akan dicek oleh admin. Tunggu status reservasi dikonfirmasi sebelum lanjut pembayaran.</p>
        </div>
      </div>

      <!-- Langkah 5 -->
      <div class="flex items-start gap-4 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-orange-600 text-white font-bold">5</div>
        <div>
          <h4 class="text-lg font-semibold text-gray-800 mb-1">Lakukan Pembayaran DP</h4>
          <p class="text-gray-600 text-sm md:text-base">Bayar uang muka (DP) sesuai nominal yang telah ditentukan untuk mengamankan jadwal acara.</p>
        </div>
      </div>

      <!-- Langkah 6 -->
      <div class="flex items-start gap-4 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-orange-600 text-white font-bold">6</div>
        <div>
          <h4 class="text-lg font-semibold text-gray-800 mb-1">Selesaikan Pelunasan</h4>
          <p class="text-gray-600 text-sm md:text-base">Lakukan pelunasan pembayaran sesuai kesepakatan sebelum hari-H acara dimulai.</p>
        </div>
      </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="text-center mt-12">
      <a href="{{ route('login') }}" 
         class="px-8 py-3 bg-orange-600 hover:bg-orange-700 rounded-full text-white font-semibold shadow-lg transition transform hover:scale-105">
        Reservasi Online Disini
      </a>
    </div>
  </div>
</section>


    <!-- Kontak -->
    <section id="kontak" class="bg-gray-100 py-16 md:py-20 text-center px-4">
        <h3 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8 text-gray-800">Hubungi Kami</h3>
        <p class="mb-2">📍 Jl. Contoh No. 123, Cianjur</p>
        <p class="mb-2">📞 0812-3456-7890</p>
        <p class="mb-6">📧 info@gedungfarida.com</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="https://wa.me/6281234567890" target="_blank" class="px-6 py-3 bg-green-500 hover:bg-green-600 rounded-lg text-white font-semibold shadow-lg flex items-center justify-center gap-2">
                💬 WhatsApp
            </a>
            <a href="mailto:info@gedungfarida.com" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 rounded-lg text-white font-semibold shadow-lg flex items-center justify-center gap-2">
                ✉️ Email
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-orange-600 text-white py-6 text-center text-sm">
        © 2025 Gedung Farida. All rights reserved.
    </footer>

</body>
</html>
