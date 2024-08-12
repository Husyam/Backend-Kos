<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            //dd($user); // Tampilkan data pengguna untuk debugging
            // Tambahkan log untuk memeriksa peran pengguna
            Log::info('User role:', ['role' => $user->roles]);

            if ($user->roles === 'ADMIN') {
                return $next($request);
            }
        }

        // return redirect('/'); // Redirect to home or any other page
        return redirect()->route('home')->with('error', 'kamu tidak memiliki akses untuk menggakses halaman ini!');
    }
}
