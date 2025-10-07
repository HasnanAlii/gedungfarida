<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __(' Daftar Reservasi') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-xl p-6">
                
                <!-- Tombol Tambah -->
                <a href="{{ route('reservations.create') }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md font-semibold transition">
                     ➕ Buat Reservasi
                </a>

                <!-- Table -->
                <div class="mt-6 overflow-x-auto">
                    <table class="w-full border-collapse rounded-xl overflow-hidden shadow-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-orange-200 to-orange-300 text-gray-800">
                                 <th class="px-4 py-3 border text-center font-semibold">ID Reservasi </th>
                                @hasrole('admin')
                                <th class="px-4 py-3 border text-left font-semibold">Penyewa</th>
                                @endhasrole
                                <th class="p-3 text-center text-sm font-semibold border">Tanggal Sewa</th>
                                <th class="p-3 text-left text-sm font-semibold border">Layanan Tambahan</th>
                                <th class="p-3 text-center text-sm font-semibold border">Total</th>
                                <th class="p-3 text-center text-sm font-semibold border">Status</th>
                                <th class="p-3 text-center text-sm font-semibold border">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($reservations as $reservation)
                                <tr class="hover:bg-gray-50 transition">
                                       <td class="px-4 py-3 border text-gray-700 text-center">{{ $reservation->id}}</td>
                                    <!-- Customer -->
                                     @hasrole('admin')
                                    <td class="p-3 border text-gray-700">
                                        {{ $reservation->renter_name }}
                                    </td>
                                     @endhasrole

                                    

                                    <!-- Tanggal -->
                                    <td class="p-3 border text-center text-gray-600">
                                        {{ $reservation->event_start->format('d M Y') }} – 
                                        {{ $reservation->event_end->format('d M Y') }}
                                    </td>

                                    <!-- Catering -->
                                    <td class="p-3 border text-gray-700">
                                        @if($reservation->services->count() > 0)
                                            <ul class="list-disc pl-4 text-sm text-gray-600">
                                                @foreach($reservation->services as $service)
                                                    <li>{{ $service->name }} x {{ $service->pivot->quantity }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>

                                    <!-- Total -->
                                    <td class="p-3 border text-center font-semibold text-gray-800">
                                        Rp {{ number_format($reservation->total_price,0,',','.') }}
                                    </td>

                                    <!-- Status -->
                                    @php
                                        $statusLabels = [
                                            'confirmed' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-yellow-100 text-yellow-800'],
                                            'completed' => ['label' => 'Reservasi Sukses', 'class' => 'bg-green-100 text-green-800'],
                                            'pending'   => ['label' => 'Menunggu Dikonfirmasi', 'class' => 'bg-blue-100 text-blue-800'],
                                            'canceled'  => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800'],
                                        ];
                                        $status = $statusLabels[$reservation->status] ?? ['label' => ucfirst($reservation->status), 'class' => 'bg-gray-100 text-gray-800'];
                                    @endphp

                                    <td class="p-3 border text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="p-3 border text-center space-x-2">
                                        <!-- Edit -->
                                        <a href="{{ route('reservations.edit', $reservation->id) }}" 
                                           class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                            ✏️ Edit
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('reservations.destroy', $reservation->id) }}" 
                                              method="POST" class="inline-block"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                                🗑️ Delete
                                            </button>
                                        </form>

                                        <!-- Konfirmasi (Admin Only) -->
                                        @if(Auth::user()->hasRole('admin') && $reservation->status === 'pending')
                                            <form action="{{ route('reservations.konfirmasi', $reservation->id) }}" 
                                                  method="POST" class="inline-block"
                                                  onsubmit="return confirm('Konfirmasi reservasi ini?')">
                                                @csrf @method('PUT')
                                                <button type="submit" 
                                                        class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                                    ✅ Konfirmasi
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
