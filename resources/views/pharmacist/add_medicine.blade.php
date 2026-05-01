{{-- resources/views/pharmacist/add_medicine.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Medicine') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form id="medicine-form" method="POST" action="{{ route('pharmacist.medicines.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Medicine Image -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Medicine Image</label>
                                <div class="mt-1 flex items-center space-x-4">
                                    <div id="image-preview" class="hidden">
                                        <img id="preview-img" class="h-32 w-32 object-cover rounded-lg border" alt="Preview">
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="image" id="image-input" accept="image/*"
                                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <p class="mt-1 text-xs text-gray-500">JPEG, PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Medicine Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Medicine Name *</label>
                                <input type="text" name="name" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Brand -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Brand</label>
                                <input type="text" name="brand" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Category</option>
                                    <option value="Pain Relief">Pain Relief</option>
                                    <option value="Antibiotics">Antibiotics</option>
                                    <option value="Vitamins">Vitamins</option>
                                    <option value="First Aid">First Aid</option>
                                    <option value="Allergy">Allergy</option>
                                    <option value="Gastrointestinal">Gastrointestinal</option>
                                </select>
                            </div>

                            <!-- Supplier -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Supplier</label>
                                <input type="text" name="supplier" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Stock Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stock Quantity *</label>
                                <input type="number" name="stock" required min="0" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price (₱) *</label>
                                <input type="number" name="price" required min="0" step="0.01" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Expiry Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Expiry Date *</label>
                                <input type="date" name="expiry_date" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Reorder Level -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Reorder Level *</label>
                                <input type="number" name="reorder_level" required min="0" value="10"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('pharmacist.dashboard') }}" 
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Add Medicine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Image preview
        document.getElementById('image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    const img = document.getElementById('preview-img');
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Form submission
        document.getElementById('medicine-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("pharmacist.medicines.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert(data.message);
                    window.location.href = '{{ route("pharmacist.dashboard") }}';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.submit();
            });
        });
    </script>
</x-app-layout>