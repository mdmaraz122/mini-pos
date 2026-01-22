<?php

namespace App\Helper;

class FetchCurrentAdmin
{
    public static function GetCurrentAdmin($request)
    {
        $data = JWTToken::ReadToken($request->cookie('l_token'));
        if ($data == 'unauthorized') {
            return redirect(route('Login'))
                ->withCookie(cookie('l_token', '', -1, '/', null, true, true, false, 'Strict'));
        } else {
            return $data;
        }
    }
}
