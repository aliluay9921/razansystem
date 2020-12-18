<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Traits\sendresponse;
class admin
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
        $admin=auth::user()->status;
        if($admin == 1 || $admin ==2){
            return $next($request);

        }
        return $this->sendresponse(401,'not authnticated',[],[]);
    }
}
