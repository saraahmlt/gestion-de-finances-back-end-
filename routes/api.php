<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;

Route::group(['prefix' => 'v1'], function () {

    Route::get('/transactions', [TransactionsController::class, 'index'])->middleware('auth:sanctum')->name('index.transactions');
    Route::post('/transactions', [TransactionsController::class, 'store'])->middleware('auth:sanctum')->name('store.transactions');
    Route::get('/transactions/{id}', [TransactionsController::class, 'show'])->middleware('auth:sanctum')->name('show.transactions');
    Route::put('/transactions/{id}', [TransactionsController::class, 'update'])->middleware('auth:sanctum')->name('update.transactions');
    Route::delete('/transactions/{id}', [TransactionsController::class, 'destroy'])->middleware('auth:sanctum')->name('destroy.transactions');

    Route::post('/login', [UsersController::class, 'login'])->name('users.login');
    Route::post('/register', [UsersController::class, 'register'])->name('users.register');
});
