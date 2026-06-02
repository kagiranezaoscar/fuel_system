<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\FuelSale;
use App\Models\FuelType;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('customer.dashboard', [
            'fuels' => FuelType::orderBy('fuel_name')->get(),
            'sales' => FuelSale::with('details.fuel')
                ->where('customer_id', $request->user()->id)
                ->latest('sale_date')
                ->take(8)
                ->get(),
            'totalSpent' => FuelSale::where('customer_id', $request->user()->id)->sum('total_amount'),
        ]);
    }
}
