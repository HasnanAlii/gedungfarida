<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('services.update', $service->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block">Service Name</label>
                        <input type="text" name="name" value="{{ $service->name }}" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block">Description</label>
                        <textarea name="description" class="w-full border p-2 rounded">{{ $service->description }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block">Price</label>
                        <input type="number" name="price" value="{{ $service->price }}" class="w-full border p-2 rounded" required>
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
