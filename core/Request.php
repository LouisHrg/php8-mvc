<?php

namespace App\Core;


class Request {
  private $server = null;
  private $post = null;
  private $get = null;

  public static function get($key) {
    if($_GET[$key]) {
      return trim(addslashes(htmlentities($_POST[$key])));
    }
    return null;
  }

  public static function post($key) {
    if($_POST[$key]) {
      return trim(addslashes(htmlentities($_POST[$key])));
    }
    return null;
  }

  public static function isPost() {
    if($_SERVER['REQUEST_METHOD'] === "POST") return true;
    return false;
  }

  public static function getPost() {
    $parsed = [];
    foreach ($_POST as $key => $value) {
      $parsed[$key] = trim(addslashes(htmlentities($value)));
    }
    return $parsed;
  }

  public static function getQuery() {
    $parsed = [];
    foreach ($_GET as $key => $value) {
      $parsed[$key] = trim(addslashes(htmlentities($value)));
    }
    return $parsed;
  }

}
