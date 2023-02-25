<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\QuestionController;
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

// Public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    // Only admin
    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('/users', [UserController::class, 'getAllUser']);
        Route::resource('/questions', QuestionController::class)->except('create', 'edit');
    });

    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });


    Route::post('/logout', [AuthController::class, 'logout']);
});
