<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::alert("SuperAdmin middleware");
        
        $userId = auth()->user()->id;
        $user = User::find($userId);

        $hasRole = $user->roles->contains(2);
        
        if(!$hasRole){
            return response()->json(
                [
                    "success"=> true,
                    "message"=> "no tienes permisos"

                ],
                400
            );
        }
        return $next($request);
    }
}