<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        abort_if(! $request->user()->isManager(), 403);

        return ReportResource::collection(Report::with('generatedBy')->latest('generated_at')->paginate(20));
    }
}
