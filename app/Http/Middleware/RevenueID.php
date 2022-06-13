<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevenueID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {            
            $revenue_id = explode(',',auth()->user()->revenue_source_id);                         
            foreach($revenue_id as $id){
                if ($id == 1 || $id == 2 || $id == 3 || $id == 4) {
                    return $next($request);
                }
            }
            session()->flush();
            return redirect()->route('login');
        }
        return redirect()->route('login');
    }
}
