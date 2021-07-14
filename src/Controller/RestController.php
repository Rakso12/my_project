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
            '/api' => 'gives all api\'s endpoints',
        ];

        return new JsonResponse($urlsList, Response::HTTP_OK);
    }
}
