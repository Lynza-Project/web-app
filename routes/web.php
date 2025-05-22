<?php

use App\Http\Controllers\ActualityController;
use App\Http\Controllers\UserController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(static function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('actualities', [ActualityController::class, 'index'])->name('actualities.index');
    Route::get('actualities/{actuality}', [ActualityController::class, 'show'])->name('actualities.show');
    Route::get('actualities/{actuality}/edit', [ActualityController::class, 'edit'])->name('actualities.edit');
    Route::put('actualities/{actuality}', [ActualityController::class, 'update'])->name('actualities.update');
    Route::delete('actualities/{actuality}', [ActualityController::class, 'destroy'])->name('actualities.destroy');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
