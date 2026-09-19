<?php

use App\Http\Controllers\Admin\TraceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Services\RequestCounter;
use App\Http\Controllers\EmployeeOnboardingController;
use App\Http\Controllers\ProjectController;



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
Route::get('/announcements',function(){
    return 'all announcements';
});
Route::get('/announcements/{announcement}',function($announcement){
    return "Announcement:".$announcement;
});
Route::post('/announcements', function(){
    return 'new announcement is created';
});
Route::patch('/announcements/{announcement}',function($announcement){
    return "Announcement {$announcement} is updated";
});
Route::delete('/announcements/{announcement}',function($announcement){
    return "announcement {$announcement} is deleted";
});
Route::get('/invoices/{invoice}', function ($invoice) {
    logger("Invoice route reached: {$invoice}");

    return "Invoice: {$invoice}";
})->where('invoice', 'INV-[0-9]{4}-[0-9]{6}');
Route::get('/employees/{employee}', function ($employee) {
    return "Employee: {$employee}";
})->whereNumber('employee');

Route::get('/employees', function () {
    return 'Employees page';
})->name('employees.index');

Route::get('/departments', function () {
    return 'Departments page';
})->name('departments.index');

Route::get('/attendance-reports', function () {
    return 'Reports page';
})->name('reports.index');

Route::get('/navigation', function () {
    return view('navigation');
});

Route::get('/payslips/{payslip}/download', function ($payslip) {
    return "Downloading payslip: {$payslip}";
})->name('payslips.download')->middleware('signed');

Route::get('/cache-test', function () {
    return 'Cache test';
});

Route::resource('projects', ProjectController::class);