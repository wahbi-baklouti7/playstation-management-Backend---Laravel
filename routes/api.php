<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    return 1;
    return $request->user();
});


// ===================== Begin Users Routes =====================

Route::get('/users',[UserController::class,'index']);
Route::get('/users/{phpid}',[UserController::class,'show']);
// ===================== End Users Routes =====================

Route::post('/login',[AuthenticationController::class,'login']);
Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/logout',[AuthenticationController::class ,'logout'])->middleware('auth:sanctum');

// Route::get('/', function () {

//     return 'test';
// });
