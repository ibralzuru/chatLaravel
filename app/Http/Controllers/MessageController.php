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
                    'message'=> 'message successfully created',
                    'data'=> $text
                ],
            200
            );

        }catch (\Exception $exception){
            Log::error('Error cant this message ' . $exception->getMessage());
   
               return response()->json(
                   [
                       'success' => false,
                       'message' => 'You cant create a message',
                   ], 
               400
               );
           }
    }
}
