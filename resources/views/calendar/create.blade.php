<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Availability') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                {{-- Tampilkan pesan error --}}
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Tampilkan pesan success --}}
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Form tambah availability --}}
                <form action="{{ route('calendar.store') }}" method="POST">
                    @csrf

                    {{-- Pilih Hall --}}
                    <div class="mb-4">
                        <label class="block font-semibold">Hall</label>
                        <select name="hall_id" class="w-full border p-2 rounded" required>
                            @foreach($halls as $hall)
                                <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Tanggal --}}
                    <div class="mb-4">
                        <label class="block font-semibold">Date</label>
                        <input type="date" name="date" class="w-full border p-2 rounded" required>
                    </div>

                    {{-- Status Availability --}}
                    <div class="mb-4">
                        <label class="block font-semibold">Status</label>
                        <select name="status" class="w-full border p-2 rounded">
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>

                    {{-- Catatan (opsional) --}}
                    <div class="mb-4">
                        <label class="block font-semibold">Note (optional)</label>
                        <input type="text" name="note" class="w-full border p-2 rounded" placeholder="e.g. Maintenance or Reserved">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
