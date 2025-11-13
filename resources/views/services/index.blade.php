<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __(' Daftar Layanan') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert --}}
            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-100 border border-green-300 text-green-700 rounded-lg flex items-center gap-2">
                    <i data-feather="check-circle" class="w-5 h-5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-6">
                <a href="{{ route('services.create') }}" 
                   class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg shadow-lg font-semibold transition">
                    <i data-feather="plus" class="w-5 h-5"></i>
                    <span>Tambah Layanan</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @forelse($services as $service)
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                        
                        <div class="h-40 bg-gray-50 flex items-center justify-center border-b border-gray-100">
                            {{-- Ikon generik untuk 'Layanan' --}}
                            <i data-feather="settings" class="w-16 h-16 text-orange-300"></i>
                        </div>

                        <div class="p-6 flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $service->name }}</h3>
                            
                            <div>
                                <p class="text-xs text-gray-500">Harga Layanan</p>
                                <p class="text-3xl font-bold text-orange-600">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 border-t border-gray-100">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('services.edit', $service->id) }}" 
                                   class="inline-flex items-center gap-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1.5 rounded-md text-xs font-medium transition">
                                    <i data-feather="edit-2" class="w-4 h-4"></i>
                                    Edit
                                </a>

                                <form action="{{ route('services.destroy', $service->id) }}" 
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1.5 rounded-md text-xs font-medium transition">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 bg-white shadow-lg rounded-xl p-12 text-center text-gray-500">
                        <i data-feather="settings" class="w-12 h-12 mx-auto text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-700">Belum Ada Layanan</h3>
                        <p class="mt-2">Klik tombol "Tambah Layanan" untuk mulai menambahkan data.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $services->links() }}
            </div>

        </div>
    </div>
    
    {{-- Script untuk menjalankan Feather Icons --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                feather.replace();
            });
        </script>
    @endpush
</x-app-layout>