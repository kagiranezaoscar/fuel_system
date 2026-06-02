<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Fuel Inventory</h2></x-slot>
    <div class="mx-auto max-w-7xl px-4 py-8">
        <x-flash />
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <form><input name="search" value="{{ request('search') }}" placeholder="Search fuel..." class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></form>
            <a href="{{ route('manager.fuel-types.create') }}" class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Add Fuel Type</a>
        </div>
        <div class="overflow-x-auto rounded-lg border bg-white dark:border-gray-700 dark:bg-gray-800"><table class="min-w-full text-sm"><thead class="bg-gray-50 dark:bg-gray-900"><tr><th class="p-3 text-left">Fuel</th><th class="p-3 text-left">Price/L</th><th class="p-3 text-left">Quantity</th><th class="p-3 text-left">Actions</th></tr></thead><tbody class="divide-y dark:divide-gray-700">@foreach($fuels as $fuel)<tr><td class="p-3 font-semibold">{{ $fuel->fuel_name }}</td><td class="p-3">RWF {{ number_format($fuel->price_per_liter, 2) }}</td><td class="p-3">{{ $fuel->available_quantity }} L</td><td class="p-3"><a class="text-emerald-600" href="{{ route('manager.fuel-types.edit', $fuel) }}">Edit</a></td></tr>@endforeach</tbody></table></div>
        <div class="mt-4">{{ $fuels->links() }}</div>
    </div>
</x-app-layout>

