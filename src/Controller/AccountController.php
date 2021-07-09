<?php

namespace App\Controller;

use App\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/overview", name="account_overview")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/accounts/{id}", methods={"GET"})
     * @param Account $account
     */
    public function show(Account $account)
    {
        if($this->isGranted('ROLE_USER')){
            dd($account);
        }
    }

}
