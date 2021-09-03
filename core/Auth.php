<?php

namespace App\Core;

use App\Models\User;

class Auth {
  public static function connect($user, $password) {

    if(password_verify($password, $user->password)) {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['expire_at'] = time() + 1800;
    }
  }

  public static function verify() {
    if(isset($_SESSION['user_id']) && isset($_SESSION['expire_at'])) {
      $user = User::find($_SESSION['user_id']);
      if($user) return true;
    }
    self::logout();
    return false;
  }

  public static function user() {
    return User::find($_SESSION['user_id']);
  }

  public static function logout() {
    if(isset($_SESSION['user_id'])) {
      unset($_SESSION['user_id']);
    }
    if(isset($_SESSION['expire_at'])) {
      unset($_SESSION['expire_at']);
    }

    Router::redirect('/login')
  }
}
