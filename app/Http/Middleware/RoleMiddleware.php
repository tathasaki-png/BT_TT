<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:admin') or 'role:admin,instructor'
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login.form');
        }

        $user = Auth::user();

        // Kiểm tra trạng thái tài khoản
        if ($user->status !== User::STATUS_ACTIVE) {
            Auth::logout();
            return redirect()->route('login.form')->withErrors(['account' => 'Tài khoản của bạn đã bị khóa.']);
        }

        $allowed = array_map('trim', explode(',', $roles));

        // Admin luôn có quyền truy cập tất cả
        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!in_array($user->role, $allowed, true)) {
            abort(403, 'Bạn không có quyền truy cập vào chức năng này.');
        }

        return $next($request);
    }
}
