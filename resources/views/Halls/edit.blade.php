<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Hall') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('halls.update', $hall->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block">Hall Name</label>
                        <input type="text" name="name" value="{{ old('name', $hall->name) }}" class="w-full border p-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block">Capacity</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $hall->capacity) }}" class="w-full border p-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block">Price</label>
                        <input type="number" name="price" value="{{ old('price', $hall->price) }}" class="w-full border p-2 rounded">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
