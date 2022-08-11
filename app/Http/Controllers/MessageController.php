<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function createMessage(Request $request, $id){
        try {
            
            $text = $request->input('text');
            $canalId =$id;
            $userId = auth()->user()->id;         
            $message = new Message();
            $message->text = $text;
            $message->canal_id = $canalId;
            $message->user_id = $userId;
            $message->save(); 
           
            return response()->json(
                [
                    'success'=> true,
                    'message'=> 'mensaje creado con exito',
                    'data'=> $text
                ],
            200
            );

        }catch (\Exception $exception){
            Log::error('Error no puedes crear un mensaje' . $exception->getMessage());
   
               return response()->json(
                   [
                       'success' => false,
                       'message' => 'No puedes crear un mensaje',
                   ], 
               400
               );
           }
    }

    public function seeMessage ($id){
        try {
            $canalId = $id;
            $messages = Message::query()->where('canal_id', $canalId)->get('text', 'created_at');
            $sortMessages = $messages->sortByDesc('created_at');
            $sortMessages->values()->all();


                     return response()->json(
                [
                    'success' => true,
                    'message' => 'Aqui puedes ver los mensajes',
                    'data' => $messages
                ], 
              200
            );

        }catch (\Exception $exception){
            Log::error('Error no puedes ver los mensajes' . $exception->getMessage());
   
               return response()->json(
                   [
                       'success' => false,
                       'message' => 'No puedes ver los mensajes',
                   ], 
               400
               );
           }
    }
    public function deleteMessage ($id){
        try {
            $messages = Message::query()->where('id', $id);
            $messages->delete();  
                     return response()->json(
                [
                    'success' => true,
                    'message' => 'mensaje eliminado',
                    'data' => $messages
                ], 
              200
            );

        }catch (\Exception $exception){
            Log::error('Error no puedes eliminar el mensaje' . $exception->getMessage());
   
               return response()->json(
                   [
                       'success' => false,
                       'message' => 'No puedes eliminar el mensaje',
                   ], 
               400
               );
           }
    }
    public function updateMessage(Request $request, $id){
        try {
            $userId = auth()->user()->id;
            $text  = Message::query()->where('user_id', $userId)->find($id);
            if(!$text){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'mensaje no encontrado con este ID'
                    ]
                );
            }
            $text->text= $request->input('text');
            $text->save();
            return response()->json(
            [
                "success" => true,
                "message" => 'mensaje actualizado',
                "data" => $text
            ],
        200
        );
        }catch (\Exception $exception) {
            Log::error('Error al actualizar este mensaje' .$exception->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => 'Error al actualizar mensaje',
                    "error" => $exception->getMessage()
                ],
            500
            );
        }
    }

}
