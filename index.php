<?php

spl_autoload_register(function($class) {

  $parts = explode('\\', $class);

  $className = $parts[2];

  switch ($parts[1]) {
    case 'Core':
      include 'core/' . $className . '.php';
      break;
    case 'Controllers':
      include 'controllers/' . $className . '.php';
      break;
    case 'Models':
      include 'models/' . $className . '.php';
      break;
  }

});

use App\Core\Router;

$routes = yaml_parse_file('./config/routes.yml');

$router = new Router($routes['routes']);

$path = $_SERVER['REQUEST_URI'];

$router->matchUri($path);
