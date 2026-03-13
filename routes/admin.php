<?php

use Illuminate\Support\Facades\Route;
use Pgl\Core\Admin\Http\Controllers\DashboardController;
use Pgl\Core\Admin\Http\Controllers\MediaController;
use Pgl\Core\Admin\Http\Controllers\SettingsController;

Route::middleware('web')
    ->prefix(config('pgl-core.routing.admin_prefix', 'admin'))
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::get('/media', [MediaController::class, 'index'])->name('media.index');
        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{assetId}', [MediaController::class, 'destroy'])->name('media.destroy');
    });