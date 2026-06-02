@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <label class="block text-sm font-medium">Fuel name<input name="fuel_name" value="{{ old('fuel_name', $fuelType->fuel_name ?? '') }}" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
    <label class="block text-sm font-medium">Price per liter<input name="price_per_liter" type="number" step="0.01" min="0" value="{{ old('price_per_liter', $fuelType->price_per_liter ?? '') }}" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
    <label class="block text-sm font-medium">Available quantity<input name="available_quantity" type="number" step="0.001" min="0" value="{{ old('available_quantity', $fuelType->available_quantity ?? 0) }}" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
    <label class="block text-sm font-medium sm:col-span-2">Description<textarea name="description" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">{{ old('description', $fuelType->description ?? '') }}</textarea></label>
</div>
@if($errors->any())<div class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</div>@endif
<div class="mt-6 flex gap-3"><button class="rounded-md bg-emerald-600 px-4 py-2 font-semibold text-white">Save</button><a href="{{ route('manager.fuel-types.index') }}" class="rounded-md border px-4 py-2">Cancel</a></div>

