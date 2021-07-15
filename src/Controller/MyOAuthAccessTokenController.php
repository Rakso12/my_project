<?php

namespace App\Controller;

use App\Repository\MyOAuthAccessTokenRepository;

class MyOAuthAccessTokenController
{
    private $myOAuthAccessTokenRepository;

    public function __construct(MyOAuthAccessTokenRepository $myOAuthAccessTokenRepository)
    {
        $this->myOAuthAccessTokenRepository = $myOAuthAccessTokenRepository;
    }
}