<?php

namespace System;

class Autoload {
    public static function init(): void
    {
        spl_autoload_register(function ($className) {
            $class = BASE_PATH . DIRECTORY_SEPARATOR . $className . '.php';

            if (file_exists($class)) {
                include $class;
            }
        });
    }
}