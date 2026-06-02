<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFuelSaleRequest;
use App\Http\Resources\FuelSaleResource;
use App\Models\FuelSale;
use App\Services\FuelSaleService;
use Illuminate\Http\Request;

class FuelSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FuelSale::with(['customer', 'details.fuel'])->latest('sale_date');

        if (! $request->user()->isManager()) {
            $query->where('customer_id', $request->user()->id);
        }

        return FuelSaleResource::collection($query->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuelSaleRequest $request, FuelSaleService $service)
    {
        return new FuelSaleResource($service->createSale($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelSale $fuelSale)
    {
        $this->authorize('view', $fuelSale);

        return new FuelSaleResource($fuelSale->load(['customer', 'details.fuel']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuelSale $fuelSale)
    {
        abort(405);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelSale $fuelSale)
    {
        abort(405);
    }
}
