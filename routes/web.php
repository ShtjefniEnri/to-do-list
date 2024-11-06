<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::controller(TodoController::class)->group(function () {
    Route::name('todo.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{todo}', 'edit')->name('edit');
        Route::put('/update/{todo}', 'update')->name('update');
        Route::delete('/destroy/{todo}', 'destroy')->name('destroy');
    });
});
