<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __(' Daftar Galeri') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol Tambah Galeri --}}
            <div class="mb-6">
                <a href="{{ route('galleries.create') }}"
                   class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg shadow-lg font-semibold transition">
                    <i data-feather="plus" class="w-5 h-5"></i>
                    <span>Tambah Galeri</span>
                </a>
            </div>

            {{-- Grid Galeri --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @forelse($galleries as $gallery)
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">

                        {{-- Gambar Galeri --}}
                        <div class="h-48 bg-gray-100 overflow-hidden">
                            @if($gallery->image)
                                <img src="{{ asset('storage/' . $gallery->image) }}"
                                     alt="{{ $gallery->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i data-feather="image" class="w-16 h-16 text-gray-300"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Konten --}}
                        <div class="p-5 flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                {{ $gallery->title }}
                            </h3>

                            @if($gallery->description)
                                <p class="text-sm text-gray-600 line-clamp-3">
                                    {{ $gallery->description }}
                                </p>
                            @endif
                        </div>

                        {{-- Aksi --}}
                        <div class="bg-gray-50 p-4 border-t border-gray-100">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('galleries.edit', $gallery->id) }}"
                                   class="inline-flex items-center gap-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1.5 rounded-md text-xs font-medium transition">
                                    <i data-feather="edit-2" class="w-4 h-4"></i>
                                    Edit
                                </a>

                                <form action="{{ route('galleries.destroy', $gallery->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus galeri ini?')">
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
                    <div class="col-span-full bg-white shadow-lg rounded-xl p-12 text-center text-gray-500">
                        <i data-feather="image" class="w-12 h-12 mx-auto text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-700">Belum Ada Galeri</h3>
                        <p class="mt-2">Klik tombol "Tambah Galeri" untuk mulai menambahkan gambar.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>

    {{-- Feather Icons --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                feather.replace();
            });
        </script>
    @endpush
</x-app-layout>
