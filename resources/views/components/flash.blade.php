@if (session('success') || session('error'))
    <div class="mb-6 rounded-lg border px-4 py-3 text-sm {{ session('success') ? 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200' : 'border-red-200 bg-red-50 text-red-800 dark:border-red-800 dark:bg-red-950 dark:text-red-200' }}">
        {{ session('success') ?? session('error') }}
    </div>
@endif

