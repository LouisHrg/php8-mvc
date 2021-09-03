<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Auth;
use App\Core\Request;
use App\Core\Router;
use App\Core\Validator;

use App\Models\User;

class AuthController {
  public function login(){

    $errors = [];

    if(Request::isPost()) {
      $errors = Validator::check(User::loginForm());
      $found = User::where('email', Request::post('email'))
      ->getOne();
      if($found) {
        Auth::connect($found, Request::post('password'));
        Router::redirect('/articles');
      } else {
        Router::redirect('/login');
      }

    }

    return new View('auth/login', [
      'errors' => $errors,
    ]);
  }

  public function register() {

    $errors = [];

    if(Request::isPost()) {
      $errors = Validator::check(User::registerForm());

      if(empty($erros)) {
        $user = new User;
        $user->setPassword(Request::post('password'));
        $user->firstname = Request::post('firstname');
        $user->lastname = Request::post('lastname');
        $user->email = Request::post('email');
        $user->save();

        $found = User::where('email', Request::post('email'))->getOne();
        if($found) {
          Auth::connect($found, Request::post('password'));
          Router::redirect('/articles')
        }

      }
    }

    return new View('auth/register', [
      'errors' => $errors,
    ]);
  }

  public function logout() {
    Auth::logout();
    Router::redirect('/')
  }
}
