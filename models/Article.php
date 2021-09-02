<?php

namespace App\Models;

use App\Core\BaseModel;

class Article extends BaseModel {

  public static $table = 'articles';

  private int $id;
  private String $title;
  private String $slug;

  public function __construct(){
    parent::__construct();
  }

  public function __get($property) {
    return $this->$property;
  }

  public function __set($property, $value) {
    $this->$property = $value;
  }
}

