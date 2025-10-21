<x-app-layout>
    <x-slot name="header">
         <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
            {{ __('Buat Reservasi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 transition-transform transform hover:scale-[1.01]">

                <!-- Title -->
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-l-4 border-orange-500 pl-3">
                    Formulir Reservasi Gedung
                </h3>

                <form action="{{ route('reservations.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Customer --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Penyewa</label>

                        @if(Auth::user()->hasRole('admin'))
                            <input 
                                type="text" 
                                name="renter_name" 
                                class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                                placeholder="Masukkan nama penyewa"
                                value="{{ old('renter_name') }}"
                            >
                        @else
                            <input 
                                type="text" 
                                value="{{ Auth::user()->name }}" 
                                class="w-full border border-gray-200 bg-gray-100 rounded-lg p-3 shadow-sm" 
                                readonly
                            >
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        @endif
                    </div>

                    {{-- Pilih Hall --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Pilih Gedung</label>
                        <select name="hall_id" id="hall"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            onchange="calculateTotal()">
                            @foreach($halls as $hall)
                                <option value="{{ $hall->id }}" data-price="{{ $hall->price }}">
                                    {{ $hall->name }} - Rp {{ number_format($hall->price, 0, ',', '.') }} / hari
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                            <input type="text" id="event_start" name="event_start" placeholder="Pilih tanggal"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            required onchange="calculateTotal()">



                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                         <input type="text" id="event_end" name="event_end" placeholder="Pilih tanggal"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            required onchange="calculateTotal()">
                        </div>
                    </div>
                    

                    {{-- Layanan Tambahan --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Layanan Tambahan</label>
                        <div id="services-wrapper" class="space-y-2"></div>
                        <button type="button" onclick="addService()" 
                            class="mt-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition">
                            Tambah Catering
                        </button>
                    </div>

                    {{-- Total Harga --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Total Harga</label>
                        <input type="text" id="total_price_display"
                            class="w-full border border-gray-200 bg-gray-100 rounded-lg p-3 shadow-sm text-gray-800 font-semibold"
                            readonly>
                        <input type="hidden" id="total_price" name="total_price">
                    </div>

                    {{-- Rincian Harga --}}
                    <div id="price-details"
                         class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700 shadow-inner">
                    </div>

                    {{-- Status (Admin Saja) --}}
                    @if(Auth::user()->hasRole('admin'))
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Status</label>
                            <select name="status"
                                class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition">
                                <option value="pending">Menunggu Dikonfirmasi</option>
                                <option value="confirmed">Menunggu Pembayaran</option>
                                <option value="completed">Dibayar</option>
                                <option value="canceled">Dibatalkan</option>
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="status" value="pending">
                    @endif

                    {{-- Tombol --}}
                    {{-- <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-6"> --}}
                      <div class="flex justify-center sm:justify-end mb-4 gap-4">
                        <a href="{{ route('reservations.index') }}"
                        class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition text-center">
                            Batal
                        </a>
                        
                        <button type="submit"
                        class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                        Simpan
                    </button>
{{-- </div> --}}
                    </div>
                </form>

            </div>
        </div>
    </div>

 <script>
    // === INISIALISASI DATEPICKER ===
    const endPicker = flatpickr("#event_end", {
        dateFormat: "d-m-Y",
        locale: "id",
        onChange: function() {
            calculateTotal(); // hitung ulang total saat tanggal akhir berubah
        }
    });

    const startPicker = flatpickr("#event_start", {
        dateFormat: "d-m-Y",
        locale: "id",
        onChange: function(selectedDates) {
            // Saat event_start berubah, atur minDate event_end dan hitung ulang total
            if (selectedDates.length > 0) {
                endPicker.set('minDate', selectedDates[0]);
            } else {
                endPicker.set('minDate', null);
            }
            calculateTotal();
        }
    });

    // === FORMAT ANGKA RIBUAN ===
    function formatRibuan(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // === UPDATE NILAI TOTAL ===
    function setTotalPrice(value) {
        document.getElementById('total_price').value = value;
        document.getElementById('total_price_display').value = "Rp " + formatRibuan(value);
    }

    // === HITUNG TOTAL HARGA ===
    function calculateTotal() {
        let total = 0;
        let details = [];

        // Ambil hall
        let hallSelect = document.getElementById('hall');
        let hallOption = hallSelect.options[hallSelect.selectedIndex];
        let hallPrice = parseFloat(hallOption.dataset.price || 0);

        // Ambil tanggal
        const startVal = document.getElementById('event_start').value;
        const endVal = document.getElementById('event_end').value;

        let days = 1;
        if (startVal && endVal) {
            const [sd, sm, sy] = startVal.split('-').map(Number);
            const [ed, em, ey] = endVal.split('-').map(Number);
            const start = new Date(sy, sm - 1, sd);
            const end = new Date(ey, em - 1, ed);

            if (end > start) {
                days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            }
        }

        let hallTotal = hallPrice * days;
        total += hallTotal;
        details.push(`Gedung: ${hallOption.text} x ${days} hari = Rp ${formatRibuan(hallTotal)}`);

        // Layanan tambahan
        document.querySelectorAll('#services-wrapper .service-item').forEach(item => {
            let serviceSelect = item.querySelector('select');
            let quantityInput = item.querySelector('input[type="number"]');
            let serviceOption = serviceSelect.options[serviceSelect.selectedIndex];
            let servicePrice = parseFloat(serviceOption.dataset.price || 0);
            let qty = parseInt(quantityInput.value || 1);
            let subtotal = servicePrice * qty;

            total += subtotal;
            details.push(`${serviceOption.text} x ${qty} = Rp ${formatRibuan(subtotal)}`);
        });

        // Update tampilan total
        setTotalPrice(total);
        document.getElementById('price-details').innerHTML =
            details.join('<br>') +
            `<br><strong class="text-orange-600">Total: Rp ${formatRibuan(total)}</strong>`;
    }

    // === TAMBAH DAN HAPUS LAYANAN ===
    let serviceIndex = 0;

    function addService() {
        const wrapper = document.getElementById('services-wrapper');
        const newService = document.createElement('div');
        newService.classList.add('flex', 'items-center', 'space-x-2', 'service-item');

        newService.innerHTML = `
            <select name="services[${serviceIndex}][service_id]" 
                    class="border border-gray-300 rounded-lg p-2 w-1/2 focus:border-orange-500 focus:ring-orange-500 transition"
                    onchange="calculateTotal()">
                @foreach($services as $service)
                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                        {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
            <input type="number" name="services[${serviceIndex}][quantity]" value="1"
                class="border border-gray-300 rounded-lg p-2 w-1/4 focus:border-orange-500 focus:ring-orange-500 transition"
                min="1" oninput="calculateTotal()">
            <button type="button" onclick="removeService(this)" 
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow transition">Hapus</button>
        `;

        wrapper.appendChild(newService);
        serviceIndex++;
        calculateTotal();
    }

    function removeService(button) {
        button.parentElement.remove();
        calculateTotal();
    }
</script>

</x-app-layout>
