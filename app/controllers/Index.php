<?php

namespace Controllers;

use Core\Controllers\MainController;

class Index extends MainController
{
    public function index()
    {
        $this->view('index/index');
    }
}