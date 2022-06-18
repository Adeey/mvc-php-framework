<?php

use System\Config\RoutesConfig;
use System\Core\Controllers\MiddlewareController;
use System\Core\Controllers\PageNotFound;

$uri = array_filter(explode('/', $_SERVER['REQUEST_URI']));

foreach ($uri as $key => $item) {
    if ($item !== 'index.php') {
        unset($uri[$key]);
    } else {
        unset($uri[$key]);
        break;
    }
}

$uri = array_values($uri);

$params = array_slice($uri, 2);

if (empty($uri)) {
    $controller = ucfirst(RoutesConfig::DEFAULT_ROUTE_CONTROLLER);
    $method = RoutesConfig::DEFAULT_ROUTE_METHOD;
} else {
    $controller = ucfirst($uri[0]);

    if (isset($uri[1])) {
        $method = $uri[1];
    } else {
        $method = 'index';
    }
}

if (file_exists('app/controllers/' . $controller . '.php')) {
    $controller = new ('\\app\\controllers\\' . $controller)();
    $mapping = new MiddlewareController();
    $controllersWithoutMiddleware = $mapping->routesWithoutMiddleware();

    foreach ($mapping->mapRoutes() as $mapRoute) {
        if (
            isset($controllersWithoutMiddleware[$controller::class])
            &&
            in_array($mapRoute, $controllersWithoutMiddleware[$controller::class])
        ) {
            continue;
        }

        $map = new $mapRoute();
        $key = $map->run();

        if ($key === false) {
            die();
        }
    }

    call_user_func_array([$controller, $method], $params);
} else {
    PageNotFound::run();
}