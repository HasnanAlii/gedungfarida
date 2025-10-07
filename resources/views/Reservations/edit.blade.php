<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Reservation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Customer otomatis --}}
                    <div class="mb-4">
                        <label class="block">Customer</label>
                        <input type="text" value="{{ $reservation->renter_name }}" 
                            class="w-full border p-2 rounded bg-gray-100" readonly>
                        <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">
                    </div>

                    {{-- Pilih Hall --}}
                    <div class="mb-4">
                        <label class="block">Hall</label>
                        <select name="hall_id" id="hall" class="w-full border p-2 rounded" onchange="calculateTotal()">
                            @foreach($halls as $hall)
                                <option value="{{ $hall->id }}" data-price="{{ $hall->price }}" 
                                    @if($reservation->hall_id == $hall->id) selected @endif>
                                    {{ $hall->name }} - Rp {{ number_format($hall->price,0,',','.') }} / hari
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Mulai & Selesai --}}
                    <div class="mb-4">
                        <label class="block">Tanggal Mulai Sewa</label>
                        <input type="date" id="event_start" name="event_start" 
                            class="w-full border p-2 rounded" required onchange="calculateTotal()"
                            value="{{ \Carbon\Carbon::parse($reservation->event_start)->format('Y-m-d') }}">
                    </div>
                    <div class="mb-4">
                        <label class="block">Tanggal Selesai Sewa</label>
                        <input type="date" id="event_end" name="event_end" 
                            class="w-full border p-2 rounded" required onchange="calculateTotal()"
                            value="{{ \Carbon\Carbon::parse($reservation->event_end)->format('Y-m-d') }}">
                    </div>

                    {{-- Services --}}
                    <div class="mb-4">
                        <label class="block font-semibold">Services</label>
                        <div id="services-wrapper">
                            @foreach($reservation->services as $index => $service)
                                <div class="flex space-x-2 mb-2 service-item">
                                    <select name="services[{{ $index }}][service_id]" class="border p-2 rounded w-1/2" onchange="calculateTotal()">
                                        @foreach($services as $s)
                                            <option value="{{ $s->id }}" data-price="{{ $s->price }}"
                                                @if($s->id == $service->id) selected @endif>
                                                {{ $s->name }} - Rp {{ number_format($s->price,0,',','.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="services[{{ $index }}][quantity]" value="{{ $service->pivot->quantity }}"
                                        class="border p-2 rounded w-1/4" min="1" oninput="calculateTotal()">
                                    <button type="button" onclick="removeService(this)" class="bg-red-500 text-white px-2 rounded">❌</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addService()" class="mt-2 bg-green-500 text-white px-3 py-1 rounded">
                            + Tambah Service
                        </button>
                    </div>

                    {{-- Total Price --}}
                    <div class="mb-4">
                        <label class="block">Total Price</label>
                        <input type="text" id="total_price_display" class="w-full border p-2 rounded bg-gray-100" readonly>
                        <input type="hidden" id="total_price" name="total_price" value="{{ $reservation->total_price }}">
                    </div>

                    <div id="price-details" class="mb-4 bg-gray-50 p-3 rounded border text-sm text-gray-700"></div>

                    {{-- Status --}}
                    @if(Auth::user()->hasRole('admin'))
                         <div class="mb-4">
                            <label class="block mb-1">Status</label>
                            <select name="status" class="w-full border p-2 rounded">
                                <option value="confirmed">Menunggu Pembayaran</option>
                                <option value="completed">Dibayar</option>
                                <option value="pending">Menunggu Dikonfirmasi</option>
                                <option value="canceled">Dibatalkan</option>
                            </select>
                         </div>
                    @endif

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Reservation</button>
                </form>
            </div>
        </div>
    </div>

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
        div.classList.add('flex','space-x-2','mb-2','service-item');

        div.innerHTML = `
            <select name="services[${serviceIndex}][service_id]" class="border p-2 rounded w-1/2" onchange="calculateTotal()">
                @foreach($services as $s)
                    <option value="{{ $s->id }}" data-price="{{ $s->price }}">{{ $s->name }} - Rp {{ number_format($s->price,0,',','.') }}</option>
                @endforeach
            </select>
            <input type="number" name="services[${serviceIndex}][quantity]" value="1" class="border p-2 rounded w-1/4" min="1" oninput="calculateTotal()">
            <button type="button" onclick="removeService(this)" class="bg-red-500 text-white px-2 rounded">❌</button>
        `;
        wrapper.appendChild(div);
        serviceIndex++;
        calculateTotal();
    }

    function removeService(button) {
        button.parentElement.remove();
        calculateTotal();
    }

    // Hitung total saat load
    window.addEventListener('load', calculateTotal);
</script>
</x-app-layout>
