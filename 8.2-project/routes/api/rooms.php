<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::prefix('rooms')
    ->middleware(['auth:api'])
    ->group(function () {
        Route::get('', [RoomController::class, 'index'])->name('rooms.index');
        Route::resource('', RoomController::class)
            ->only(['show', 'destroy', 'edit', 'update'])
            ->parameters(["" => "id"])
            ->middleware(['role:Admin']);
        
        Route::resource('', RoomController::class)
            ->only(['index', 'store']);
    });