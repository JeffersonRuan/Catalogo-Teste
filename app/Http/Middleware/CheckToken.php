<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Token;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        $token = $request->bearerToken();

        if(!$token || !Token::where('token', hash('sha256', $token))->exists()){
            return response()->json(['message'=> 'Unauthorized'], 401);
        }
        
        return $next($request);
    }
}
