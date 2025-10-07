<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __(' Daftar Layanan') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl p-6">
                {{-- Alert --}}
                @if(session('success'))
                    <div class="mb-4 px-4 py-2 bg-green-100 border border-green-300 text-green-700 rounded">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                <!-- Tombol Tambah -->
                <div class="mb-4">
                    <a href="{{ route('services.create') }}" 
                       class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
                        ➕ Tambah Layanan
                    </a>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-orange-200 to-orange-300 text-gray-800">
                                <th class="p-3 border text-center font-semibold">#</th>
                                <th class="p-3 border text-center font-semibold">Nama</th>
                                <th class="p-3 border text-center font-semibold">Harga</th>
                                <th class="p-3 border text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($services as $service)
                                <tr class="hover:bg-orange-50 transition">
                                    <!-- Nomor -->
                                    <td class="p-3 border text-center text-gray-700">
                                        {{ $loop->iteration }}
                                    </td>

                                    <!-- Nama -->
                                    <td class="p-3 border text-center font-medium text-gray-800">
                                        {{ $service->name }}
                                    </td>

                                    <!-- Harga -->
                                    <td class="p-3 border text-center font-semibold text-gray-900">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="p-3 border text-center space-x-2">
                                        <a href="{{ route('services.edit', $service->id) }}" 
                                           class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                            ✏️ Edit
                                        </a>

                                        <form action="{{ route('services.destroy', $service->id) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-block bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-500 italic">
                                        Belum ada layanan tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
