<?php

namespace App\AUthenticationSuccessListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationSuccessListener{

    private $secure = false;

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event) {
        $response = $event ->getResponse();

        $data = $event->getData();

        $token = $data['token'];

        $response->headers->setCookie(
            new Cookie('Bearer', $token, (new \DateTime())->add(new \DateInterval('PT' . 3600 . 'S'))),
            '/', null
        );
    }
}
