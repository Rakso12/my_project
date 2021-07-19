<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function getEndpoints(): Response
    {
        $urlsList[] = [
            '/api' => 'gives all api\'s endpoints { POST}',
            '/api/register' => 'register new user { POST }',
            '/api/userlogin' => 'login user { POST }',
            '/logout' => 'logout user { GET }',
            '/oauth/token' => 'gives access  { GET }',
            '/oauth/makeclient' => 'make new client on oauth server { POST }',
            '/oauth/updateclient' => 'update grants or scopes for client { POST }',
            '/oauth/deactive' => 'make client not active { POST }',
            '/oauth/makeactive' => 'make client active { POST }'
        ];

        return new JsonResponse($urlsList, Response::HTTP_OK);
    }
}
