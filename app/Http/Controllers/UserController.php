<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    const SUPER_ADMIN_ROLE = 3;

    public function adSuperAdmin($id){

        try {

            $user= User::query()->find($id);

            $user->roles()->attach(self::SUPER_ADMIN_ROLE);

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

    public function deleteSuperAdmin($id){

        try {

            $user= User::query()->find($id);

            $user->roles()->detach(self::SUPER_ADMIN_ROLE);

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