<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FuelTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fuel_name' => $this->fuel_name,
            'price_per_liter' => $this->price_per_liter,
            'available_quantity' => $this->available_quantity,
            'description' => $this->description,
        ];
    }
}
