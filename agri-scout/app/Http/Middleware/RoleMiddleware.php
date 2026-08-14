<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userId = Session::get('user_id') ?? Session::get('admin_id');
        $userRole = strtolower(Session::get('user_role') ?? Session::get('admin_role') ?? '');

        if (!$userId || !$userRole) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $allowedRoles = array_map('strtolower', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden access.'], 403);
            }

            // Redirect to user's proper role-based dashboard
            switch ($userRole) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('error', 'Access denied to requested area.');
                case 'farmer':
                    return redirect()->route('farmer.dashboard')->with('error', 'Access denied to requested area.');
                case 'field_officer':
                    return redirect()->route('officer.dashboard')->with('error', 'Access denied to requested area.');
                case 'customer':
                    return redirect()->route('customer.dashboard')->with('error', 'Access denied to requested area.');
                default:
                    abort(403, 'Unauthorized access.');
            }
        }

        return $next($request);
    }
}
