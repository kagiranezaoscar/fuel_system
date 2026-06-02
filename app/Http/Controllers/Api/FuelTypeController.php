<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFuelTypeRequest;
use App\Http\Requests\UpdateFuelTypeRequest;
use App\Http\Resources\FuelTypeResource;
use App\Models\FuelType;
use Illuminate\Http\Request;

class FuelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FuelTypeResource::collection(FuelType::orderBy('fuel_name')->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuelTypeRequest $request)
    {
        return new FuelTypeResource(FuelType::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelType $fuelType)
    {
        return new FuelTypeResource($fuelType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFuelTypeRequest $request, FuelType $fuelType)
    {
        $fuelType->update($request->validated());

        return new FuelTypeResource($fuelType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelType $fuelType)
    {
        $fuelType->delete();

        return response()->noContent();
    }
}
