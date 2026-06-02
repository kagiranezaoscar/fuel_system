<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\FuelSale;
use App\Models\FuelType;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $todayRevenue = FuelSale::whereDate('sale_date', today())->sum('total_amount');
        $monthRevenue = FuelSale::whereMonth('sale_date', now()->month)->whereYear('sale_date', now()->year)->sum('total_amount');
        $yearRevenue = FuelSale::whereYear('sale_date', now()->year)->sum('total_amount');
        $dailySeries = FuelSale::selectRaw('DATE(sale_date) as day, SUM(total_amount) as total')
            ->where('sale_date', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('manager.dashboard', [
            'fuelCount' => FuelType::count(),
            'customerCount' => User::where('role', 'customer')->count(),
            'todayRevenue' => $todayRevenue,
            'monthRevenue' => $monthRevenue,
            'yearRevenue' => $yearRevenue,
            'recentSales' => FuelSale::with('customer')->latest('sale_date')->take(8)->get(),
            'lowStock' => FuelType::where('available_quantity', '<=', 500)->orderBy('available_quantity')->take(6)->get(),
            'recentStock' => StockMovement::with('fuel')->latest()->take(6)->get(),
            'chartLabels' => $dailySeries->pluck('day'),
            'chartValues' => $dailySeries->pluck('total'),
        ]);
    }
}
