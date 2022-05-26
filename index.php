<?php

include_once 'autoloader.php';
include_once 'functions.php';

Autoload::init();

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
    $controller = ucfirst(Routes::DEFAULT_ROUTE_CONTROLLER);
    $method = Routes::DEFAULT_ROUTE_METHOD;
} else {
    $controller = ucfirst($uri[0]);

    if (isset($uri[1])) {
        $method = $uri[1];
    } else {
        $method = 'index';
    }
}

$mapping = new MappingController();

if ($controller === 'Authentication') {
    foreach ($mapping->mapAuthRoutes() as $mapRoute) {
        $map = new $mapRoute();
        $key = $map->run();

        if ($key === false) {
            die();
        }
    }
} else {
    foreach ($mapping->mapRoutes() as $mapRoute) {
        $map = new $mapRoute();
        $key = $map->run();

        if ($key === false) {
            die();
        }
    }
}

$controller = new $controller();

call_user_func_array([$controller, $method], $params);