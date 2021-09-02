<?php

namespace App\Core;

class View {
  public function __construct(
    public $name = 'index/home',
    public $params = [],
  ) {}

  public function __destruct() {
    extract($this->params);
    include './views/'.$this->name . '.template.php';
  }
}
