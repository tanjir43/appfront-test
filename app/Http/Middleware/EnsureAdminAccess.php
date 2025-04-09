<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$this->isAdmin(Auth::user())) {
            abort(403, 'Unauthorized action. Admin access required.');
        }

        return $next($request);
    }

    protected function isAdmin($user): bool
    {
        return $user->email === 'test@example.com';
    }
}
