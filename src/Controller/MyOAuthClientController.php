<?php


namespace App\Controller;

use App\Repository\MyOAuthClientRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MyOAuthClientController
{
    private $myOAuthClientRepository;

    public function __construct(MyOAuthClientRepository $myOAuthClientRepository)
    {
        $this->myOAuthClientRepository = $myOAuthClientRepository;
    }

    public function makeClient(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $identifier = $data['identifier'];
        $name = $data['name'];
        $secret = $data['secret'];

        # TODO zmienić scopy i granty na czytanie z tablicy elementów

        $grants = $data['grants'];
        $scopes = $data['scopes'];

        if(empty($identifier) ||
            empty($name) ||
            empty($secret) ||
            empty($grants) ||
            empty($scopes)
        ){
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->myOAuthClientRepository->saveClient($identifier, $name, $secret, $grants, $scopes);
        return new JsonResponse(['Status' => 'Client added'], Response::HTTP_CREATED);
    }
}