<?php

namespace App\Service;
use App\Model\Entity\User;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper
{
    const SECRET = 'colocCountTopMoumoutte';
    public static function buildJWT(User $user): string
    {
        
        $payload = [
            "id" => $user->getUser_Id(),
            "username" => $user->getUsername(),
            "email"=> $user->getEmail(),
            "exp" => (new \DateTime("+ 3600 minutes"))->getTimestamp()
        ];
        
        return JWT::encode($payload, self::SECRET, "HS256");
    }

     public static function decodeJWT(string $jwt): ?object
    {
        try {
            return JWT::decode($jwt, new Key(self::SECRET, 'HS256'));
            }
            catch (\Exception $exception) {
                return null;
            }
    }
}