<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CanalController;
use App\Http\Controllers\GameController;

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

Route::get('/', function () {
    return 'Bienvenido a mi app';
});

Route::post('/register', [AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::group(
    ['middleware' => 'jwt.auth'],
        function(){
            Route::get('/profile', [AuthController::class, 'profile']);
            Route::get('/logout', [AuthController::class, 'logout']);
            Route::put('/profile/config/{id}', [AuthController::class, 'update']);
            // Route::get();
        }
);
Route::group(
    ['middleware' => 'jwt.auth'],
        function(){
            Route::post('/addUserToCanal/{id}', [CanalController::class,'adUserToCanal']);
            Route::delete('/deleteUserToCanal/{id}', [CanalController::class,'deleteUserToCanal']);
            Route::post('/createCanal/{id}', [CanalController::class,'createCanal']);
        }
);
Route::group(
    ['middleware' => 'jwt.auth'],
        function(){
            Route::post('/addUserToGame/{id}', [GameController::class,'addUserToGame']);
            Route::delete('/deleteUserToGame/{id}', [GameController::class,'deleteUserToGame']);
        }
);

    
    



