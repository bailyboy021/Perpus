<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     // return $next($request);
    //     return back()->with('error','Opps, Anda tidak memiliki akses untuk halaman tersebut');
    // }

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah login
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Periksa apakah peran user sesuai dengan yang diperbolehkan
        if (!in_array($request->user()->role->role_name, $roles)) {
            // return response()->json(['message' => 'Forbidden'], 403);
            // abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            // return redirect('/403')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            // return back()->with('error','Opps, Anda tidak memiliki akses untuk halaman tersebut');
            return back()->with('error', 'Opps, Anda tidak memiliki akses untuk halaman tersebut!');
        }

        return $next($request);
    }

}
