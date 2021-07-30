<?php

namespace App\Controller;

use App\Repository\MyOAuthAccessTokenRepository;
use App\Repository\MyOAuthClientRepository;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MyOAuthAccessTokenController
 * @package App\Controller
 */
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
     * This is function to generating new access token. Mandatory data:
     * - client_id (10 character string)
     * - client_secret (20 character string)
     * - username (email)
     * - password (without hash)
     * @Route("/oauth/token", name="token", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
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
            $errors[] = "Access denied - client not found.";
        }

        if(!$this->myOAuthClient->checkClient($client_id, $client_secret)) {
            $errors[] = "Access denied - client credentials is not valid.";
        }

        $user = $this->myUser->findOneBy(['email' => $username]);
        if(!$this->loginFromAuthenticator->checkCredentials($password, $user)){
            $errors[] = "Access denied - user not valid.";
        }

        if (!$errors){
            $token = $this->myOAuthAccessTokenRepository->generateToken();
            $this->myOAuthAccessTokenRepository->setAccess($username, $token, $client_id);

            return new JsonResponse(['Status' => $token]);
        }
        return new JsonResponse($errors);
    }

    /**
     * This is function for checking if the token is up-to-date. Mandatory data:
     * - identifier (our token string)
     * @Route("/checkit", name="check_date", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $token = $data['identifier'];

        if(!$this->myOAuthAccessTokenRepository->checkTokenTerm($token)){
            return new JsonResponse(['Access denied - The token is out of date.']);
        }
        return new JsonResponse(['ok']);
    }
}