<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $loc = session()->get('locale');
        \App::setLocale($loc);
        if (Auth::check() && !Auth::user()->has_paid){
            return redirect()->route('pay');
        }


        return $next($request);
    }
}
