<?php

namespace App\Http\Middleware;

use App\Models\EventOrganizer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Panitia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $npm = Auth::user()->npm;
            $organiser = EventOrganizer::where('npm', $npm)->first();

            if (auth::user()->name === 'admin' || auth::user()->name === 'root') {
                return $next($request);
            }

            if (!$organiser) {
                return response()->json(['error' => 'Must be panitia'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
