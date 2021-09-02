<?php

namespace App\Core;

class Router {

  const CONTROLLERS_PATH = '\\App\\Controllers\\';

  public function __construct(
    private $routes = [],
  ) {}


  public function matchUri($uri) {

    $route = $this->routes[$uri];

    if($route) {

      $class = self::CONTROLLERS_PATH.$route['controller'];

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
