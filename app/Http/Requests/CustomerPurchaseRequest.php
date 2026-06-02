<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerPurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_method' => ['required', 'in:cash,card,mobile_money,bank_transfer'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.fuel_id' => ['required', 'exists:fuel_types,id'],
            'items.*.liters' => ['required', 'numeric', 'min:0.001'],
        ];
    }
}
