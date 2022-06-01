<?php

namespace App\Controllers;

use System\Core\Helpers\Database;

class Authentication
{
    public function login(): void
    {
        view('auth/login');
    }

    public function submit(): void
    {
        $user = Database::table('users')
            ->select()
            ->where('login', '=', $_POST['login'])
            ->where('password', '=', $_POST['password'])
            ->first();

        if (!$user) {
            echo 'user not found';
            $this->login();
        } else {
            $authToken = md5(date('Y-m-d H:i:s') . 'password#000');

            setcookie('token', $authToken, time()+3600, '/');

            Database::table('auth_token')
                ->delete()
                ->where('user_id', '=', $user['id'])
                ->run();

            Database::table('auth_token')
                ->insert([
                    'token' => $authToken,
                    'user_id' => $user['id']
                ])
                ->run();

            redirect('/');
        }
    }
}