<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\FuelSale;
use App\Models\FuelType;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('manager.reports.index', $this->reportData($request));
    }

    public function export(Request $request, string $format)
    {
        $data = $this->reportData($request);

        Report::create([
            'report_type' => $request->type ?? 'transactions',
            'generated_by' => $request->user()->id,
            'generated_at' => now(),
        ]);

        if ($format === 'pdf') {
            return Pdf::loadView('pdf.report', $data)->download('fuel-report.pdf');
        }

        $rows = $data['sales']->map(fn (FuelSale $sale) => [
            $sale->sale_date->format('Y-m-d H:i'),
            $sale->customer?->name ?? 'Walk-in customer',
            $sale->payment_method,
            $sale->status,
            number_format((float) $sale->total_amount, 2, '.', ''),
        ]);

        return Response::streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Sale Date', 'Customer', 'Payment Method', 'Status', 'Total Amount']);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 'fuel-report.csv', ['Content-Type' => 'text/csv']);
    }

    private function reportData(Request $request): array
    {
        $from = $request->date('from') ?? Carbon::now()->startOfMonth();
        $to = $request->date('to') ?? Carbon::now();
        $sales = FuelSale::with(['customer', 'details.fuel'])
            ->whereBetween('sale_date', [$from->startOfDay(), $to->endOfDay()])
            ->latest('sale_date')
            ->get();

        return [
            'from' => $from,
            'to' => $to,
            'sales' => $sales,
            'revenue' => $sales->sum('total_amount'),
            'stock' => FuelType::orderBy('fuel_name')->get(),
            'daily' => $sales->groupBy(fn ($sale) => $sale->sale_date->format('Y-m-d'))->map->sum('total_amount'),
        ];
    }
}
