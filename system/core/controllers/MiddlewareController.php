<?php

namespace System\Core\Controllers;

use System\Core\Middleware\Authentication as AuthMiddleware;
use App\Controllers\Authentication as AuthController;

class MiddlewareController
{
    public function mapRoutes()
    {
        return [AuthMiddleware::class];
    }

    public function routesWithoutMiddleware()
    {
        return [
            AuthController::class => [AuthMiddleware::class]
        ];
    }
}