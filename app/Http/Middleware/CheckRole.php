<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Jika user belum login atau role-nya tidak sesuai, lempar error 403 (Forbidden)
        if (! Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Akses Ditolak. Halaman ini khusus '.ucfirst($role));
        }

        return $next($request);
    }
}
