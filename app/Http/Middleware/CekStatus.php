<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CekStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
          if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        
        if ($user->status == 'kepala_arsip') {
            return redirect('dashboard_admin.main');
        } elseif ($user->status == 'direktur') {
            return redirect('dashboard_admin.main');
        } elseif ($user->status == 'admin_devisi'){
            return redirect('dashboard_admin.main');
        }
        
        return $next($request);
    }
}
