<?php

namespace App\Http\Validation;

use App\Http\Exceptions\ValidationException;
use App\Department;
use App\Role;

class BaseValidation {

  protected function validateStringInput($input) {
    if (is_null($input) || $input == "") {
      throw new ValidationException("Empty string");
    }
  }

  protected function validateDepartment($input) {
    if (is_null($input) || $input == "") {
      throw new ValidationException("Invalid department");
    }
    $dpt = Department::where('id', $input)->first();
    if (is_null($dpt)) {
      throw new ValidationException("Invalid department");
    }
  }

  protected function validateRole($input) {
    if (is_null($input) || $input == "") {
      throw new ValidationException("Invalid role");
    }
    $role = Role::where('id', $input)->first();
    if (is_null($role)) {
      throw new ValidationException("Invalid role");
    }
  }

  protected function validatePasswords($p1, $p2) {
    if ($p1 != $p2) {
      throw new ValidationException("Passwords do not match");
    }
    if (strlen($p1) < 6) {
      throw new ValidationException("Password should be at least 6 characters");
    }
  }

  protected function validateEmail($input) {
    //validate email with regex
  }

}
