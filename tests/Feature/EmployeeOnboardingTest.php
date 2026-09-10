<?php

use App\Services\EmployeeOnboardingService;
use App\Services\FakeDirectorySync;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

test('onboarding sends employee to fake directory sync', function () {
    $fake = new FakeDirectorySync();

    $this->swap(
        \App\Contracts\DirectorySync::class,
        $fake
    );

    $response = $this->postJson('/employees/onboard', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $response->assertOk();

    expect($fake->employees)->toContain([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});