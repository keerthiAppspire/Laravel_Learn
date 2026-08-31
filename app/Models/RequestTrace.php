<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestTrace extends Model
{
    protected $fillable = [
        'trace_id',
        'route_name',
        'user_id',
        'tenant_id',
        'duration_ms',
        'peak_memory_bytes',
        'status',
    ];
}
