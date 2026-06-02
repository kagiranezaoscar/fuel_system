<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFuelTypeRequest;
use App\Http\Requests\UpdateFuelTypeRequest;
use App\Models\FuelType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FuelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $fuels = FuelType::query()
            ->when($request->search, fn ($query, $search) => $query->where('fuel_name', 'like', "%{$search}%"))
            ->orderBy('fuel_name')
            ->paginate(10)
            ->withQueryString();

        return view('manager.fuel-types.index', compact('fuels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('manager.fuel-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuelTypeRequest $request): RedirectResponse
    {
        FuelType::create($request->validated());

        return redirect()->route('manager.fuel-types.index')->with('success', 'Fuel type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelType $fuelType): View
    {
        $fuelType->load(['stockMovements' => fn ($query) => $query->latest()->take(20)]);

        return view('manager.fuel-types.show', compact('fuelType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuelType $fuelType): View
    {
        return view('manager.fuel-types.edit', compact('fuelType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFuelTypeRequest $request, FuelType $fuelType): RedirectResponse
    {
        $fuelType->update($request->validated());

        return redirect()->route('manager.fuel-types.index')->with('success', 'Fuel type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelType $fuelType): RedirectResponse
    {
        $fuelType->delete();

        return redirect()->route('manager.fuel-types.index')->with('success', 'Fuel type deleted successfully.');
    }
}
