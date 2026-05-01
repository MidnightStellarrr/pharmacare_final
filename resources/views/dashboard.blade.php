<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold">Welcome, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-600">You're logged in as a customer.</p>
                        </div>
                        <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            ← Back to Home
                        </a>
                    </div>
                    
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="/shop" class="block bg-teal-500 hover:bg-teal-700 text-white text-center py-2 rounded">
                            🛒 Shop Medicines
                        </a>
                        <a href="/cart" class="block bg-blue-500 hover:bg-blue-700 text-white text-center py-2 rounded">
                            🛍️ View Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>