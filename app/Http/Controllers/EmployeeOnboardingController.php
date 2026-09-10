<?php

namespace App\Http\Controllers;
use App\Services\EmployeeOnboardingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeOnboardingController extends Controller
{
     public function onboard(
        Request $request,
        EmployeeOnboardingService $service
    ): JsonResponse {
        $employee = $request->only([
            'name',
            'email',
        ]);

        $service->onboard($employee);

        return response()->json([
            'message' => 'Employee onboarded',
        ]);
    }

}
