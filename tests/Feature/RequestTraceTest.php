<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestTraceTest extends TestCase
{
    use RefreshDatabase;

    public function test_request_has_trace_headers(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Trace-Id');
        $response->assertHeader('X-Duration-Ms');
    }

    public function test_trace_row_is_created(): void
    {
        $this->get('/');
        $this->assertDatabaseHas('request_traces', [
            'status' => 200,
        ]);
    }

    public function test_admin_can_view_traces(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this
            ->actingAs($admin)
            ->get('/admin/traces');

        $response->assertStatus(200);
    }

    public function test_non_admin_gets_403(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/admin/traces');

        $response->assertStatus(403);
    }
}
