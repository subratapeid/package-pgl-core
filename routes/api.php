<?php

use Illuminate\Support\Facades\Route;
use Pgl\Core\Api\Http\Controllers\SystemStatusController;

Route::prefix(config('pgl-core.routing.api_prefix', 'api').'/'.config('pgl-core.routing.api_version', 'v1'))
    ->middleware('api')
    ->name('api.'.config('pgl-core.routing.api_version', 'v1').'.')
    ->group(function (): void {
        Route::get('/status', SystemStatusController::class)->name('status');
    });