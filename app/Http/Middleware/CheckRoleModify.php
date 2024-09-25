<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class CheckRoleModify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $roleId = $request->route('id');
        $role = Role::find($roleId);
        if ($role && $role->is_system == 1) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
