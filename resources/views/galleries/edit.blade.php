<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center sm:text-left">
            {{ __('Edit Data Galeri') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 transition-transform transform hover:scale-[1.01]">

                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-l-4 border-orange-500 pl-3">
                    Informasi Galeri
                </h3>

                <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Judul Galeri</label>
                        <input type="text" name="title"
                               value="{{ old('title', $gallery->title) }}"
                               class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                               required>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                        <textarea name="description" rows="4"
                                  class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition">{{ old('description', $gallery->description) }}</textarea>
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Gambar</label>

                        @if($gallery->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $gallery->image) }}"
                                     class="h-40 rounded-lg shadow border object-cover">
                            </div>
                        @endif

                        <input type="file" name="image" accept="image/*"
                               class="w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition">
                        <p class="text-sm text-gray-500 mt-1">
                            Kosongkan jika tidak ingin mengganti gambar
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-4">
                        <a href="{{ route('galleries.index') }}"
                           class="w-full sm:w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
