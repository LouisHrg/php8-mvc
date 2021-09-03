<?php

namespace App\Core;

class View {
  public function __construct(
    public $name = 'index/home',
    public $params = [],
    public $layout = 'layouts/app',
  ) {}

  public function __destruct() {
    extract($this->params);
    extract([
      'template' => $this->name
    ]);
    include './views/'.$this->layout . '.template.php';
  }
}
