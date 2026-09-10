<?php

use App\Http\Controllers\Admin\TraceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Services\RequestCounter;
use App\Http\Controllers\EmployeeOnboardingController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

Route::get('/admin/traces', [TraceController::class, 'index'])
    ->middleware(AdminMiddleware::class)
    ->name('admin.traces.index');
//lifetimes lab
Route:: get('/test_lifetimes', function() {
    $bind1=app('counter.bind');
    $bind2=app('counter.bind');
    
    $singleton1=app('counter.singleton');
    $singleton2=app('counter.singleton');

    $scoped1=app('counter.scoped');
    $scoped2=app('counter.scoped');

    return[
        'bind'=>[
            spl_object_id($bind1),
            spl_object_id($bind2),
        ],
        'singleton'=>[                   
            spl_object_id($singleton1),
            spl_object_id($singleton2),
        ],
        'scoped'=>[
            spl_object_id($scoped1),
            spl_object_id($scoped2),
        ],
    ];
});
Route::get('/text_contextual',function(){
    $payroll=app(App\Services\PayrollAuditExport::class);
    $headcount=app(App\Services\HeadcountExport::class);
    return[
        'payroll_class'=>get_class($payroll),
        
        'headcount_class'=>get_class($headcount),
        
    ];
});
Route::post('/employees/onboard', [
    EmployeeOnboardingController::class,
    'onboard',
]);
