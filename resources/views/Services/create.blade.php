<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block">Service Name</label>
                        <input type="text" name="name" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block">Description</label>
                        <textarea name="description" class="w-full border p-2 rounded"></textarea>
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
