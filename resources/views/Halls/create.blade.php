<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Hall') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('halls.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block">Hall Name</label>
                        <input type="text" name="name" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block">Capacity</label>
                        <input type="number" name="capacity" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block">Price</label>
                        <input type="number" name="price" class="w-full border p-2 rounded" required>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
