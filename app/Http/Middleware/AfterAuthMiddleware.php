<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AfterAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $data = JWTToken::ReadToken($request->cookie('l_token'));
        if(!$data){
            return redirect(route('Login'))
                ->withCookie(cookie('l_token', '', -1, '/', null, true, true, false, 'Strict'));
        }else if ($data == 'unauthorized') {
            return redirect(route('Login'))
                ->withCookie(cookie('l_token', '', -1, '/', null, true, true, false, 'Strict'));
        } else {
            return $next($request);
        }
    }
}
