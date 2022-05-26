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

            $this->database->table('auth_token')
                ->delete()
                ->where('user_id', '=', $user['id'])
                ->run();

            $this->database->table('auth_token')
                ->insert([
                    'token' => $authToken,
                    'user_id' => $user['id']
                ])
                ->run();

            redirect ('/index.php/product/list');
        }
    }
}