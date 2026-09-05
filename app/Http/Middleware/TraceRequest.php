<?php

namespace App\Http\Middleware;

use App\Jobs\StoreRequestTrace;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TraceRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $traceId = (string) Str::uuid();
        $start = microtime(true);
        Log::withContext([
            'trace_id' => $traceId,
        ]);

        $response = $next($request);

        $duration = microtime(true) - $start;
        $durationMs = round($duration * 1000, 2);
        $peakMemory = memory_get_peak_usage(true);

        $request->attributes->set('trace_id', $traceId);
        $request->attributes->set('duration', $duration);
        $request->attributes->set('peak_memory', $peakMemory);

        Log::info('Request metrics', [
            'trace_id' => $traceId,
            'duration_ms' => $durationMs,
            'peak_memory_bytes' => $peakMemory,
        ]);

        $response->headers->set('X-Trace-Id', $traceId);
        $response->headers->set('X-Duration-Ms', (string) $durationMs);

        return $response;
    }

    public function terminate(
        Request $request,
        Response $response
    ): void {
        StoreRequestTrace::dispatch([
            'trace_id' => $request->attributes->get('trace_id'),
            'route_name' => $request->route()?->getName(),
            'user_id' => $request->user()?->id,
            'tenant_id' => null,
            'duration_ms' => round(
                $request->attributes->get('duration') * 1000,
                2
            ),
            'peak_memory_bytes' => $request->attributes->get('peak_memory'),
            'status' => $response->getStatusCode(),
        ]);
    }
}
