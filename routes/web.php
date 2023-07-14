<?php

use App\Http\Controllers\AdminAuthenticationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

Route::get('switch-language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('switch-language');

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// fallback route
Route::fallback(function () {
    return redirect()->route('admin.dashboard');
});
