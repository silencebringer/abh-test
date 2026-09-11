<?php

require_once __DIR__ . '/../autoload.php';

require_once __DIR__ . '/../vendor/autoload.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$segments = array_values(array_filter(explode('/', $path)));

$controllerName = ucfirst(strtolower($segments[0] ?? 'home'));
$action = strtolower(count($segments) > 1 ? $segments[1] : 'index');

if (!file_exists(__DIR__ . '/../Controllers/'. $controllerName . 'Controller.php')) {
    throw new Exception($controllerName . 'Controller not exists');
}

$controllerFullName = '\Controllers\\' . $controllerName . 'Controller';

$controller = new $controllerFullName();

if (!method_exists($controller, $action)) {
    throw new Exception('Method "' . $action . '" not exists in "' . $controllerName . '" controller');
}

if (!is_callable([$controller, $action])) {
    throw new Exception('Method "' . $action . '" is not callable in "' . $controllerName . '" controller');
}

$args = count($segments) > 2 ? array_slice($segments, 2) : [];

$controller->$action(...$args);
exit();