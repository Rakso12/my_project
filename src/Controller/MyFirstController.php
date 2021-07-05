<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;

class MyFirstController
{
    public function homepage(){
        return new Response('My first symfony project.');
    }
}