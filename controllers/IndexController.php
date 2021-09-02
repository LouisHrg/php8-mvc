<?php

namespace App\Controllers;

use App\Core\View;

class IndexController {
  public function index(){

    $args = [
      'firstname' => 'Foo',
      'lastname' => 'Bar',
    ];

    return new View('index/home', $args);
  }
}
