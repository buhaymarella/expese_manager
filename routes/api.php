<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('userRole',App\Http\Controllers\UserRoleController::class)->only(['index','store','show','update', 'destroy']);
Route::resource('expenseCategory',App\Http\Controllers\ExpenseCategoryController::class)->only(['index','store','show','update', 'destroy']);
Route::resource('users',App\Http\Controllers\UserController::class)->only(['index','store','show','update','destroy']);
Route::resource('expenses',App\Http\Controllers\ExpenseController::class)->only(['index','store','show','update','destroy']);


Route::put('users/update-password', [App\Http\Controllers\UserController::class, 'updatePassword']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);