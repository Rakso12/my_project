<?php

namespace App\Controller;

use App\Repository\MyOAuthAccessTokenRepository;
use App\Repository\MyOAuthClientRepository;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MyOAuthAccessTokenController
{
    private $myOAuthAccessTokenRepository;
    private $myOAuthClient;
    private $myUser;
    private $loginFromAuthenticator;

    /**
     * MyOAuthAccessTokenController constructor.
     * @param MyOAuthAccessTokenRepository $myOAuthAccessTokenRepository
     * @param MyOAuthClientRepository $myOAuthClient
     * @param LoginFormAuthenticator $loginFormAuthenticator
     * @param UserRepository $myUser
     */
    public function __construct(MyOAuthAccessTokenRepository $myOAuthAccessTokenRepository, MyOAuthClientRepository $myOAuthClient, LoginFormAuthenticator $loginFormAuthenticator, UserRepository $myUser)
    {
        $this->myOAuthAccessTokenRepository = $myOAuthAccessTokenRepository;
        $this->myOAuthClient  = $myOAuthClient;
        $this->loginFromAuthenticator = $loginFormAuthenticator;
        $this->myUser = $myUser;
    }

    /**
     * @Route("/oauth/token", name="token", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function generateToken(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $client_id = $data['client_id'];
        $client_secret = $data['client_secret'];
        $username = $data['username'];
        $password = $data['password'];

        $errors = [];

        if(empty($client_id) ||
            empty($client_secret) ||
            empty($username) ||
            empty($password)
        ){
            $errors[] = 'Expecting mandatory parameters!';
        }

        if(!$this->myOAuthClient->clientExist($client_id)) {
            $errors[] = "Access denited - client not found.";
        }

        if(!$this->myOAuthClient->checkClient($client_id, $client_secret)) {
            $errors[] = "Access denited - client credentials is not valid.";
        }

        $user = $this->myUser->findOneBy(['email' => $username]);
        if(!$this->loginFromAuthenticator->checkCredentials($password, $user)){
            $errors[] = "Access denited - user not valid.";
        }

        if (!$errors){
            $token = $this->myOAuthAccessTokenRepository->generateToken();

            $this->myOAuthAccessTokenRepository->setAccess($username, $token, $client_id);

            return new JsonResponse(['Status' => $token]);
        }

        return new JsonResponse($errors);
    }
}