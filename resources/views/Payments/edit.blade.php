{{-- resources/views/payments/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __(' Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi error --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Edit Payment --}}
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('payments.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Reservation --}}
                        <div class="mb-4">
                            <label class="block font-medium text-gray-700">Reservasi</label>
                            <input type="text" 
                                value="{{ $payment->reservation->renter_name }}" 
                                class="w-full border rounded px-3 py-2 bg-gray-100" 
                                disabled>
                            <input type="hidden" name="reservation_id" value="{{ $payment->reservation_id }}">
                        </div>

                        {{-- Amount --}}
                       <div class="mb-4">
                        <label for="amount" class="block font-medium text-gray-700">Jumlah Pembayaran</label>
                        <input type="text" id="amount_formatted" 
                            value="{{ number_format($payment->amount, 0, ',', '.') }}" 
                            class="w-full border rounded px-3 py-2" placeholder="0" />

                        <!-- Hidden input untuk value asli -->
                        <input type="hidden" name="amount" id="amount" value="{{ $payment->amount }}">
                    </div>

                    <script>
                        const formattedInput = document.getElementById('amount_formatted');
                        const hiddenInput = document.getElementById('amount');

                        formattedInput.addEventListener('input', function(e) {
                            // Hapus semua non-digit
                            let value = this.value.replace(/\D/g, '');
                            hiddenInput.value = value; // update hidden input untuk dikirim ke server

                            // Format ribuan
                            this.value = new Intl.NumberFormat('id-ID').format(value);
                        });
                    </script>


                         {{-- Method --}}
                        <div class="mb-4">
                            <label for="method" class="block font-medium">Payment Method</label>
                            <select name="method" id="method" class="w-full border rounded px-3 py-2">
                                <option value="">-- Select Method --</option>
                                <option value="cash" {{ $payment->method == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ $payment->method == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                        </div>

                        {{-- Payment Date --}}
                        <div class="mb-4">
                            <label for="payment_date" class="block font-medium text-gray-700">Tanggal Pembayaran</label>
                            <input type="date" name="payment_date" id="payment_date"
                                value="{{ old('payment_date', $payment->payment_date ? date('Y-m-d', strtotime($payment->payment_date)) : date('Y-m-d')) }}"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        {{-- Status --}}
                        <input type="hidden" name="status" value="pending">

                        {{-- Bukti Pembayaran --}}
                        <div class="mb-4">
                            <label for="payment_proof" class="block font-medium text-gray-700">Bukti Pembayaran</label>
                            @if($payment->payment_proof)
                                <p class="mb-2 text-gray-600">
                                    Bukti sebelumnya: 
                                    <a href="{{ asset('storage/payment_proofs/' . $payment->payment_proof) }}" target="_blank" class="text-orange-600 underline">
                                        Lihat
                                    </a>
                                </p>
                            @endif
                            <input type="file" name="payment_proof" id="payment_proof" class="w-full border rounded px-3 py-2">
                            <small class="text-gray-500">Upload file baru jika ingin mengganti bukti pembayaran.</small>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('payments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Perbarui Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


                      

               