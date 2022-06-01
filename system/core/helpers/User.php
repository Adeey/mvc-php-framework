<?php

namespace System\Core\Helpers;

class User
{
    public static function get(): ?array
    {
        if (!isset($_COOKIE['token'])) {
            return null;
        }

        return Database::table('users')
            ->select()
            ->join('auth_token')
            ->on('auth_token', 'user_id', 'users', 'id')
            ->whereRaw('`auth_token`.`token` = \'' . $_COOKIE['token'] . '\'')
            ->first();
    }

    public static function check(): bool
    {
        if (!isset($_COOKIE['token'])) {
            return false;
        }

        $user = Database::table('auth_token')
            ->select()
            ->where('token', '=', $_COOKIE['token'])
            ->first();

        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}