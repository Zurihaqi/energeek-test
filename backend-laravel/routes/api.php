<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\CandidateController;


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

Route::post('form', [FormController::class, 'post']);
Route::get('form', [FormController::class, 'get']);

// Untuk testing
Route::get('candidate/{id}', [CandidateController::class, 'get']);
Route::delete('candidate/{id}', [CandidateController::class, 'delete']);


