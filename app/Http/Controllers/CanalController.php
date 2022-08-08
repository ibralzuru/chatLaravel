<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CanalController extends Controller
{
    //

public function adUserToCanal($id){
    
    try {
     Log::info('entrando al canal');

        $userId = auth()->user()->id;
        $canalId = $id;

        $user = User::query()->find($userId);         
        $canal = Canal::query()->find($canalId);
        
        $user->canal()->attach($canal);  

        return response()->json(
        [
            'success' => true,
            'message' => 'Felicidades te agregaste correctamente a este canal',
            'data' => $user, $canal
        ], 
    200
    );

    } catch (\Exception $exception){
     Log::error('El error no puede unirse a este canal' . $exception->getMessage());

        return response()->json(
            [
                'success' => false,
                'message' => 'No puedes unirte a este canal.',
            ], 
        400
        );
    }
 }
 public function createCanal(Request $request,$id){
    try {
        
        $canalName = $request->input('name');
        $userId = auth()->user()->id;
        $gameId = $id;

        $canal = new Canal();
        $canal->name = $canalName;
        $canal->game_id = $gameId;
        $canal->user_id = $userId;
        $canal->save(); 
       Log::info("creando canal " . $canal);

        return response()->json(
            [
                'success'=> true,
                'message'=> 'Canal creado con éxito',
                'data'=> $canal,
            ],
        200
        );

    }catch (\Exception $exception){
        Log::error('Error no se puede crear un canal' . $exception->getMessage());

           return response()->json(
               [
                   'success' => false,
                   'message' => 'No puedes crear un canal.',
               ], 
           400
           );
       }
}
public function deleteUserToCanal($id){
    
    try {
     Log::info('Saliendo del canal');

        $userId = auth()->user()->id;
        $canalId = $id;

        $user = User::query()->find($userId);         
        $canal = Canal::query()->find($canalId);
        $user->canal()->detach($canal);  

        return response()->json(
        [
            'success' => true,
            'message' => 'Felicidades te vas de este canal',
            'data' => $user , $canal
        ], 
    200
    );

    } catch (\Exception $exception){
     Log::error('El error no puede salir de este canal' . $exception->getMessage());

        return response()->json(
            [
                'success' => false,
                'message' => 'No puedes salir de este canal.',
            ], 
        400
        );
    }
 }


}