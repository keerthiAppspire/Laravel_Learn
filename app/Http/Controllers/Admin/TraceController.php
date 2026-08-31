<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestTrace;
use Inertia\Inertia;
use Inertia\Response;

class TraceController extends Controller
{
    public function index(): Response
    {
        $traces = RequestTrace::query()
            ->orderByDesc('duration_ms')
            ->limit(100)
            ->get([
		'id',
                'trace_id',
                'route_name',
                'duration_ms',
                'status',
	   ]);

        return Inertia::render('Admin/Traces/Index', [
            'traces' => $traces,
        ]);
    }
}