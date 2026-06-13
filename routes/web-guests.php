<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

Route::prefix('guests')->group(function () {

    Route::get('/', [GuestController::class, 'index']);
    Route::get('/create', [GuestController::class, 'create']);

});

