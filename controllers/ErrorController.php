<?php

namespace App\Controllers;

class ErrorController {
  public function error404(){
    echo "404: Page not found";
  }

  public function error500(){
    echo "500 : Server Error";
  }
}
