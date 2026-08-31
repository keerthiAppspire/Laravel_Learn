<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\TraceController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
