<?php

namespace App\Core;

use App\Core;

class Router {

  const CONTROLLERS_PATH = '\\App\\Controllers\\';

  public function __construct(
    private $routes = [],
  ) {}


  public function matchUri($uri) {

    $route = $this->routes[$uri];

    if($route) {

      $class = self::CONTROLLERS_PATH.$route['controller'];

      // Verifier authentification

      if(
        isset($route['method']) &&
        $route['method'] !== $_SERVER['REQUEST_METHOD']
      ) {
        header('Location: /404');
      }

      if(isset($route['secured']) && $route['secured'] && !Auth::verify())
      {
        header('Location: /403');
      }

      if(isset($route['guest']) && $route['guest'] && Auth::verify())
      {
        header('Location: /');
      }

      if(class_exists($class)) {
        $controller = new $class;
        $action = $route['action'];
        if(method_exists($controller, $action)) {
          $controller->$action();
          die();
        } else {
          header('Location: /500');
        }
      } else {
        header('Location: /500');
      }
    } else {
      header('Location: /404');
    }
  }
}
