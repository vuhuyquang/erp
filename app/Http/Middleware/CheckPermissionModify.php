<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;

class CheckPermissionModify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $permissionId = $request->route('id');
        $permission = Permission::find($permissionId);
        if ($permission && $permission->is_system == 1) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
