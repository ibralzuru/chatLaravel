<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    const ADMIN_ROLE = 11;

    public function addAdmin($id){

        try {

            $user= User::query()->find($id);

            $user->roles()->attach(self::ADMIN_ROLE);

            return response()->json([
                'success' => true,
                'message' => "Rol superAdmin activado"
            ]);

        } catch(\Exception $exception){

            Log::error('Error al cambiar rol'. $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error al cambiar rol'
                    
                ],
            404
            );
        };

    }

    public function deleteAdmin($id){

        try {

            $user= User::query()->find($id);

            $user->roles()->detach(self::ADMIN_ROLE);

            return response()->json([
                'success' => true,
                'message' => "Rol superAdmin desechado",
            ]);

        } catch(\Exception $exception){

            Log::error('Error al cambiar rol'. $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error al cambiar rol'
                    
                ],
            404
            );
        };

    }
}