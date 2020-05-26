<?php

namespace App\Http\Validation;
use Illuminate\Http\Request;
use App\Http\Validation\BaseValidation;

class UserValidation extends BaseValidation {

  public function validateCreateUser(Request $request) {
    $first_name   =     $request->input("first_name");
    $last_name    =     $request->input("last_name");
    $base_salary  =     $request->input("base_salary");
    $street =         $request->input("street");
    $city =           $request->input("city");
    $country =        $request->input("country");
    $active =         $request->input("active");
    $email =          $request->input("email");
    $department_id =  $request->input("department_id");
    $role_id =        $request->input("role_id");
    $password =       $request->input("password");
    $confirmp =       $request->input("confirm_password");

    $this->validateStringInput($first_name);
    $this->validateStringInput($last_name);
    $this->validateStringInput($street);
    $this->validateStringInput($city);
    $this->validateStringInput($country);
    $this->validateStringInput($email);
    $this->validateDepartment($department_id);
    $this->validateRole($role_id);
    $this->validatePasswords($password, $confirmp);
  }

  public function validateUpdateUser(Request $request) {
    $first_name   =   $request->input("first_name");
    $last_name    =   $request->input("last_name");
    $base_salary  =   $request->input("base_salary");
    $street =         $request->input("street");
    $city =           $request->input("city");
    $country =        $request->input("country");
    $active =         $request->input("active");
    $email =          $request->input("email");
    $department_id =  $request->input("department_id");
    $role_id =        $request->input("role_id");
    $password =       $request->input("password");
    $confirmp =       $request->input("confirm_password");

    $this->validateStringInput($first_name);
    $this->validateStringInput($last_name);
    $this->validateStringInput($street);
    $this->validateStringInput($city);
    $this->validateStringInput($country);
    $this->validateStringInput($email);
    $this->validateDepartment($department_id);
    $this->validateRole($role_id);

    if($password != null) {
      $this->validatePasswords($password, $confirmp);
      return TRUE;
    }
    return FALSE;
  }
}
