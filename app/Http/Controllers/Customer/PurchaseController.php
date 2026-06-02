<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerPurchaseRequest;
use App\Models\FuelSale;
use App\Models\FuelType;
use App\Services\FuelSaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function index(Request $request): View
    {
        return view('customer.purchases.index', [
            'sales' => FuelSale::with('details.fuel')
                ->where('customer_id', $request->user()->id)
                ->latest('sale_date')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('customer.purchases.create', ['fuels' => FuelType::orderBy('fuel_name')->get()]);
    }

    public function store(CustomerPurchaseRequest $request, FuelSaleService $service): RedirectResponse
    {
        $sale = $service->createSale($request->validated(), $request->user());

        return redirect()->route('customer.purchases.show', $sale)->with('success', 'Purchase request completed.');
    }

    public function show(Request $request, FuelSale $purchase): View
    {
        abort_if($purchase->customer_id !== $request->user()->id, 403);

        return view('customer.purchases.show', ['sale' => $purchase->load('details.fuel')]);
    }
}
