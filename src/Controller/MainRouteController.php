<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class MainRouteController
 * @package App\Controller
 */
class MainRouteController
{
    /**
     * It's only for logout endpoint route.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse(['Status' => 'Welcome']);
    }

}