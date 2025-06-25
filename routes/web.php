<?php

use App\Http\Controllers\TwoFactorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/manual-logout', function () {
    auth()->logout();
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('settings/password', function () {
        return Inertia::render('Profile/Password');
    })->name('password.edit');

    Route::get('settings/appearance', function () {
        return Inertia::render('Profile/Appearance');
    })->name('appearance');

    // Two-factor authentication route - only if feature is enabled
    if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm')) {
        Route::get('settings/two-factor', [TwoFactorController::class, 'show'])->name('two-factor');
    }
});
