@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <label class="block text-sm font-medium">Name<input name="name" value="{{ old('name', $customer->name ?? '') }}" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
    <label class="block text-sm font-medium">Email<input name="email" type="email" value="{{ old('email', $customer->email ?? '') }}" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
    <label class="block text-sm font-medium">Username<input name="username" value="{{ old('username', $customer->username ?? '') }}" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
    <label class="block text-sm font-medium">Phone<input name="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
    <label class="block text-sm font-medium sm:col-span-2">Address<input name="address" value="{{ old('address', $customer->address ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
    <label class="block text-sm font-medium">Password<input name="password" type="password" {{ isset($customer) ? '' : 'required' }} class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
    <label class="block text-sm font-medium">Confirm password<input name="password_confirmation" type="password" {{ isset($customer) ? '' : 'required' }} class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"></label>
</div>
@if($errors->any())<div class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</div>@endif
<div class="mt-6 flex gap-3"><button class="rounded-md bg-emerald-600 px-4 py-2 font-semibold text-white">Save</button><a href="{{ route('manager.customers.index') }}" class="rounded-md border px-4 py-2">Cancel</a></div>
