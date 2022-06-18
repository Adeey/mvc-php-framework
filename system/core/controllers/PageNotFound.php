<?php

namespace System\Core\Controllers;

class PageNotFound
{
    public static function run(): void
    {
        view('404/404');
    }
}