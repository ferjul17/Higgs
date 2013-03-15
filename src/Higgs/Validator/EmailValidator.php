<?php

namespace Higgs\Validator;

class EmailValidator implements \BasicValidator
{
  public function isValid(\ValidatorMap $map, $str)
  {
    return preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i', $str) !== 0;
  }
}

?>
