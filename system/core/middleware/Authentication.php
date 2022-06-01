<?php

namespace System\Core\Middleware;

use System\Config\ApplicationConfig;
use System\Core\Middleware\Interface\MiddlewareInterface;
use System\Core\Helpers\User;

class Authentication implements MiddlewareInterface
{
    public function run(): bool
    {
        if (!ApplicationConfig::AUTHENTICATION) {
            return true;
        }

        if (!isset($_COOKIE['token'])) {
            redirect('/index.php/authentication/login');
        }

        $user = User::check();

        if ($user) {
            return true;
        } else {
            redirect('/index.php/authentication/login');
        }
    }
}