<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Query Performance Analysis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(isset($table_stats) && !empty($table_stats))
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Table Statistics</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Table</th>
                                <th class="px-4 py-2 text-center">Rows</th>
                                <th class="px-4 py-2 text-center">Size (MB)</th>
                                <th class="px-4 py-2 text-center">Auto Increment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($table_stats as $stat)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2"><strong>{{ $stat->table_name }}</strong></td>
                                <td class="px-4 py-2 text-center">{{ $stat->table_rows ?? 0 }}</td>
                                <td class="px-4 py-2 text-center">{{ $stat->size_mb }}</td>
                                <td class="px-4 py-2 text-center">{{ $stat->auto_increment ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if(isset($explain_search) && !empty($explain_search))
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Query Execution Plans (EXPLAIN)</h3>
                
                <div class="mb-6">
                    <h4 class="font-semibold mb-2 text-blue-600">Search Query: name OR brand LIKE '%pain%'</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">ID</th>
                                    <th class="px-3 py-2">Type</th>
                                    <th class="px-3 py-2">Key</th>
                                    <th class="px-3 py-2">Rows</th>
                                    <th class="px-3 py-2">Extra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($explain_search as $row)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $row->id }}</td>
                                    <td class="px-3 py-2">{{ $row->type }}</td>
                                    <td class="px-3 py-2"><code>{{ $row->key ?? 'NULL' }}</code></td>
                                    <td class="px-3 py-2">{{ $row->rows }}</td>
                                    <td class="px-3 py-2 text-xs">{{ $row->Extra }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold mb-2 text-blue-600">Stock Filter: stock <= reorder_level</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">ID</th>
                                    <th class="px-3 py-2">Type</th>
                                    <th class="px-3 py-2">Key</th>
                                    <th class="px-3 py-2">Rows</th>
                                    <th class="px-3 py-2">Extra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($explain_stock as $row)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $row->id }}</td>
                                    <td class="px-3 py-2">{{ $row->type }}</td>
                                    <td class="px-3 py-2"><code>{{ $row->key ?? 'NULL' }}</code></td>
                                    <td class="px-3 py-2">{{ $row->rows }}</td>
                                    <td class="px-3 py-2 text-xs">{{ $row->Extra }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold mb-2 text-blue-600">Category Filter: category = 'Pain Relief'</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">ID</th>
                                    <th class="px-3 py-2">Type</th>
                                    <th class="px-3 py-2">Key</th>
                                    <th class="px-3 py-2">Rows</th>
                                    <th class="px-3 py-2">Extra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($explain_category as $row)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $row->id }}</td>
                                    <td class="px-3 py-2">{{ $row->type }}</td>
                                    <td class="px-3 py-2"><code>{{ $row->key ?? 'NULL' }}</code></td>
                                    <td class="px-3 py-2">{{ $row->rows }}</td>
                                    <td class="px-3 py-2 text-xs">{{ $row->Extra }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold mb-2 text-blue-600">Composite Index: category AND stock > 0</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">ID</th>
                                    <th class="px-3 py-2">Type</th>
                                    <th class="px-3 py-2">Key</th>
                                    <th class="px-3 py-2">Rows</th>
                                    <th class="px-3 py-2">Extra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($explain_composite as $row)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $row->id }}</td>
                                    <td class="px-3 py-2">{{ $row->type }}</td>
                                    <td class="px-3 py-2"><code>{{ $row->key ?? 'NULL' }}</code></td>
                                    <td class="px-3 py-2">{{ $row->rows }}</td>
                                    <td class="px-3 py-2 text-xs">{{ $row->Extra }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h4 class="font-semibold text-blue-900 mb-2">Understanding Query Plans:</h4>
                <ul class="text-sm text-gray-700 space-y-2">
                    <li><strong>Type:</strong> ALL = full scan (slow), range = uses index (fast), eq_ref = primary key lookup</li>
                    <li><strong>Key:</strong> The index used; NULL means full table scan</li>
                    <li><strong>Rows:</strong> Estimated rows examined; lower is better</li>
                    <li><strong>Extra:</strong> Using index, Using where, Using filesort - explains additional operations</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
