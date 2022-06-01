<?php

function redirect(string $url)
{
    header('Location: ' . $url);
}

function view(string $view, ?array $items = null)
{
    include 'views/' . $view . '.php';
}