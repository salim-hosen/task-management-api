<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\User\MeController;
use App\Http\Controllers\User\UserController;
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
Route::post("profile", [MeController::class, 'updateProfile']);
Route::get("dashboard", [HomeController::class, 'index']);

Route::resource("projects", ProjectController::class);
Route::get("project-tasks/{id}", [ProjectController::class, 'tasks']);
Route::get("project-dashboard/{id}", [ProjectController::class, 'dashboard']);

Route::resource("tasks", TaskController::class);
Route::resource("worksheets", WorksheetController::class);
Route::resource("users", UserController::class);
