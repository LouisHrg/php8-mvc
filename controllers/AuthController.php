<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Auth;
use App\Core\Request;
use App\Core\Validator;

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

  public function register() {

    $errors = [];

    if(Request::isPost()) {
      $errors = Validator::check(User::registerForm());
    }

    return new View('auth/register', [
      'errors' => $errors,
    ]);
  }

  public function logout() {
    Auth::logout();
    header('Location: /');
  }
}
