<?php

namespace App\Core;


use App\Core\Request;

class Validator {
  public static function check($config) {

    $errors = [];

    foreach ($config as $key => $value) {
      $toCheck = Request::post($key);

      if(isset($value['type']) && !self::checkType($toCheck, $value['type'])) {
        $errors[$key][] = $key . " type is invalid";
      }
      if(isset($value['required']) && is_null($toCheck)) {
        $errors[$key][] = $key . " is required";
      }
      if(isset($value['equal']) && Request::post($value['equal']) !== $toCheck) {
        $errors[$key][] = $key . " is not confirmation of ".$value['equal'];
      }
    }

    return $errors;
  }

  public static function checkType($value, $type) {
    switch ($type) {
      case 'string':
        return is_string($value);
      case 'email':
        return filter_var($value, FILTER_VALIDATE_EMAIL);
      default:
        return false;
    }
  }
}


