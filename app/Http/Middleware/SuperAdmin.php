<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // L'utilisateur n'est pas authentifié, redirigez-le vers la page de connexion
            return redirect('/login');
        }
        if(auth()){
            $roles = auth()->user()->roles;
            foreach ($roles as $key => $role) {
                if($role->role_name == "SUPER ADMIN" || $role->role_uuid == "bfed2c96-a9bd-4c07-91cb-b75b3c1046f0"){
                    return $next($request);
                }
            }
        }
        // return response()->json(['message' => 'Acces denie'], 401);
        // return redirect("/access-denie");
        return $next($request);
    }
}
