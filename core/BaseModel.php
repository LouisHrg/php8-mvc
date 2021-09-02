<?php

namespace App\Core;

use App\Core\Database;

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

      $columns = $this->getColumns();

      $bindedParams = array_map(function($str) {
        return ':'.$str;
      }, $columns);

      if(!isset($this->id)) {

        $columnsStr = implode(',', $columns);
        $paramsStr = implode(',', $bindedParams);

        $stmt = $this->db->prepare(
          "INSERT INTO static::$table (". $columnsStr .") VALUES (". $paramsStr .")"
        );
      } else {

        $updateData = [];

        foreach ($columns as $key => $value) {
          $updateData[$key] = $value.'= :'.$value;
        }

        $updateStr = implode(',', $updateData);

        $stmt = $this->db->prepare("UPDATE static::$table SET ". $updateStr ." WHERE id=:id ");

        $id = $this->id;
        $stmt->bindParam(':id', $id);
      }

      foreach ($columns as $key => $value) {
        $field = $this->$value;
        $stmt->bindParam($bindedParams[$key], $field);
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

    private static function parseResult($result) {
      $output = [];

      foreach ($result as $row => $item) {
        foreach ($item as $key => $value) {
          if(!is_integer($key)) {
            $output[$row][$key] = $value;
          }
        }
      }
      return $output;
    }
}
