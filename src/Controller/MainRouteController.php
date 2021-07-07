<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainRouteController extends AbstractController
{
    public function mainpage(): Response
    {
        return $this->render('mainPage/welcomepage.html.twig');
    }

    public function homepage(): Response
    {
        return $this->render('mainPage/homepage.html.twig');
    }
}