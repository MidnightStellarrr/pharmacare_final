<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Stored Procedures Test
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Stored Procedure Results</h3>
                
                @if(isset($search_results) && !empty($search_results))
                <div class="mb-8">
                    <h4 class="font-semibold mb-3">sp_search_medicines('medicine')</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Name</th>
                                    <th class="px-4 py-2 text-left">Brand</th>
                                    <th class="px-4 py-2 text-center">Price</th>
                                    <th class="px-4 py-2 text-center">Stock</th>
                                    <th class="px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($search_results as $result)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $result->name }}</td>
                                    <td class="px-4 py-2">{{ $result->brand ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center">₱{{ number_format($result->price, 2) }}</td>
                                    <td class="px-4 py-2 text-center">{{ $result->stock }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-3 py-1 rounded text-xs font-semibold 
                                            {{ $result->stock_status === 'OUT_OF_STOCK' ? 'bg-red-100 text-red-800' : ($result->stock_status === 'LOW_STOCK' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $result->stock_status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                @if(isset($medicine_details) && !empty($medicine_details))
                <div>
                    <h4 class="font-semibold mb-3">sp_get_medicine_details()</h4>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($medicine_details[0] as $key => $value)
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="text-xs text-gray-600">{{ $key }}</p>
                            <p class="font-semibold">{{ $value }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($search_error))
                <div class="bg-red-50 border border-red-200 rounded p-4 text-red-700">
                    {{ $search_error }}
                </div>
                @endif

                @if(isset($medicine_details_error))
                <div class="bg-red-50 border border-red-200 rounded p-4 text-red-700">
                    {{ $medicine_details_error }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
