{{-- resources/views/payments/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
         <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
            <span>{{ __(' Pembayaran') }}</span>
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8 ">

                {{-- Notifikasi Error --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg border border-red-300">
                        <strong class="block mb-1">Terjadi Kesalahan:</strong>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Title -->
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-l-4 border-orange-500 pl-3">
                    Formulir Pembayaran
                </h3>
                <form action="{{ route('payments.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Penyewa --}}
                    <div class="mb-6">
                        <label class="block font-semibold text-gray-700 mb-1">Nama Penyewa</label>
                        <input type="text"
                            value="{{ $payment->reservation->renter_name }}"
                            class="w-full border-gray-300 border rounded-xl px-4 py-2.5 bg-gray-100 text-gray-700"
                            readonly>
                        <input type="hidden" name="reservation_id" value="{{ $payment->reservation_id }}">
                    </div>

                    {{-- Jumlah Pembayaran --}}
                    <div class="mb-6">
                        <label for="amount" class="block font-semibold text-gray-700 mb-1">Jumlah Pembayaran</label>
                        <input type="text" id="amount_formatted"
                            value="{{ number_format($payment->amount, 0, ',', '.') }}"
                            class="w-full border-gray-300 border rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                            placeholder="0" />

                        <input type="hidden" name="amount" id="amount" value="{{ $payment->amount }}">
                    </div>

                    <script>
                        const formattedInput = document.getElementById('amount_formatted');
                        const hiddenInput = document.getElementById('amount');

                        formattedInput.addEventListener('input', function() {
                            let value = this.value.replace(/\D/g, '');
                            hiddenInput.value = value;
                            this.value = new Intl.NumberFormat('id-ID').format(value);
                        });
                    </script>

                    {{-- Metode Pembayaran --}}
                    <div class="mb-6">
                        <label for="method" class="block font-semibold text-gray-700 mb-1">Metode Pembayaran</label>
                        <select name="method" id="method"
                            class="w-full border-gray-300 border rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                            <option value="">-- Pilih Metode --</option>
                            <option value="cash" {{ $payment->method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="transfer" {{ $payment->method == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        </select>
                    </div>

                    {{-- Tanggal Pembayaran --}}
                    <div class="mb-6">
                        <label for="payment_date" class="block font-semibold text-gray-700 mb-1">Tanggal Pembayaran</label>
                        <input type="date" name="payment_date" id="payment_date"
                            value="{{ old('payment_date', $payment->payment_date ? date('Y-m-d', strtotime($payment->payment_date)) : date('Y-m-d')) }}"
                            class="w-full border-gray-300 border rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                    </div>

                    {{-- Bukti Pembayaran --}}
                    <div class="mb-6">
                        <label for="payment_proof" class="block font-semibold text-gray-700 mb-2">Bukti Pembayaran</label>
                        @if($payment->payment_proof)
                            <p class="mb-3 text-gray-600">
                                Bukti sebelumnya:
                                <a href="{{ asset('storage/payment_proofs/' . $payment->payment_proof) }}"
                                    target="_blank" class="text-orange-600 underline hover:text-orange-700">
                                    Lihat Bukti
                                </a>
                            </p>
                        @endif
                        <input type="file" name="payment_proof" id="payment_proof"
                            class="w-full border-gray-300 border rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                        <small class="text-gray-500 block mt-1">Upload file baru jika ingin mengganti bukti pembayaran.</small>
                    </div>
                    {{-- Status --}}
                     <input type="hidden" name="status" value="pending">

                    {{-- Tombol --}}
                    <div class="flex justify-end space-x-3 mt-8">
                        <a href="{{ route('payments.index') }}"
                            class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-300 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-orange-500 text-white px-6 py-2.5 rounded-xl shadow hover:bg-orange-600 transition">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
