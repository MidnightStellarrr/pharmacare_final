<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Database Features & Statistics
        </h2>
        <p class="text-sm text-gray-600 mt-2">Explore views, stored procedures, triggers, and indexes</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Summary -->
            @if($inventory_summary)
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg rounded-lg p-6 mb-8 text-white">
                <h3 class="text-xl font-bold mb-4">Inventory Summary (From Database VIEW)</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-blue-100">Total Medicines</p>
                        <p class="text-3xl font-bold">{{ $inventory_summary->total_medicines }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100">Total Units</p>
                        <p class="text-3xl font-bold">{{ $inventory_summary->total_units }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100">Total Value</p>
                        <p class="text-3xl font-bold">₱{{ number_format($inventory_summary->total_value, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100">Low Stock</p>
                        <p class="text-3xl font-bold text-red-300">{{ $inventory_summary->low_stock_count }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="mb-8 border-b border-gray-200">
                <div class="flex flex-wrap -mb-px">
                    <button onclick="switchTab('views')" class="tab-button active px-4 py-3 border-b-2 border-blue-600 text-blue-600 font-semibold">Database Views</button>
                    <button onclick="switchTab('procedures')" class="tab-button px-4 py-3 border-b-2 border-transparent text-gray-600 hover:text-gray-800 font-semibold">Stored Procedures</button>
                    <button onclick="switchTab('triggers')" class="tab-button px-4 py-3 border-b-2 border-transparent text-gray-600 hover:text-gray-800 font-semibold">Triggers</button>
                    <button onclick="switchTab('indexes')" class="tab-button px-4 py-3 border-b-2 border-transparent text-gray-600 hover:text-gray-800 font-semibold">Indexes</button>
                </div>
            </div>

            <!-- Views Tab -->
            <div id="views" class="tab-content block space-y-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-mono mr-2">VIEW</span>
                        <span>low_stock_medicines</span>
                    </h3>
                    <p class="text-gray-600 mb-4">Medicines with stock at or below reorder level</p>
                    @if($low_stock_medicines)
                        @if(count($low_stock_medicines) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">ID</th>
                                        <th class="px-4 py-2 text-left">Name</th>
                                        <th class="px-4 py-2 text-left">Brand</th>
                                        <th class="px-4 py-2 text-center">Stock</th>
                                        <th class="px-4 py-2 text-center">Reorder Level</th>
                                        <th class="px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($low_stock_medicines as $medicine)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $medicine->id }}</td>
                                        <td class="px-4 py-2">{{ $medicine->name }}</td>
                                        <td class="px-4 py-2">{{ $medicine->brand ?? '-' }}</td>
                                        <td class="px-4 py-2 text-center"><strong>{{ $medicine->stock }}</strong></td>
                                        <td class="px-4 py-2 text-center">{{ $medicine->reorder_level }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-3 py-1 rounded text-sm font-semibold 
                                                {{ $medicine->stock_status === 'OUT OF STOCK' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $medicine->stock_status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-gray-500 italic">No low stock medicines found (good news!)</p>
                        @endif
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-mono mr-2">VIEW</span>
                        <span>near_expiry_medicines</span>
                    </h3>
                    <p class="text-gray-600 mb-4">Medicines expiring within 30 days</p>
                    @if($near_expiry_medicines)
                        @if(count($near_expiry_medicines) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Name</th>
                                        <th class="px-4 py-2 text-left">Brand</th>
                                        <th class="px-4 py-2">Expiry Date</th>
                                        <th class="px-4 py-2 text-center">Days Until Expiry</th>
                                        <th class="px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($near_expiry_medicines as $medicine)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $medicine->name }}</td>
                                        <td class="px-4 py-2">{{ $medicine->brand ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $medicine->expiry_date }}</td>
                                        <td class="px-4 py-2 text-center"><strong>{{ $medicine->days_until_expiry }}</strong></td>
                                        <td class="px-4 py-2">
                                            <span class="px-3 py-1 rounded text-sm font-semibold 
                                                {{ $medicine->expiry_status === 'EXPIRED' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800' }}">
                                                {{ $medicine->expiry_status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-gray-500 italic">No medicines expiring soon</p>
                        @endif
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-mono mr-2">VIEW</span>
                        <span>category_inventory</span>
                    </h3>
                    <p class="text-gray-600 mb-4">Inventory breakdown by category</p>
                    @if($category_inventory)
                        @if(count($category_inventory) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Category</th>
                                        <th class="px-4 py-2 text-center">Medicines</th>
                                        <th class="px-4 py-2 text-center">Total Units</th>
                                        <th class="px-4 py-2 text-right">Value</th>
                                        <th class="px-4 py-2 text-right">Avg Price</th>
                                        <th class="px-4 py-2 text-center">Low Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category_inventory as $cat)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2"><strong>{{ $cat->category ?? 'Uncategorized' }}</strong></td>
                                        <td class="px-4 py-2 text-center">{{ $cat->total_medicines }}</td>
                                        <td class="px-4 py-2 text-center">{{ $cat->total_units }}</td>
                                        <td class="px-4 py-2 text-right">₱{{ number_format($cat->category_value, 2) }}</td>
                                        <td class="px-4 py-2 text-right">₱{{ number_format($cat->avg_price, 2) }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <span class="px-2 py-1 rounded text-xs {{ $cat->low_stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $cat->low_stock }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Procedures Tab -->
            <div id="procedures" class="tab-content hidden space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded text-sm font-mono mr-2">PROCEDURE</span>
                        <span>sp_get_inventory_stats()</span>
                    </h3>
                    <p class="text-gray-600 mb-4">Real-time inventory statistics</p>
                    @if($stored_proc_stats)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 p-4 rounded">
                            <p class="text-gray-600 text-sm">Total Medicines</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $stored_proc_stats->total_medicines }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded">
                            <p class="text-gray-600 text-sm">Total Units</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $stored_proc_stats->total_units }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded">
                            <p class="text-gray-600 text-sm">Out of Stock</p>
                            <p class="text-2xl font-bold text-red-600">{{ $stored_proc_stats->out_of_stock }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded">
                            <p class="text-gray-600 text-sm">Low Stock</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $stored_proc_stats->low_stock }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <h4 class="font-semibold mb-2">Stored Procedures Available:</h4>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li><code class="bg-yellow-100 px-2 py-1 rounded">sp_add_to_cart()</code> - Safely add items to cart with stock validation</li>
                        <li><code class="bg-yellow-100 px-2 py-1 rounded">sp_get_medicine_details()</code> - Get medicine with stock and expiry status</li>
                        <li><code class="bg-yellow-100 px-2 py-1 rounded">sp_get_inventory_stats()</code> - Real-time inventory statistics</li>
                        <li><code class="bg-yellow-100 px-2 py-1 rounded">sp_reduce_stock()</code> - Safely reduce medicine stock</li>
                        <li><code class="bg-yellow-100 px-2 py-1 rounded">sp_search_medicines()</code> - Search medicines by name/brand/category</li>
                    </ul>
                </div>
            </div>

            <!-- Triggers Tab -->
            <div id="triggers" class="tab-content hidden space-y-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-lg mb-4 text-red-900">Database Triggers ({{ count($triggers) }})</h3>
                    <p class="text-gray-700 mb-4">Triggers enforce business rules at the database level:</p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start">
                            <span class="bg-red-600 text-white px-2 py-1 rounded mr-3 text-xs font-bold">BEFORE INSERT</span>
                            <span><strong>prevent_expired_medicine_cart</strong> - Blocks adding expired medicines to cart</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-red-600 text-white px-2 py-1 rounded mr-3 text-xs font-bold">BEFORE INSERT</span>
                            <span><strong>prevent_out_of_stock_cart</strong> - Prevents out-of-stock items from being added</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-red-600 text-white px-2 py-1 rounded mr-3 text-xs font-bold">BEFORE INSERT</span>
                            <span><strong>validate_cart_item_price</strong> - Auto-syncs cart item price with current medicine price</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-red-600 text-white px-2 py-1 rounded mr-3 text-xs font-bold">BEFORE INSERT</span>
                            <span><strong>validate_medicine_expiry</strong> - Prevents adding medicines with past expiry dates</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-red-600 text-white px-2 py-1 rounded mr-3 text-xs font-bold">BEFORE INSERT</span>
                            <span><strong>validate_medicine_price</strong> - Ensures medicine price is valid (> 0)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-red-600 text-white px-2 py-1 rounded mr-3 text-xs font-bold">BEFORE INSERT</span>
                            <span><strong>validate_medicine_stock</strong> - Prevents negative stock values</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-red-600 text-white px-2 py-1 rounded mr-3 text-xs font-bold">BEFORE UPDATE</span>
                            <span><strong>validate_reorder_level</strong> - Validates reorder level constraints</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-red-600 text-white px-2 py-1 rounded mr-3 text-xs font-bold">BEFORE UPDATE</span>
                            <span><strong>update_medicine_on_stock_change</strong> - Updates timestamp when stock changes</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-red-600 text-white px-2 py-1 rounded mr-3 text-xs font-bold">AFTER DELETE</span>
                            <span><strong>update_stock_on_cart_delete</strong> - Updates medicine timestamp on cart item removal</span>
                        </li>
                    </ul>
                </div>

                @if($triggers)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="font-semibold mb-3">Active Triggers in Database:</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Trigger</th>
                                        <th class="px-4 py-2 text-left">Table</th>
                                        <th class="px-4 py-2">Event</th>
                                        <th class="px-4 py-2">Timing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($triggers as $trigger)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2"><code>{{ $trigger->Trigger }}</code></td>
                                        <td class="px-4 py-2">{{ $trigger->Table }}</td>
                                        <td class="px-4 py-2">{{ $trigger->Event }}</td>
                                        <td class="px-4 py-2">{{ $trigger->Timing }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Indexes Tab -->
            <div id="indexes" class="tab-content hidden space-y-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-3 text-blue-900">Optimization Indexes</h3>
                    <p class="text-sm text-gray-700 mb-4">Indexes speed up queries by avoiding full table scans:</p>
                </div>

                @foreach(['medicines', 'users', 'carts', 'cart_items'] as $table)
                    @if(isset($all_indexes[$table]))
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="font-semibold mb-3">Table: <code class="bg-gray-100 px-2 py-1 rounded">{{ $table }}</code></h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Index Name</th>
                                        <th class="px-4 py-2 text-left">Columns</th>
                                        <th class="px-4 py-2">Unique</th>
                                        <th class="px-4 py-2">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_indexes[$table] as $index)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2"><code class="bg-yellow-50 px-2 py-1 rounded">{{ $index->Key_name }}</code></td>
                                        <td class="px-4 py-2">{{ $index->Column_name }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <span class="px-2 py-1 rounded text-xs {{ $index->Non_unique == 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $index->Non_unique == 0 ? 'YES' : 'NO' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ $index->Index_type }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                @endforeach

                @if($db_size)
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h4 class="font-semibold">Database Size</h4>
                    <p class="text-2xl font-bold text-green-600">{{ $db_size->size_mb ?? 'N/A' }} MB</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
                tab.classList.remove('block');
            });

            // Deactivate all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('border-blue-600', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-600');
            });

            // Show selected tab
            document.getElementById(tabName).classList.remove('hidden');
            document.getElementById(tabName).classList.add('block');

            // Activate button
            event.target.classList.remove('border-transparent', 'text-gray-600');
            event.target.classList.add('border-blue-600', 'text-blue-600');
        }
    </script>
</x-app-layout>
