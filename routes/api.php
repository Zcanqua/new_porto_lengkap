<?php

use App\Http\Controllers\Api\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::prefix('portfolio')->group(function () {
    Route::post('/messages', [PortfolioController::class, 'storeMessage'])
        ->middleware('throttle:5,1');
});
