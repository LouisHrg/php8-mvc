<?php

namespace App\Core;

use App\Core\Database;
use App\Core\BaseModel;

class DatabaseQuery {
  private $where = [];
  private $table = null;
  private $pdo = null;

  public function __construct($table) {
    $this->table = $table;
    $this->pdo = Database::get()->pdo();
  }

  public function where($column, $value) {
    $this->where[$column] = [
        'value' => $value,
        'operation' => '=',
    ];

    return $this;
  }

  public function get() {
    $sql = 'SELECT * FROM '.$this->table;
    if(!empty($this->where)) {
      $sql .= $this->buildSearchQuery();
    }

    $stmt = $this->pdo->prepare($sql. ';');

    foreach ($this->where as $column => $data) {
      $stmt->bindParam(':'.$column, $data['value']);
    }

    $stmt->execute();
    $res = $stmt->fetchAll();

    return BaseModel::parseResult($res);
  }

  private function buildSearchQuery() {
    $output = '';
    $cpt = 0;
    foreach ($this->where as $column => $data) {
      if($cpt === 0) $output .= ' WHERE ';
      $output .= $column. ' = :'.$column. ' ';
      if($cpt === 0 && $cpt+1 !== count($this->where)) {
        $output .= ' AND ';
      }
      $cpt++;
    }
    return $output;
  }

}
