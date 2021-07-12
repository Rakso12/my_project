<?php

namespace App\Controller;

use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/trylogin", name="loginOAuth", methods={"POST"})
     * @param Request $request
     * @param LoginFormAuthenticator $loginFormAuthenticator
     * @return JsonResponse
     */
    public function oauthLogin(Request $request, LoginFormAuthenticator $loginFormAuthenticator): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

       // $client_id = $data['client_id'];
       // $client_secret = $data['client_secret'];
        $username = $data['email'];
        $password = $data['password'];

        $userData[] = [
            'email' => $username,
            'password' => $password,
        ];

        if($loginFormAuthenticator->authenticate($userData))
        {
            return JsonRespose(['Status' => 'ok ->'.$username], Response::HTTP_OK);
        }
        return JsonResponse(['Status' => 'nope'], Response::HTTP_NO_CONTENT);
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
