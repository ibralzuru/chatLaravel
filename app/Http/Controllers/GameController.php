<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                'message' => 'Congrats you added correctly to this game',
                'data' => $user , $game
            ], 
        200
        );
 
        } catch (\Exception $exception){
         Log::error('Error cant joing to this game' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'You cant joing to this game',
                ], 
            400
            );
        }
     } 

     public function deleteUserToGame($id){
    
        try {
         Log::info('Saliendo del game');

            $userId = auth()->user()->id;
            $gameId = $id;
 
            $user = User::query()->find($userId);         
            $game = Game::query()->find($gameId);     
            $user->game()->detach($game);  

            return response()->json(
            [
                'success' => true,
                'message' => 'Congrats you leave from this game',
                'data' => $user , $game
            ], 
        200
        );
 
        } catch (\Exception $exception){
         Log::error('Error cant leave from this game' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'You cant leave from this game',
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
                        'message' => 'Game have no canales'                        
                    ], 
                400
                );
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => 'This are the canales from this game',
                    'data' => $canales , $game
                ], 
            200
            );

        } catch (\Exception $exception){
            Log::error('Error cant find canales' . $exception->getMessage());
   
               return response()->json(
                   [
                       'success' => false,
                       'message' => 'You cant find canales',
                   ], 
               400
               );
        }
    }
}
