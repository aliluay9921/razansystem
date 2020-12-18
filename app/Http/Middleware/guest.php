<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\sendresponse;
use Illuminate\Http\Request;

class guest
{
    use sendresponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user()->UserName;
        if ($user == null)
            return $next($request);
        else {
            return $this->sendresponse(401, 'already authenticated', [], []);
        }
    }
}