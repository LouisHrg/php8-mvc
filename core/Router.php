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

      if(
        isset($route['method']) &&
        $route['method'] !== $_SERVER['REQUEST_METHOD']
      ) {
        self::redirect('/404');
      }

      if(isset($route['secured']) && $route['secured'] && !Auth::verify())
      {
        self::redirect('/403');
      }

      if(isset($route['guest']) && $route['guest'] && Auth::verify())
      {
        self::redirect('/');
      }

      if(class_exists($class)) {
        $controller = new $class;
        $action = $route['action'];
        if(method_exists($controller, $action)) {
          $controller->$action();
          die();
        } else {
          self::redirect('/500');
        }
      } else {
        self::redirect('/500');
      }
    } else {
      self::redirect('/404');
    }
  }

  public static function redirect($route) {
    header('Location: '.$route);
  }
}
