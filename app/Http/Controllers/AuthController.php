<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:25',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|max:25|regex:/[#$%^&*()+=!?¿.,:;]/i',
                ]
            );

            if ($validator->fails()) {
                return response()->json(

                    [
                        'success' => true,
                        'message' => $validator->errors()
                    ],
                    400
                );
            }

            $user = User::create(
                [
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->password)
                ]
            );

            $user->roles()->attach(1);

            $token = JWTAuth::fromUser($user);
            return response()->json(compact('user', 'token'), 201);
        } catch (\Exception $exception) {
            Log::error('Error al crear usuario' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error al crear usuario'

                ],
                404
            );
        };
    }

    public function login(Request $request)
    {

        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Correo electrónico o contraseña no válidos',
                ], //Response::HTTP_UNAUTHORIZED
            );
        }
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }
    public function logout(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'token' => 'require'
                ]
            );
            JWTAuth::invalidate($request->token);
            return response()->json(
                [
                    'success' => true,
                    'token' => 'Has terminado tu sesion satisfactoriamente'
                ]
            );
        } catch (\Exception $exception) {
            return response()->json(
                [
                    'succes' => false,
                    'messege' => 'no puedes cerrar sesión'

                ],
                404
            );
        }
    }

    public function profile()
    {
        return response()->json(
            [
                "susccess" => true,
                "data" => auth()->user()
            ]
        );
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::query()->find($id);


            $name = $request->input('name');
            $email = $request->input('email');

            if (isset($name)) {
                $user->name = $name;
                $user->email = $email;
            }

            $user->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'has modificado tu perfil con éxito'

                ],
                200
            );
        } catch (\Exception $exception) {

            return response()->json(
                [
                    'success' => false,
                    'message' => 'no puedes modificar tu perfil'

                ],
                404
            );
        }
    }
}
