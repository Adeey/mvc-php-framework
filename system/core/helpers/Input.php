<?php

namespace System\Core\Helpers;

class Input
{
    public static function post(string $name)
    {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        } else {
            return null;
        }
    }
}