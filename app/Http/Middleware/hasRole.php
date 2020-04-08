<?php

namespace App\Http\Middleware;

use Closure;

class hasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = auth()->payload();
        

        if($user('role') === 0) {
           return response()->json(['status'=> "É admin"]);
        } else {
          return response()->json(['status'=>'Não é admin']);
        }

        return $next($request);
    }
}
