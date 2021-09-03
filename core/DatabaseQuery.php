<?php

namespace App\Core;

use App\Core\Database;
use App\Core\BaseModel;

class DatabaseQuery {
  private $where = [];
  private $table = null;
  private $pdo = null;
  private $limit = null;
  private $orderBY = null;

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

    if(!empty($this->orderBy)){
      $sql .= $this->buildOrderQuery();
    }

    if($this->limit){
      $sql .= $this->buildLimitQuery();
    }

    $stmt = $this->pdo->prepare($sql. ';');

    foreach ($this->where as $column => $data) {
      $stmt->bindParam(':'.$column, $data['value']);
    }

    $stmt->execute();
    $res = $stmt->fetchAll();

    return BaseModel::parseResult($res);
  }

  private function buildOrderQuery(){
    $sql = '';
    $cpt = 0;
    foreach ($this->orderBy as $column => $type) {
      if($cpt===0){
        $sql .=' ORDER BY ';
      }
      $sql .= $column . ' ' . $type ;
      if($cpt+1!==count($this->orderBy)){
        $sql .= ',';
      }
      $cpt++;
    }
    return $sql;
  }

  public function buildLimitQuery(){
    return ' LIMIT ' . $this->limit;
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

  public function limit($lim){
    $this->limit = $lim;

    return $this;
  }

  public function orderBy($column, $type='ASC'){
    $this->orderBy[$column] = $type;
    return $this;
  }
}
