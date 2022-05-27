<?php

class Auth extends MainController implements MapServicesInterface
{
    public function __construct()
    {
        $this->load('database');
    }

    public function run(): bool
    {
        if (isset($_COOKIE['token'])) {
            $user = $this->database->table('auth_token')
                ->select()
                ->where('token', '=', $_COOKIE['token'])
                ->first();
        } else {
            redirect('/index.php/authentication/login');
        }


        if (!$user) {
            redirect('/index.php/authentication/login');
        } else {
            return true;
        }
    }
}