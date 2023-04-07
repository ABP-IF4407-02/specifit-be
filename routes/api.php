<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TipController;
use App\Http\Controllers\API\WorkoutController;
use App\Http\Controllers\API\WorkoutProgramController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    
    Route::middleware('adminonly')->group(function() {
        Route::post('tips', [TipController::class, 'create']);
        Route::post('tips/edit/{id}', [TipController::class, 'edit']); // can't use PUT/PATCH in laravel somehow??
        Route::delete('tips/edit/{id}', [TipController::class, 'delete']); 

        Route::post('workout', [WorkoutController::class, 'create']);
        Route::post('workout/{id}', [WorkoutController::class, 'edit']);
        Route::delete('workout/{id}', [WorkoutController::class, 'delete']);

        Route::post('workoutprogram', [WorkoutProgramController::class, 'create']);
        Route::post('workoutprogram/{id}', [WorkoutProgramController::class, 'edit']);
        Route::delete('workoutprogram/{id}', [WorkoutProgramController::class, 'delete']);
    });

    Route::post('image', [Controller::class, 'getImage']);

    Route::get('user', [UserController::class, 'get']); // get logged-in user data
    Route::post('user/edit', [UserController::class, 'edit']); 

    Route::get('tips', [TipController::class, 'getAll']);
    Route::get('tips/{id}', [TipController::class, 'getById']);
    
    Route::get('workout/{id}', [WorkoutController::class, 'getById']);
    Route::get('workout', [WorkoutController::class, 'getAll']);

    Route::get('workoutprogram/{id}', [WorkoutProgramController::class, 'getById']);
    Route::get('workoutprogram', [WorkoutProgramController::class, 'getAll']);
});