<?php

class MainController
{
    protected function load(string $model)
    {
        $class = ucfirst($model);

        if (file_exists('models/' . $class . '.php')) {
            $this->$model = new $class();
        } else {
            throw new Exception('Model ' . $class . ' not found!');
        }
    }

    protected function view(string $view, ?array $items = null)
    {
        include_once 'views/' . $view . '.php';
    }
}