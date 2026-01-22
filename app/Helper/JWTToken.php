<?php

namespace App\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTToken
{
    // create Token
    public static function CreateToken($userName, $userID, $request): string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + (3 * 60 * 60), // Token expires in 3 hours
            'ip' => $request->ip(), // Collect IP address
            'user_agent' => $request->header('User-Agent'), // Collect device info
            'userName' => $userName,
            'userID' => $userID
        ];
        return JWT::encode($payload, $key, 'HS256');
    }


    public static function ReadToken($token): string|object
    {
        try {
            if($token==null){
                return 'unauthorized';
            }
            else{
                $key =env('JWT_KEY');
                return JWT::decode($token,new Key($key,'HS256'));
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}
