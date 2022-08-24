<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\Canal;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class GameController extends Controller
{

    public function createGame(Request $request)
    {
        try {
            Log::info('Creando juego');
            $name = $request->input('name');
            $category = $request->input('category');

            $newGame = new Game();
            $newGame->name = $name;
            $newGame->category = $category;
            $newGame->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Canal creado correctamente',
                    'data' => $newGame
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::info('Error al crear el juego' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => "Error al crear el juego"

                ],
                500
            );
        }
    }
    public function deleteGameById($id)
    {
        try {
            Log::info('borrando juego');
            $game = Game::query()->find($id);
            $game->delete();

            return response()->json([
                'success' => true,
                'message' => "Juego borrado",
            ]);
        } catch (\Exception $exception) {
            Log::info('Error al borrar juego' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => "Error al borrar juego"

                ],
                500
            );
        }
    }
    public function getGameById($id)
    {
        try {
            Log::info('obteniendo juego por id');
            $game = Game::query()->find($id)->get(); 


            if(!$game){
                return response()->json([
                    'success' => true,
                    'message' => "juego no encontrado",
                ],
                404
            );
            }
            
            return response()->json([
                'success' => true,
                'message' => "Juego recuperado con éxito",
                'data' => $game
            ]);
        } catch (\Exception $exception) {
            Log::info('Error al recuperar juego' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => "Error al recuperar juego"

                ],
                500
            );
        }
    }
    public function addUserToGame($id)
    {

        try {
            Log::info('Uniendote al juego');

            $userId = auth()->user()->id;
            $gameId = $id;

            $user = User::query()->find($userId);
            $game = Game::query()->find($gameId);

            $user->game()->attach($game);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Felicidades te agregaste correctamente a este juego',
                    'data' => $user, $game
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error no se puede unir a este juego' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'No puedes unirte a este juego.',
                ],
                400
            );
        }
    }

    public function deleteUserToGame($id)
    {

        try {
            Log::info('Saliendo del juego');

            $userId = auth()->user()->id;
            $gameId = $id;

            $user = User::query()->find($userId);
            $game = Game::query()->find($gameId);
            $user->game()->detach($game);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Felicidades has salido del juego',
                    'data' => $user, $game
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('El error no puede salir de este juego' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'No puedes salir de este juego.',
                ],
                400
            );
        }
    }
    public function findCanales($id)
    {
        try {
            $game = Game::query()->find($id);
            $canales = Canal::query()->where('game_id', $id)->get();

            if (count($canales) == 0) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'El juego no tiene canales'
                    ],
                    400
                );
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Estos son los canales de este juego',
                    'data' => $canales, $game
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error no puedo encontrar canales' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'No puedes encontrar canales',
                ],
                400
            );
        }
    }
}
