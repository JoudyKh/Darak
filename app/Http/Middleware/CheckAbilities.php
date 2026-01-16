<?php

namespace App\Http\Middleware;

use App\Constants\Constants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckAbilities
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $userRole=request()->user()->role->name;
        if (! $userRole == Constants::ROLES['admin']) {
            abort(Response::HTTP_FORBIDDEN, 'Not allowed to access this route ');
        }
        return $next($request);
    }
}
