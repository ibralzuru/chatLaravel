<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CanalController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(
    ['middleware' => 'jwt.auth'],
    function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::put('/profile/config/{id}', [AuthController::class, 'update']);
    }
);
Route::group(
    ['middleware' => 'jwt.auth'],
    function () {
        Route::post('/addUserToCanal/{id}', [CanalController::class, 'addUserToCanal']);
        Route::delete('/deleteUserToCanal/{id}', [CanalController::class, 'deleteUserToCanal']);
        Route::post('/createCanal/{id}', [CanalController::class, 'createCanal']);
        Route::delete('/deleteCanal/{id}', [CanalController::class, 'deleteCanal']);
        Route::put('/updateCanal/{id}',  [CanalController::class, 'updateCanal']);
    }
);
Route::group(
    ['middleware' => 'jwt.auth'],
    function () {
        Route::post('/addUserToGame/{id}', [GameController::class, 'addUserToGame']);
        Route::delete('/deleteUserToGame/{id}', [GameController::class, 'deleteUserToGame']);
        Route::get('/getCanals/{id}', [GameController::class, 'findCanales']);
    }
);
Route::group(
    ['middleware' => 'jwt.auth'],
    function () {
        Route::post('/createMessage/{id}', [MessageController::class, 'createMessage']);
        Route::get('/seeMessage/{id}', [MessageController::class, 'seeMessage']);
        Route::delete('/deleteMessage/{id}', [MessageController::class, 'deleteMessage']);
        Route::put('/updateMessage/{id}', [MessageController::class, 'updateMessage']);
    }
);
Route::group(
    ['middleware' => ['jwt.auth', 'superAdmin']],
    function () {
        Route::post('/addAdmin/{id}', [UserController::class, 'addAdmin']);
        Route::post('/deleteAdmin/{id}', [UserController::class, 'deleteAdmin']);
    }
);
