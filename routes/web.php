<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::controller(TodoController::class)->group(function () {
    Route::name('todo.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{todo}', 'update')->name('update');
        Route::delete('/destroy/{todo}', 'destroy')->name('destroy');
    });
});
