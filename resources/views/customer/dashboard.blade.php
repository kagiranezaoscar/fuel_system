<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Customer Dashboard</h2></x-slot>
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <x-flash />
        <div class="grid gap-4 md:grid-cols-3">
            <x-stat-card label="Total Spent" value="RWF {{ number_format($totalSpent, 2) }}" />
            <x-stat-card label="Available Fuels" value="{{ $fuels->count() }}" />
            <x-stat-card label="Purchases" value="{{ $sales->count() }}" />
        </div>
        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <div class="rounded-lg border bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 lg:col-span-2">
                <div class="flex items-center justify-between"><h3 class="font-semibold">Fuel Prices</h3><a href="{{ route('customer.purchases.create') }}" class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Purchase Fuel</a></div>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">@foreach($fuels as $fuel)<div class="rounded-lg border p-4 dark:border-gray-700"><div class="font-semibold">{{ $fuel->fuel_name }}</div><div class="text-sm text-gray-500">RWF {{ number_format($fuel->price_per_liter, 2) }} per liter</div><div class="mt-2 text-sm">{{ $fuel->available_quantity }} L available</div></div>@endforeach</div>
            </div>
            <div class="rounded-lg border bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="font-semibold">Recent Purchases</h3>
                <div class="mt-4 space-y-3">@forelse($sales as $sale)<a class="block rounded-md border p-3 text-sm dark:border-gray-700" href="{{ route('customer.purchases.show', $sale) }}"><b>RWF {{ number_format($sale->total_amount, 2) }}</b><br>{{ $sale->sale_date->format('Y-m-d H:i') }}</a>@empty<p class="text-sm text-gray-500">No purchases yet.</p>@endforelse</div>
            </div>
        </div>
    </div>
</x-app-layout>
