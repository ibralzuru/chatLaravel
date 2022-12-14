<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CanalController extends Controller
{
    //
    public function addUserToCanal($id)
    {
        try {
            Log::info('entrando al canal');

            $userId = auth()->user()->id;
            $user = User::query()->find($userId);
            $user->canal()->attach($id);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Felicidades te agregaste correctamente a este canal',
                    'data' => $user, $id
                ],
                200
            );
        } catch (\Exception $exception) {
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
    public function createCanal(Request $request, $id)
    {
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
                    'success' => true,
                    'message' => 'Canal creado con éxito',
                    'data' => $canal,
                ],
                200
            );
        } catch (\Exception $exception) {
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
    public function deleteUserToCanal($id)
    {
        try {
            Log::info('Saliendo del canal');

            $userId = auth()->user()->id;
            $user = User::query()->find($userId);
            $user->canal()->detach($id);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Felicidades te vas de este canal',
                    'data' => $user, $id
                ],
                200
            );
        } catch (\Exception $exception) {
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
    public function deleteCanal($id)
    {
        try {
            Log::info('Borrar Canal');
            $canal = Canal::query()->find($id);

            $canal->delete();
            return response()->json([
                'success' => true,
                'message' => "canal borrado correctamente",
            ]);
        } catch (\Throwable $exception) {
            Log::info('Error al borrar canal' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => "Error al borrar canal"
                ],
                500
            );
        }
    }

    public function updateCanal($id, Request $request)
    {
        try {
            Log::info('Actualizando canal');
            $canal = Canal::find($id);
            $validator = Validator::make($request->all(), [
                'name' => 'string',
            ]);
            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors()
                    ],
                    400
                );
            };

            if ($request->input('name')) {
                $canal->name = $request->input('name');
            };

            $canal->save();
            return response()->json(
                [
                    'success' => true,
                    'message' => "canal actualizado con exito",
                    'data' => $canal

                ],
                200
            );
        } catch (\Exception $exception) {
            Log::info('Error al actualizar canal' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => "Error actualizando el canal"

                ],
                500
            );
        }
    }
}
