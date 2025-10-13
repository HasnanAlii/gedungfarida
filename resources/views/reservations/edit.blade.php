<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center sm:text-left">
            {{ __('Edit Reservasi') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 transition-transform transform hover:scale-[1.01]">

                <!-- Title -->
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-l-4 border-orange-500 pl-3">
                    Formulir Edit Reservasi
                </h3>

                <!-- Form -->
                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Customer otomatis --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Customer</label>
                        <input type="text" value="{{ $reservation->renter_name }}"
                            class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100 shadow-sm" readonly>
                        <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">
                    </div>

                    {{-- Pilih Hall --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Pilih Hall</label>
                        <select name="hall_id" id="hall"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            onchange="calculateTotal()">
                            @foreach($halls as $hall)
                                <option value="{{ $hall->id }}" data-price="{{ $hall->price }}"
                                    @if($reservation->hall_id == $hall->id) selected @endif>
                                    {{ $hall->name }} - Rp {{ number_format($hall->price,0,',','.') }} / hari
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Mulai & Selesai --}}
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Mulai Sewa</label>
                            <input type="date" id="event_start" name="event_start"
                                class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                                required onchange="calculateTotal()"
                                value="{{ \Carbon\Carbon::parse($reservation->event_start)->format('Y-m-d') }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Selesai Sewa</label>
                            <input type="date" id="event_end" name="event_end"
                                class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                                required onchange="calculateTotal()"
                                value="{{ \Carbon\Carbon::parse($reservation->event_end)->format('Y-m-d') }}">
                        </div>
                    </div>

                    {{-- Services --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3">Layanan Tambahan</label>
                        <div id="services-wrapper" class="space-y-3">
                            @foreach($reservation->services as $index => $service)
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 service-item bg-orange-50 p-3 rounded-lg border border-orange-200">
                                    <select name="services[{{ $index }}][service_id]"
                                        class="border border-gray-300 rounded-lg p-2 w-full sm:w-1/2 focus:border-orange-500 focus:ring-orange-500 transition"
                                        onchange="calculateTotal()">
                                        @foreach($services as $s)
                                            <option value="{{ $s->id }}" data-price="{{ $s->price }}"
                                                @if($s->id == $service->id) selected @endif>
                                                {{ $s->name }} - Rp {{ number_format($s->price,0,',','.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="services[{{ $index }}][quantity]"
                                        value="{{ $service->pivot->quantity }}"
                                        class="border border-gray-300 rounded-lg p-2 w-full sm:w-1/4 focus:border-orange-500 focus:ring-orange-500 transition"
                                        min="1" oninput="calculateTotal()">
                                    <button type="button" onclick="removeService(this)"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition">❌</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addService()"
                            class="mt-3 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold shadow-sm transition">
                            + Tambah Service
                        </button>
                    </div>

                    {{-- Total Price --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Total Harga</label>
                        <input type="text" id="total_price_display"
                            class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100 shadow-sm" readonly>
                        <input type="hidden" id="total_price" name="total_price" value="{{ $reservation->total_price }}">
                    </div>

                    {{-- Detail Harga --}}
                    <div id="price-details"
                        class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-sm text-gray-700"></div>

                    {{-- Status --}}
                    @if(Auth::user()->hasRole('admin'))
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Status Reservasi</label>
                            <select name="status"
                                class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition">
                                <option value="confirmed" @selected($reservation->status == 'confirmed')>Menunggu Pembayaran</option>
                                <option value="completed" @selected($reservation->status == 'completed')>Dibayar</option>
                                <option value="pending" @selected($reservation->status == 'pending')>Menunggu Dikonfirmasi</option>
                                <option value="canceled" @selected($reservation->status == 'canceled')>Dibatalkan</option>
                            </select>
                        </div>
                    @endif

                    {{-- Tombol --}}
                    <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-4">
                        <a href="{{ route('reservations.index') }}"
                            class="w-full sm:w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Script perhitungan otomatis --}}
    <script>
        // Inisialisasi datepicker dengan format dd-mm-yyyy
        flatpickr("#event_start", {
            dateFormat: "d-m-Y",
            locale: "id"
        });

        flatpickr("#event_end", {
            dateFormat: "d-m-Y",
            locale: "id"
        });
    </script>

    {{-- Script tetap --}}
    <script>
        let serviceIndex = {{ $reservation->services->count() }};
        
        function formatRibuan(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function setTotalPrice(value) {
            document.getElementById('total_price').value = value;
            document.getElementById('total_price_display').value = "Rp " + formatRibuan(value);
        }

        function calculateTotal() {
            let total = 0;
            let details = [];

            // Hall price
            let hallSelect = document.getElementById('hall');
            let hallOption = hallSelect.options[hallSelect.selectedIndex];
            let hallPrice = parseFloat(hallOption.dataset.price || 0);

            // Days
            let start = new Date(document.getElementById('event_start').value);
            let end = new Date(document.getElementById('event_end').value);
            let days = 1;
            if (start && end && end >= start) {
                let diffTime = end - start;
                days = Math.ceil(diffTime / (1000*60*60*24));
            }

            let hallTotal = hallPrice * days;
            total += hallTotal;
            details.push(`Hall: ${hallOption.text} x ${days} hari = Rp ${formatRibuan(hallTotal)}`);

            // Services
            document.querySelectorAll('#services-wrapper .service-item').forEach(item => {
                let serviceSelect = item.querySelector('select');
                let quantityInput = item.querySelector('input[type="number"]');
                let serviceOption = serviceSelect.options[serviceSelect.selectedIndex];
                let price = parseFloat(serviceOption.dataset.price || 0);
                let qty = parseInt(quantityInput.value || 1);
                let subtotal = price * qty;
                total += subtotal;
                details.push(`${serviceOption.text} x ${qty} = Rp ${formatRibuan(subtotal)}`);
            });

            setTotalPrice(total);
            document.getElementById('price-details').innerHTML =
                details.join('<br>') + `<br><strong>Total: Rp ${formatRibuan(total)}</strong>`;
        }

        function addService() {
            const wrapper = document.getElementById('services-wrapper');
            const div = document.createElement('div');
            div.classList.add('flex','flex-col','sm:flex-row','sm:items-center','gap-3','service-item','bg-orange-50','p-3','rounded-lg','border','border-orange-200');

            div.innerHTML = `
                <select name="services[${serviceIndex}][service_id]" class="border border-gray-300 rounded-lg p-2 w-full sm:w-1/2 focus:border-orange-500 focus:ring-orange-500 transition" onchange="calculateTotal()">
                    @foreach($services as $s)
                        <option value="{{ $s->id }}" data-price="{{ $s->price }}">{{ $s->name }} - Rp {{ number_format($s->price,0,',','.') }}</option>
                    @endforeach
                </select>
                <input type="number" name="services[${serviceIndex}][quantity]" value="1" class="border border-gray-300 rounded-lg p-2 w-full sm:w-1/4 focus:border-orange-500 focus:ring-orange-500 transition" min="1" oninput="calculateTotal()">
                <button type="button" onclick="removeService(this)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition">❌</button>
            `;
            wrapper.appendChild(div);
            serviceIndex++;
            calculateTotal();
        }

        function removeService(button) {
            button.parentElement.remove();
            calculateTotal();
        }

        window.addEventListener('load', calculateTotal);
    </script>
</x-app-layout>
