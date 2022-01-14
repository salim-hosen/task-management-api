<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\User\MeController;
use App\Http\Controllers\WorksheetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Auth::routes(['register' => false]);
Route::post('verification/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('verification/resend', [VerificationController::class, 'resend']);

Route::get("me", [MeController::class, 'getMe']);

Route::resource("projects", ProjectController::class);
Route::get("project-tasks/{project_id}", [ProjectController::class, 'tasks']);

Route::resource("tasks", TaskController::class);
Route::resource("worksheets", WorksheetController::class);
