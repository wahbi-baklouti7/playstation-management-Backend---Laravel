<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\SessionController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ===================== Begin Users Routes =====================
Route::apiResource('/users',UserController::class);
// ===================== End Users Routes =====================

// ===================== Begin Devices Routes =====================
Route::apiResource('/devices',DeviceController::class);
// ===================== End Devices Routes =====================
// ===================== Begin Games Routes =====================
Route::apiResource('/games',GameController::class);
// ===================== End Games Routes =====================

// ===================== Begin Sessions Routes =====================
// Route::get('sessions/gamess',[SessionController::class,'getGameSessionsCount']);

Route::get('/sessions/user/{user}',[SessionController::class,'getUserSessions']);
Route::get('/sessions/device/{device}',[SessionController::class,'getDeviceSessions']);
Route::get('/sessions/game/{game}',[SessionController::class,'getGameSessions']);
Route::get('/sessions/game-counts',[SessionController::class,'getGameSessionsCount']);
Route::get('/sessions/device-total-amount',[SessionController::class,'getTotalAmountByDevice']);
Route::get('/sessions/game-total-amount',[SessionController::class,'getTotalAmountByGame']);
// Route::get('/sessions/game-counts',[SessionController::class,'getSessionsByDate']);
Route::apiResource('/sessions',SessionController::class);
// ===================== End Sessions Routes =====================

// ===================== Begin Authentication Routes =====================
Route::post('/login',[AuthenticationController::class,'login']);
Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/logout',[AuthenticationController::class ,'logout'])->middleware('auth:sanctum');
// ===================== End Authentication Routes =====================
