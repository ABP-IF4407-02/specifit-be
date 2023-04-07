<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $req, Closure $next): Response
    {
        $data = User::where('email', $req->user()->email)->first();

        if ($data->role != 2) { 
            return ResponseFormatter::error(null, 'Unauthorized', 401);
        }
        
        return $next($req);
    }
}
