<?php

use Illuminate\Support\Facades\Route;
use Pgl\Core\Storefront\Http\Controllers\HomeController;

$storefront = Route::middleware('web')->name('storefront.');
$prefix = trim((string) config('pgl-core.routing.storefront_prefix', ''), '/');

if ($prefix !== '') {
    $storefront->prefix($prefix);
}

$storefront->group(function (): void {
    Route::get('/', HomeController::class)->name('home');
});