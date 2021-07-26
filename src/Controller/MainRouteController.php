<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class MainRouteController
{
    public function index(): JsonResponse
    {
        return new JsonResponse(['Status' => 'Welcome']);
    }

}