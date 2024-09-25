<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckUserModify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAdmin = Auth::user()->is_system;
        $userId = $request->route('id');
        $user = User::find($userId);

        if ($user && $user->is_system === 1 && $isAdmin === 0) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
