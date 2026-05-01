<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pharmacist Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700">
                    {{ __("Welcome Pharmacist! You're logged in!") }}
                </p>
            </div>

            <!-- 📊 KPI CARDS (Dynamic) -->
            <div id="stats-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Loading stats...</p>
                </div>
            </div>

            <!-- 🧭 MAIN SECTIONS -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Inventory Management -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-3">Inventory Management</h3>

                    <div class="flex gap-2 mb-3">
                        <a href="{{ route('pharmacist.medicines.create') }}" 
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Add Medicine
                        </a>
                        <!-- 
                        <button onclick="refreshInventory()" 
                                class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                            Refresh Inventory
                        </button>
                        -->
                    </div>

                    <div id="inventory-table">
                        <table class="w-full text-sm border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2">Image</th>
                                    <th class="p-2">Name</th>
                                    <th class="p-2">Stock</th>
                                    <th class="p-2">Expiry</th>
                                    <th class="p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="inventory-body">
                                <tr class="text-center">
                                    <td colspan="5" class="p-2">Loading medicines...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- 📊 REPORTS -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-3">Reports & Analytics</h3>
                    <div class="flex flex-wrap gap-2">
                        <button class="border px-3 py-1 rounded hover:bg-gray-100">Sales Report</button>
                        <button class="border px-3 py-1 rounded hover:bg-gray-100">Inventory Report</button>
                        <button class="border px-3 py-1 rounded hover:bg-gray-100">Expiry Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT DIRECTLY HERE - NOT USING PUSH -->
    <script>
        // Replace the loadInventory function in dashboard.blade.php
        function loadInventory() {
            fetch('/pharmacist/inventory-data')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('inventory-body');
                    tbody.innerHTML = '';
                    
                    if (data.medicines.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center p-2">No medicines found. Add some!</td></tr>';
                        return;
                    }
                    
                    data.medicines.forEach(medicine => {
                        const stockClass = medicine.stock <= medicine.reorder_level ? 'text-red-600 font-bold' : '';
                        const imageUrl = medicine.image ? `/storage/${medicine.image}` : '/images/default-medicine.png';
                        
                        const row = `
                            <tr class="border-t">
                                <td class="p-2 text-center">
                                    <img src="${imageUrl}" alt="${medicine.name}" class="h-10 w-10 object-cover rounded mx-auto">
                                </td>
                                <td class="p-2 text-center">${medicine.name}</td>
                                <td class="p-2 text-center ${stockClass}">${medicine.stock}</td>
                                <td class="p-2 text-center">${medicine.expiry_date.split('T')[0]}</td>
                                <td class="p-2 text-center">
                                    <button onclick="editMedicine(${medicine.id})" 
                                            class="bg-yellow-400 px-2 py-1 rounded text-white hover:bg-yellow-500">
                                        Edit
                                    </button>
                                    <button onclick="deleteMedicine(${medicine.id})" 
                                            class="bg-red-500 px-2 py-1 rounded text-white hover:bg-red-600">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('inventory-body').innerHTML = '<tr><td colspan="5" class="text-center p-2 text-red-600">Error loading data</td></tr>';
                });
        }

        // Function to load stats
        function loadStats() {
            fetch('/pharmacist/inventory-data')
                .then(response => response.json())
                .then(data => {
                    const statsContainer = document.getElementById('stats-container');
                    statsContainer.innerHTML = `
                        <div class="bg-white p-4 rounded-lg shadow">
                            <p class="text-sm text-gray-500">Total Stock Value</p>
                            <h3 class="text-2xl font-bold">₱${data.stats.total_stock_value.toFixed(2)}</h3>
                        </div>
                        <div class="bg-yellow-400 text-white p-4 rounded-lg shadow">
                            <p class="text-sm">Low Stock Alerts</p>
                            <h3 class="text-2xl font-bold">${data.stats.low_stock_alerts} Items</h3>
                        </div>
                        <div class="bg-red-500 text-white p-4 rounded-lg shadow">
                            <p class="text-sm">Near Expiry</p>
                            <h3 class="text-2xl font-bold">${data.stats.near_expiry} Products</h3>
                        </div>
                        <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                            <p class="text-sm">Today's Sales</p>
                            <h3 class="text-2xl font-bold">₱${data.stats.today_sales}</h3>
                        </div>
                    `;
                })
                .catch(error => console.error('Error loading stats:', error));
        }

        // Function to refresh
        function refreshInventory() {
            loadInventory();
            loadStats();
        }

        // Function to edit medicine
        function editMedicine(id) {
            window.location.href = `/pharmacist/medicines/${id}/edit`;
        }

        // Function to delete medicine
        function deleteMedicine(id) {
            if (confirm('Are you sure you want to delete this medicine?')) {
                fetch(`/pharmacist/medicines/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        loadInventory();
                        loadStats();
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Load everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadInventory();
            loadStats();
        });
    </script>
</x-app-layout>