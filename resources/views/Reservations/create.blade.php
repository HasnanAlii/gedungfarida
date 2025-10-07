<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Reservation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf

               {{-- Customer otomatis dari user login --}}
                <div class="mb-4">
                    <label class="block font-medium text-gray-700 mb-1">Customer</label>

                    @if(Auth::user()->hasRole('admin'))
                        {{-- Admin/Owner bisa input nama customer --}}
                        <input 
                            type="text" 
                            name="renter_name" 
                            class="w-full border p-2 rounded focus:ring focus:ring-blue-200" 
                            placeholder="Masukkan nama customer"
                            value="{{ old('renter_name') }}"
                        >
                    @else
                        {{-- User biasa readonly --}}
                        <input 
                            type="text" 
                            value="{{ Auth::user()->name }}" 
                            class="w-full border p-2 rounded bg-gray-100" 
                            readonly
                        >
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    @endif
                </div>



                    {{-- Pilih Hall --}}
                    <div class="mb-4">
                        <label class="block">Hall</label>
                        <select name="hall_id" id="hall" class="w-full border p-2 rounded" onchange="calculateTotal()">
                            @foreach($halls as $hall)
                                <option value="{{ $hall->id }}" data-price="{{ $hall->price }}">
                                    {{ $hall->name }} - Rp {{ number_format($hall->price, 0, ',', '.') }} / hari
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Acara --}}
                    <div class="mb-4">
                        <label class="block">Tanggal Mulai Sewa</label>
                        <input type="date" id="event_start" name="event_start" 
                               class="w-full border p-2 rounded" required onchange="calculateTotal()">
                    </div>
                    <div class="mb-4">
                        <label class="block">Tanggal Selesai Sewa</label>
                        <input type="date" id="event_end" name="event_end" 
                               class="w-full border p-2 rounded" required onchange="calculateTotal()">
                    </div>

               {{-- Service Section --}}
                <div class="mb-4">
                    <label class="block font-semibold">Services</label>
                    <div id="services-wrapper"></div>
                    <button type="button" onclick="addService()" 
                        class="mt-2 bg-green-500 text-white px-3 py-1 rounded">
                        + Tambah Service
                    </button>
                </div>


                   {{-- Total Harga --}}
                    <div class="mb-4">
                        <label class="block">Total Price</label>
                        
                        {{-- Tampilan harga dengan format ribuan --}}
                        <input type="text" id="total_price_display" 
                            class="w-full border p-2 rounded bg-gray-100" readonly>

                        {{-- Nilai asli (tanpa format) yang dikirim ke server --}}
                        <input type="hidden" id="total_price" name="total_price">
                    </div>

                    {{-- Preview Detail Harga --}}
                    <div id="price-details" class="mb-4 bg-gray-50 p-3 rounded border text-sm text-gray-700"></div>

                    
                    @if(Auth::user()->hasRole('admin'))
                         <div class="mb-4">
                            <label class="block mb-1">Status</label>
                            <select name="status" class="w-full border p-2 rounded">
                                <option value="pending">Menunggu Dikonfirmasi</option>
                                <option value="confirmed">Menunggu Pembayaran</option>
                                <option value="completed">Dibayar</option>
                                <option value="canceled">Dibatalkan</option>
                            </select>
                         </div>
                    @else
                         <div class="mb-4">
                        
                        <input type="hidden" name="status" value="pending">
                       
                    </div>
                    @endif
             
                 
                    


                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Lanjut Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Script hitung harga otomatis --}}
    <script>
          function formatRibuan(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function setTotalPrice(value) {
        document.getElementById('total_price').value = value; // angka asli untuk DB
        document.getElementById('total_price_display').value = "Rp " + formatRibuan(value); // tampilan
    }

    function calculateTotal() {
        let total = 0;
        let details = [];

        // Ambil hall & harga
        let hallSelect = document.getElementById('hall');
        let hallOption = hallSelect.options[hallSelect.selectedIndex];
        let hallPrice = parseFloat(hallOption.dataset.price || 0);

        // Hitung jumlah hari sewa
        let start = new Date(document.getElementById('event_start').value);
        let end = new Date(document.getElementById('event_end').value);

        let days = 1;
        if (start && end && end > start) {
            let diffTime = end - start;
            days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // konversi ms → hari
        }

        let hallTotal = hallPrice * days;
        total += hallTotal;
        details.push(`Hall: ${hallOption.text} x ${days} hari = Rp ${formatRibuan(hallTotal)}`);

        // Hitung harga services
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

        // Update total price (hidden & display)
        setTotalPrice(total);

        // Update rincian harga
        document.getElementById('price-details').innerHTML =
            details.join('<br>') + `<br><strong>Total: Rp ${formatRibuan(total)}</strong>`;
    }
        // Tambah service baru
            let serviceIndex = 0;

    function addService() {
        const wrapper = document.getElementById('services-wrapper');
        const newService = document.createElement('div');
        newService.classList.add('flex', 'space-x-2', 'mb-2', 'service-item');

        newService.innerHTML = `
            <select name="services[${serviceIndex}][service_id]" class="border p-2 rounded w-1/2" onchange="calculateTotal()">
                @foreach($services as $service)
                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                        {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>

            <input type="number" name="services[${serviceIndex}][quantity]" value="1" 
                   class="border p-2 rounded w-1/4" min="1" oninput="calculateTotal()">

            <button type="button" onclick="removeService(this)" 
                class="bg-red-500 text-white px-2 rounded">❌</button>
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
