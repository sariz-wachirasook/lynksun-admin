<?php

use App\Http\Controllers\Api\V1\UserAuthenticationController;
use App\Http\Controllers\Api\V1\LinksController;
use App\Http\Controllers\Api\V1\LinkVisitLogsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return redirect()->route('l5-swagger.default.api');
});


Route::prefix("auth")->group(function () {
    Route::post('/login', [UserAuthenticationController::class, 'login'])->name('api.v1.auth.login');
    Route::post('/register', [UserAuthenticationController::class, 'register'])->name('api.v1.auth.register');
});

Route::prefix('links')->group(function () {
    Route::get('/', [LinksController::class, 'index'])->name('api.v1.links.index');
    Route::get('/open/{shortUrl}', [LinksController::class, 'open'])->name('api.v1.links.open');
    Route::get('/{id}/visits', [LinksController::class, 'visits'])->name('api.v1.links.visits');
    Route::get('/{id}', [LinksController::class, 'show'])->name('api.v1.links.show');
    Route::post('/', [LinksController::class, 'store'])->name('api.v1.links.store');
    Route::put('/{id}', [LinksController::class, 'update'])->name('api.v1.links.update');
    Route::delete('/{id}', [LinksController::class, 'destroy'])->name('api.v1.links.destroy');
});

Route::prefix('link-visit-logs')->group(function () {
    Route::get('/', [LinkVisitLogsController::class, 'index'])->name('api.v1.link-visit-logs.index');
    Route::get('/{id}', [LinkVisitLogsController::class, 'show'])->name('api.v1.link-visit-logs.show');
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Not Found'
    ], 404);
});
