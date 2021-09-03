<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Auth;
use App\Models\User;

class AuthController {
  public function login(){
    return new View('auth/login');
  }

  public function verify(){
    $found = User::where('email', $_POST['email'])
    ->getOne();

    Auth::connect($found, $_POST['password']);

    var_dump(Auth::user());
  }
}
