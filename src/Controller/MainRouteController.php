<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainRouteController
{
    public function index(): JsonResponse
    {
        return new JsonResponse(['Status' => 'Welcome']);
    }

    /**
     * @Route("/showurls",name="list_of_url", methods={"GET"})
     * @return JsonResponse
     */
    public function showUrls(): JsonResponse
    {
        $urlArray[] = [
            '/' => 'welcome api endpoint -> do nothing',
            '/api/login' => 'endpoint to login user',
            '/api/register' => 'not working now but it will be registration endpoint',
            '/logout' => 'logout endpoint',
        ];
        return new JsonResponse($urlArray);
    }
}