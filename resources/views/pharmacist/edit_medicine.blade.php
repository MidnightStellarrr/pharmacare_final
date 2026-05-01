{{-- resources/views/pharmacist/edit_medicine.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Medicine') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('pharmacist.medicines.update', $medicine) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Same fields as add form, populated with $medicine data -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Medicine Name *</label>
                                <input type="text" name="name" value="{{ old('name', $medicine->name) }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Brand</label>
                                <input type="text" name="brand" value="{{ old('brand', $medicine->brand) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stock Quantity *</label>
                                <input type="number" name="stock" value="{{ old('stock', $medicine->stock) }}" required min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price (₱) *</label>
                                <input type="number" name="price" value="{{ old('price', $medicine->price) }}" required min="0" step="0.01"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Expiry Date *</label>
                                <input type="date" name="expiry_date" value="{{ old('expiry_date', $medicine->expiry_date->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Reorder Level *</label>
                                <input type="number" name="reorder_level" value="{{ old('reorder_level', $medicine->reorder_level) }}" required min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $medicine->description) }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('pharmacist.dashboard') }}" 
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Update Medicine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>