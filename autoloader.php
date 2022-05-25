<?php

class Autoload {
    const DIRS = [
        'config',
        'controllers',
        'core',
        'models',
        'mapServices',
        'mapServices/Interface'
    ];

    public static function init(): void
    {
        spl_autoload_register(function ($class) {
            foreach (static::DIRS as $dir) {
                $path = $dir . DIRECTORY_SEPARATOR . strtolower($class) . '.php';

                if (file_exists($path)) {
                    require_once $path;
                }
            }
        });
    }
}