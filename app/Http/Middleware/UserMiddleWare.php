<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $privilege)
    {
        
       
        if(\Auth::check())
		{   
            $token = $request->session()->get('web_access_token');
            if(empty($token)){
                $user = \Auth::user();
                $token = $user->createToken(env('APP_KEY'));
                $request->session()->put('web_access_token', $token->accessToken);
            }



            if(empty(\Auth::user()->verified)){
                if(\Auth::user()->cashback_register){
                    return redirect(url("/signup/phone-verify"));
                }else{
                    return redirect(url("phone-verify"));
                }
            }

            if($privilege=="adminaccess"){
                if(\Auth::user()->user_type==2){ # for non admin users
                    return redirect(url("/"));
                }
            }

			return $next($request);
        }
      
		return redirect(url('/').'/login');
    }
}
