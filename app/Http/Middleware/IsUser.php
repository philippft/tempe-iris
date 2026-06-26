<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->role == 'mahasiswa') {

            if (is_null(Auth::user()->verify_at)) {

                if ($request->routeIs('user.detail-akun') || $request->routeIs('user.detail-akun.update') || $request->routeIs('logout')) {
                    return $next($request);
                }

                return redirect()->route('user.detail-akun', Auth::user()->id);
            }

            return $next($request); 
        }
        abort(404);
    }
}
