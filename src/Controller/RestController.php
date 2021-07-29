<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends AbstractController
{
    /**
     * This is endpoint for listing all endpoints in my API
     * @Route("/api", name="api", methods={"GET"})
     */
    public function getEndpoints(): Response
    {
        $urlsList[] = [
            '---- LOGIN / REGISTER ------------' => '',
            '/api' => 'gives all api\'s endpoints { POST}',
            '/api/register' => 'register new user { POST }',
            '/api/userlogin' => 'login user { POST }',
            '/logout' => 'logout user { GET }',
            '---- OAUTH SERVER ----------------' => '',
            '/oauth/token' => 'gives access  { GET }',
            '/oauth/makeclient' => 'make new client on oauth server { POST }',
            '/oauth/updateclient' => 'update grants or scopes for client { POST }',
            '/oauth/deactive' => 'make client not active { POST }',
            '/oauth/makeactive' => 'make client active { POST }',
            '---- POST ENDPOINTS --------------' => '',
            '/post/add' => 'add new post with content and author',
            '/post/showmyfollow' => 'show all post for user',
            '/post/showbyhash' => 'show all post with hash',
        ];

        return new JsonResponse($urlsList, Response::HTTP_OK);
    }
}
