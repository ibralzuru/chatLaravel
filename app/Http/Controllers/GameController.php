<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use App\Models\Canal;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function addUserToGame($id){
    
        try {
         Log::info('Uniendote al game');

            $userId = auth()->user()->id;
            $gameId = $id;
 
            $user = User::query()->find($userId);         
            $game = Game::query()->find($gameId);
            
            $user->game()->attach($game);  

            return response()->json(
            [
                'success' => true,
                'message' => 'Felicidades te agregaste correctamente a este juego',
                'data' => $user , $game
            ], 
        200
        );
 
        } catch (\Exception $exception){
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

     public function deleteUserToGame($id){
    
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
                'data' => $user , $game
            ], 
        200
        );
 
        } catch (\Exception $exception){
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
     public function findCanales($id){

        try {
            $game = Game::query()->find($id);
            $canales = Canal::query()->where('game_id', $id)->get();

            if(count($canales) == 0 ){
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
                    'data' => $canales , $game
                ], 
            200
            );

        } catch (\Exception $exception){
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