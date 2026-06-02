<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Administrator Dashboard</h2></x-slot>
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <x-flash />
        <div class="grid gap-4 md:grid-cols-4">
            <x-stat-card label="Today Revenue" value="RWF {{ number_format($todayRevenue, 2) }}" />
            <x-stat-card label="Monthly Revenue" value="RWF {{ number_format($monthRevenue, 2) }}" />
            <x-stat-card label="Customers" value="{{ $customerCount }}" />
            <x-stat-card label="Fuel Types" value="{{ $fuelCount }}" />
        </div>
        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <div class="rounded-lg border bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 lg:col-span-2">
                <h3 class="font-semibold text-gray-900 dark:text-white">Daily Revenue</h3>
                <canvas id="revenueChart" class="mt-4 h-72"></canvas>
            </div>
            <div class="rounded-lg border bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="font-semibold text-gray-900 dark:text-white">Low Stock</h3>
                <div class="mt-4 space-y-3">
                    @forelse ($lowStock as $fuel)
                        <div class="flex justify-between rounded-md bg-amber-50 px-3 py-2 text-sm text-amber-900 dark:bg-amber-950 dark:text-amber-100"><span>{{ $fuel->fuel_name }}</span><b>{{ $fuel->available_quantity }} L</b></div>
                    @empty
                        <p class="text-sm text-gray-500">No low-stock items.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="mt-6 rounded-lg border bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between border-b p-5 dark:border-gray-700"><h3 class="font-semibold text-gray-900 dark:text-white">Recent Transactions</h3><a class="text-sm font-semibold text-emerald-600" href="{{ route('manager.sales.index') }}">View all</a></div>
            <div class="overflow-x-auto"><table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700"><tbody class="divide-y dark:divide-gray-700">@foreach($recentSales as $sale)<tr><td class="p-4">{{ $sale->sale_date->format('Y-m-d H:i') }}</td><td class="p-4">{{ $sale->customer?->name ?? 'Walk-in customer' }}</td><td class="p-4">{{ ucfirst($sale->payment_method) }}</td><td class="p-4 font-semibold">RWF {{ number_format($sale->total_amount, 2) }}</td></tr>@endforeach</tbody></table></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('revenueChart'), {type:'line',data:{labels:@json($chartLabels),datasets:[{label:'Revenue',data:@json($chartValues),borderColor:'#059669',backgroundColor:'rgba(5,150,105,.16)',fill:true,tension:.35}]},options:{responsive:true,maintainAspectRatio:false}});
    </script>
</x-app-layout>
