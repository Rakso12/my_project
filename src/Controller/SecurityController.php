<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;

class SecurityController extends AbstractController
{
    private $client;
    private $loginFormAuthenticator;


    public function __construct(HttpClientInterface $client, LoginFormAuthenticator $loginFormAuthenticator)
    {
        $this->client = $client;
        $this->loginFormAuthenticator = $loginFormAuthenticator;

    }

    /**
     * @Route("/trylogin", name="loginOAuth", methods={"POST"})
     * @param Request $request
     * @param LoginFormAuthenticator $loginFormAuthenticator
     * @return JsonResponse
     */
    public function oauthLogin(Request $request, LoginFormAuthenticator $loginFormAuthenticator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $password = $data['password'];
        $client_id = $data['client_id'];
        $client_secret = $data['client_secret'];

        $userData[] = [
            'email' => $username,
            'password' => $password,
        ];

        $loginFormAuthenticator->authenticate($request);

        if(true)// todo jakoś sprawdzić usera...
        {
            $clientData[] = [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
            ];

            $token =
            $tokenRequest = Request::create('/token', "POST", $clientData);

            // todo jakoś pozyskać token...
        }
        /*
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $username]);

        $token = new UsernamePasswordToken($user, $user->getPassword(), "public", $user->getRoles());

        $this->get("security.token_storage")->setToken($token);

        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

        $us = $user->getEmail();
        $pas = $user->getPassword();



       /* if($us == 'sjohnson@xyz.com') //
        {
            $response = $this->client->request('POST',
                'https://127.0.0.1:8000/token');
        }
        else
        {
            $response = 'NOT GOOD...';
        }*/
        /*

        */
        return new JsonResponse(['Status' => $tokenRequest], Response::HTTP_OK);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
