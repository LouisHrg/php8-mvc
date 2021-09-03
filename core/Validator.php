<?php

namespace App\Core;


use App\Core\Request;

class Validator {
  public static function check($config) {

    $errors = [];

    foreach ($config as $key => $value) {
      $toCheck = Request::post($key);

      if($value['type'] && !self::checkType($toCheck, 'string')) {
        $errors[$key][] = $key . " type is invalid";
      }
      if($value['required'] && is_null($toCheck)) {
        $errors[$key][] = $key . " is required";
      }
    }

    return $errors;

  }

  public static function checkType($value, $type) {
    switch ($type) {
      case 'string':
        return is_string($value);
        break;
      default:
        return false;
        break;
    }
  }
}


