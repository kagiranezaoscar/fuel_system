<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFuelSaleRequest;
use App\Models\FuelSale;
use App\Models\FuelType;
use App\Models\User;
use App\Services\FuelSaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FuelSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sales = FuelSale::with('customer')
            ->when($request->search, fn ($query, $search) => $query->whereHas('customer', fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")))
            ->when($request->from, fn ($query, $from) => $query->whereDate('sale_date', '>=', $from))
            ->when($request->to, fn ($query, $to) => $query->whereDate('sale_date', '<=', $to))
            ->latest('sale_date')
            ->paginate(12)
            ->withQueryString();

        return view('manager.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('manager.sales.create', [
            'fuels' => FuelType::orderBy('fuel_name')->get(),
            'customers' => User::where('role', 'customer')->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuelSaleRequest $request, FuelSaleService $service): RedirectResponse
    {
        $sale = $service->createSale($request->validated());

        return redirect()->route('manager.sales.show', $sale)->with('success', 'Sale recorded and stock updated.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelSale $sale): View
    {
        $sale->load(['customer', 'details.fuel']);

        return view('manager.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuelSale $fuelSale)
    {
        return redirect()->route('manager.sales.show', $fuelSale);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuelSale $fuelSale)
    {
        return redirect()->route('manager.sales.show', $fuelSale);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelSale $fuelSale): RedirectResponse
    {
        return redirect()->route('manager.sales.index')->with('error', 'Sales are audit records and cannot be deleted.');
    }
}
