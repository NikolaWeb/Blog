<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if($user->type == config('blog.config_user_types.admin') || $user->type == config('blog.config_user_types.korisnik')) {
            return $next($request);
        }
        abort(response()->json(["errors" => "Nemate pravo pristupa."], Response::HTTP_FORBIDDEN));
    }
}
