<?php

namespace App\Core;

use App\Core\Database;
use App\Core\DatabaseQuery;

class BaseModel {

    public function __construct() {
      $this->db = Database::get()->pdo();
    }

    public static function all() {
      $db = Database::get()->pdo();
      $sth = $db->prepare("SELECT * FROM ".static::$table);
      $sth->execute();

      $result = $sth->fetchAll();
      return self::parseResult($result);
    }

    public function save() {

      $table = static::$table;

      $columns = $this->getColumns();

      $bindedParams = array_map(function($str) {
        return ':'.$str;
      }, $columns);

      if(!isset($this->id)) {

        $columnsStr = implode(',', $columns);
        $paramsStr = implode(',', $bindedParams);

        $stmt = $this->db->prepare(
          "INSERT INTO $table (". $columnsStr .") VALUES (". $paramsStr .")"
        );
      } else {

        $updateData = [];

        foreach ($columns as $key => $value) {
          $updateData[$key] = $value.'= :'.$value;
        }

        $updateStr = implode(',', $updateData);

        $stmt = $this->db->prepare("UPDATE static::$table SET ". $updateStr ." WHERE id=:id ");

        $id = $this->id;
        $stmt->bindValue(':id', $id);
      }

      foreach ($columns as $key => $value) {
        $field = $this->$value;
        $stmt->bindValue($bindedParams[$key], $field);
      }

      $stmt->execute();
    }

    private function getColumns() {

      $refObj = new \ReflectionObject($this);


      $properties = $refObj->getProperties();

      $columns = [];

      foreach ($properties as $property) {
        if(
            $property->getName() !== 'table' &&
            $property->getName() !== 'id' &&
            $property->getName() !== 'db'
          ) {
          $columns[] = $property->getName();
        }
      }

      return $columns;
    }

    public static function parseResult($result) {
      $output = [];

      foreach ($result as $row => $item) {

        $model = get_called_class();
        $obj = new $model;

        foreach ($item as $key => $value) {
          if(!is_integer($key)) {
            $obj->$key = $value;
          }
        }
        array_push($output, $obj);
      }
      return $output;
    }

    public static function where($column, $value, $operator = "=") {
      $query = new DatabaseQuery(static::$table);

      $query->where($column, $value, $operator);

      return $query;
    }

    public function delete() {
      $db = Database::get()->pdo();
      $sth = $db->prepare(
        "DELETE FROM ".static::$table. " WHERE id =" . $this->id);
      $sth->execute();
    }

    public static function find($id) {
      $db = Database::get()->pdo();
      $stmt = $db->prepare(
        "SELECT * FROM ".static::$table. " WHERE id = :id");

      $stmt->bindParam(':id', $id);
      $stmt->execute();

      $parsed = self::parseResult($stmt->fetchAll());
      if(!empty($parsed)) return $parsed[0];
      return null;
    }

    public static function mapDataToClass($data) {
      $model = get_called_class();
      $obj = new $model;
      foreach ($data as $key => $value) {
        $obj->$key = $value;
      }
      return $obj;
    }
}
