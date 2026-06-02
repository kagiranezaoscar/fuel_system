<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFuelTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isManager() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $fuelType = $this->route('fuel_type') ?? $this->route('fuelType');

        return [
            'fuel_name' => ['required', 'string', 'max:255', 'unique:fuel_types,fuel_name,'.($fuelType?->id ?? 'NULL')],
            'price_per_liter' => ['required', 'numeric', 'min:0'],
            'available_quantity' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
