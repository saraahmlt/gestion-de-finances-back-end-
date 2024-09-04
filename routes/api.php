<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::group(['prefix' => '/v1'], function(){

Route::get('/transactions', ApiTransactionsController::class . '@index')->middleware('auth:sanctum')->name('index.transactions');
Route::post('/transactions', ApiTransactionsController::class . '@store')->middleware('auth:sanctum')->name('store.transactions');
Route::get('/transactions/{id}', ApiTransactionsController::class . '@show')->middleware('auth:sanctum')->name('show.transactions');
Route::put('/transactions/{id}/edit', ApiTransactionsController::class . '@update')->middleware('auth:sanctum')->name('update.transactions');
Route::delete('/transactions/{id}/edit', ApiTransactionsController::class . '@destroy')->middleware('auth:sanctum')->name('destroy.transactions');

Route::post('/login', [UsersController::class, 'login'])->name('users.login');
Route::post('/register', [UsersController::class, 'register'])->name('users.register');

});