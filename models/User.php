<?php

namespace App\Models;

use App\Core\BaseModel;

class User extends BaseModel {

  public static $table = 'users';

  private int $id;
  private String $password;
  private String $firstname;
  private String $lastname;
  private String $email;

  public function __construct(){
    parent::__construct();
  }

  public function __get($property) {
    return $this->$property;
  }

  public function __set($property, $value) {
    $this->$property = $value;
  }

  public function setPassword(String $password): self {
    $this->password = password_hash($password, PASSWORD_DEFAULT);
    return $this;
  }

  public static function registerForm() {
    return [
      'email' => [
        'type' => 'string', 'required' => true,
      ],
      'lastname' => [
        'type' => 'string', 'required' => true
      ],
      'firstname' => [
        'type' => 'string', 'required' => true
      ],
      'password' => [
        'type' => 'string', 'required' => true,
      ],
      'password_confirmation' => [
        'type' => 'string',
        'required' => true,
        'equal' => 'password'
      ]
    ];
  }

}

