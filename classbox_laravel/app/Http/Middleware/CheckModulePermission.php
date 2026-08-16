<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModulePermission
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        if ($user->isSuperAdmin() || $user->hasModuleAccess($module)) {
            return $next($request);
        }

        abort(403, 'No tienes permisos suficientes para acceder al módulo: ' . $module);
    }
}
