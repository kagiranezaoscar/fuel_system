<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\FuelSale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Request $request, FuelSale $sale)
    {
        abort_if($sale->customer_id !== $request->user()->id && ! $request->user()->isManager(), 403);

        return Pdf::loadView('pdf.invoice', ['sale' => $sale->load(['customer', 'details.fuel'])])
            ->download('invoice-'.$sale->id.'.pdf');
    }
}
