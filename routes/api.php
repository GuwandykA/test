<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GiftController;

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

//получение списка пользователей
Route::get('/v1/users', [UserController::class, 'users']);
//получение конкретного пользователя
Route::get('/v1/user/{id}', [UserController::class, 'user'])->where('id', '[0-9]+');
//добавление пользователя
Route::post('/v1/users', [UserController::class, 'store']);
//добавление подарка
Route::post('/v1/gift', [GiftController::class, 'store']);
//удаление подарка
Route::post('/v1/gift/{id}', [GiftController::class, 'destroy'])->where('id', '[0-9]+');


//============================================================================
Route::get('/v1/data/{name?}', [UserController::class, 'data']);