<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class MyFirstController
{
    public function homepage(): Response
    {
        return new Response('My first proj.');
    }
}