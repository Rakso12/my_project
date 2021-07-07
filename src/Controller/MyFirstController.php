<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MyFirstController extends AbstractController
{
    public function homepage(): Response
    {
        return $this->render('mainPage/homepage.html.twig');
    }
}