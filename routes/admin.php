<?php

use App\Http\Controllers\Admin\AdminAuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LinksController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', DashboardController::class)->name('admin.dashboard')->middleware('admin.auth');
Route::get('/dashboard/chart', [DashboardController::class, 'getChartData'])->name('admin.dashboard.chart')->middleware('admin.auth');
Route::get('/login', [AdminAuthenticationController::class, 'index'])->name('admin.login');
Route::post('/login', [AdminAuthenticationController::class, 'login'])->name('admin.login');
Route::get('/logout', [AdminAuthenticationController::class, 'logout'])->name('admin.logout');

Route::resource('links', LinksController::class)->middleware('admin.auth')->names([
    'index' => 'admin.links.index',
    'create' => 'admin.links.create',
    'store' => 'admin.links.store',
    'show' => 'admin.links.show',
    'edit' => 'admin.links.edit',
    'update' => 'admin.links.update',
    'destroy' => 'admin.links.destroy',
])->parameter('links', 'id');

Route::resource('users', UsersController::class)->middleware('admin.auth')->names([
    'index' => 'admin.users.index',
    'create' => 'admin.users.create',
    'store' => 'admin.users.store',
    'show' => 'admin.users.show',
    'edit' => 'admin.users.edit',
    'update' => 'admin.users.update',
    'destroy' => 'admin.users.destroy',
])->parameter('users', 'id');

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// fallback route
Route::fallback(function () {
    return redirect()->route('admin.dashboard');
});
