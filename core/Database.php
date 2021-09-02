<?php

namespace App\Core;

class Database {
  private static $_instance;
  private $pdo;

  public function __construct() {
    $this->pdo = new \PDO('mysql:host=db;dbname=mvc',
      'user',
      'root'
    );
  }

  public static function get() {
    if(is_null(self::$_instance)) {
      self::$_instance = new Database;
      return self::$_instance;
    } else {
      return self::$_instance;
    }
  }

  public function pdo() {
    return $this->pdo;
  }
}
