<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockMovementRequest;
use App\Models\FuelType;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $movements = StockMovement::with('fuel')
            ->when($request->fuel_id, fn ($query, $fuelId) => $query->where('fuel_id', $fuelId))
            ->when($request->movement_type, fn ($query, $type) => $query->where('movement_type', $type))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('manager.stock.index', [
            'movements' => $movements,
            'fuels' => FuelType::orderBy('fuel_name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('manager.stock.create', ['fuels' => FuelType::orderBy('fuel_name')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockMovementRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $fuel = FuelType::query()->lockForUpdate()->findOrFail($data['fuel_id']);

            if ($data['movement_type'] === 'OUT' && (float) $fuel->available_quantity < (float) $data['quantity']) {
                throw ValidationException::withMessages(['quantity' => 'Stock movement exceeds available fuel quantity.']);
            }

            $data['movement_type'] === 'IN'
                ? $fuel->increment('available_quantity', $data['quantity'])
                : $fuel->decrement('available_quantity', $data['quantity']);

            StockMovement::create($data);
        });

        return redirect()->route('manager.stock.index')->with('success', 'Stock movement recorded.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stockMovement)
    {
        return redirect()->route('manager.stock.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMovement $stockMovement)
    {
        return redirect()->route('manager.stock.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockMovement $stockMovement)
    {
        return redirect()->route('manager.stock.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stockMovement): RedirectResponse
    {
        return redirect()->route('manager.stock.index')->with('error', 'Stock movements are audit records and cannot be deleted.');
    }
}
