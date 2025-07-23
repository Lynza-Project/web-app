<?php

use App\Http\Controllers\ActualityController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\EventController;
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
    Route::get('users/import', App\Livewire\Users\ImportPage::class)->name('users.import');

    Route::get('actualities', [ActualityController::class, 'index'])->name('actualities.index');
    Route::get('actualities/create', [ActualityController::class, 'create'])->name('actualities.create');
    Route::get('actualities/{actuality}', [ActualityController::class, 'show'])->name('actualities.show');
    Route::get('actualities/{actuality}/edit', [ActualityController::class, 'edit'])->name('actualities.edit');
    Route::put('actualities/{actuality}', [ActualityController::class, 'update'])->name('actualities.update');
    Route::delete('actualities/{actuality}', [ActualityController::class, 'destroy'])->name('actualities.destroy');

    Route::get('events', [EventController::class, 'index'])->name('events.index');
    Route::get('events/create', [EventController::class, 'create'])->name('events.create');
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('documentations', [DocumentationController::class, 'index'])->name('documentations.index');
    Route::get('documentations/create', [DocumentationController::class, 'create'])->name('documentations.create');
    Route::get('documentations/{documentation}', [DocumentationController::class, 'show'])->name('documentations.show');
    Route::get('documentations/{documentation}/edit', [DocumentationController::class, 'edit'])->name('documentations.edit');
    Route::put('documentations/{documentation}', [DocumentationController::class, 'update'])->name('documentations.update');
    Route::delete('documentations/{documentation}', [DocumentationController::class, 'destroy'])->name('documentations.destroy');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Theme management routes
    Route::get('themes', App\Livewire\Themes::class)->name('themes.index');
});

require __DIR__.'/auth.php';
