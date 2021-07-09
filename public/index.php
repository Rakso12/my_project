<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

/*
 * Basic configuration:
 *
 * Oauth2 Configuration:
 * php bin/console league:oauth2:create-client "YOUR APP NAME"
 * php bin/console league:oauth2:update-client "YOUR APP IDENTIFIER" --grant-type client_credentials --scope create --scope read
 *
 * POST for getting token:
 * https://127.0.0.1:8000/token
 * type: x-www-from-urlencoded   / BODY
 * grant_type : client_credentials
 * client_id : .....
 * client_secret : ....
*/
