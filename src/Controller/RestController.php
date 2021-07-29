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
            '/api' => 'Gives all api\'s endpoints { POST}',
            '/api/register' => 'Register new user { POST }',
            '/api/userlogin' => 'Login user { POST }',
            '/logout' => 'Logout user { GET }',
            '---- OAUTH SERVER ----------------' => '',
            '/oauth/token' => 'Gives access token { GET }',
            '/oauth/makeclient' => 'Make new client on oauth server { POST }',
            '/oauth/updateclient' => 'Update grants or scopes for client { POST }',
            '/oauth/deactive' => 'Make client not active { POST }',
            '/oauth/makeactive' => 'Make client active { POST }',
            '---- POST ENDPOINTS --------------' => '',
            '/post/add' => 'Add new post with content and author { POST }',
            '/post/showmypost' => 'Show all login user post { POST }',
            '/post/showmyfollow' => 'Show all post for user { POST }',
            '/post/showbyhashtag' => 'Show all post with hash { POST }',
            '/post/showuserpost' => 'Show post by wanted user { POST }',
            '---- FOLLOWING ENDPOINTS ---------' => '',
            '/following/adduser' => 'Follow user by user',
            '/following/addhashtag' => 'Follow hashtag by user',
            '/following/unfollowuser' => 'Make user unfollow by user',
            '/following/unfollowhashtag' => 'Make hashtag unfollow by user'
        ];

        return new JsonResponse($urlsList, Response::HTTP_OK);
    }
}
