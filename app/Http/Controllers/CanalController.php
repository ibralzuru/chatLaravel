<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CanalController extends Controller
{
    //

public function adUserToCanal($id){
    
    try {
     Log::info('entrando a la party');

        $userId = auth()->user()->id;
        $canalId = $id;

        $user = User::query()->find($userId);         
        $party = Canal::query()->find($canalId);
        
        $user->canal()->attach($canal);  

        return response()->json(
        [
            'success' => true,
            'message' => 'Congrats you added correctly to this canal',
            'data' => $user, $canal
        ], 
    200
    );

    } catch (\Exception $exception){
     Log::error('Error cant joing to this canal' . $exception->getMessage());

        return response()->json(
            [
                'success' => false,
                'message' => 'You cant joing to this canal',
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
                'message'=> 'Canal successfully created',
                'data'=> $canal,
            ],
        200
        );

    }catch (\Exception $exception){
        Log::error('Error cant create a canal' . $exception->getMessage());

           return response()->json(
               [
                   'success' => false,
                   'message' => 'You cant create a canal',
               ], 
           400
           );
       }
}
public function deleteUserToCanal($id){
    
    try {
     Log::info('Saliendo de la canal');

        $userId = auth()->user()->id;
        $canalId = $id;

        $user = User::query()->find($userId);         
        $canal = Canal::query()->find($canalId);
       //$asoc_existe = DB::table('party_user')->where('party_id', $partyId)->value('id');
        Log::info('asco ' . $asoc_existe);

        //if(!$asoc_existe){
          //  return response()->json(
              //  [
            //        'success' => false,
              //      'message' => 'User is not added to this party'                        
              //  ], 
           // 400
           // );
        //}
        
        $user->canal()->detach($canal);  

        return response()->json(
        [
            'success' => true,
            'message' => 'Congrats you leave from this canal',
            'data' => $user , $canal
        ], 
    200
    );

    } catch (\Exception $exception){
     Log::error('Error cant leave from this canal' . $exception->getMessage());

        return response()->json(
            [
                'success' => false,
                'message' => 'You cant leave from this canal',
            ], 
        400
        );
    }
 }


}