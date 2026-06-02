<x-app-layout><x-slot name="header"><h2 class="text-xl font-semibold">Add Fuel Type</h2></x-slot><div class="mx-auto max-w-3xl px-4 py-8"><form method="POST" action="{{ route('manager.fuel-types.store') }}" class="rounded-lg border bg-white p-6 dark:border-gray-700 dark:bg-gray-800">@include('manager.fuel-types._form')</form></div></x-app-layout>

