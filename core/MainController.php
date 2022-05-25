<?php

class MainController
{
    protected function load(string $model)
    {
        $class = ucfirst($model);

        if (file_exists('library/' . $class . '.php')) {
            $this->$model = new $class();
        } else {
            throw new Exception('Library ' . $class . ' not found!');
        }
    }

    protected function view(string $view, ?array $items = null)
    {
        include_once 'views/' . $view . '.php';
    }
}