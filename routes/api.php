<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    



