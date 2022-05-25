<?php

class Authentication extends MainController
{
    public function __construct()
    {
        $this->load('database');
    }

    public function submit(): void
    {
        $user = $this->database->table('users')
            ->select()
            ->where('login', '=', $_POST['login'])
            ->where('password', '=', $_POST['password'])
            ->first();

        if ($user === null) {
            echo 'user not found';
            $this->view('auth/login');
        } else {
            $authToken = md5(date('Y-m-d H:i:s') . 'password#000');

            setcookie('token', $authToken, time()+3600, '/');

            $this->database->query("DELETE FROM `auth_token` WHERE `user_id` = '" . $user['id'] . "'");
            $this->database->query("INSERT INTO `auth_token` (`token`, `user_id`) VALUES ('" . $authToken . "', '" . $user['id'] . "')");

            redirect ('/index.php/product/list');
        }
    }
}