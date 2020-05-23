<?php

namespace App\Http\Validation;
use Illuminate\Http\Request;
use App\Http\Validation\BaseValidation;
use App\Applicant;
use App\Position;
use App\Http\Exceptions\ValidationException;

class ApplicantValidation extends BaseValidation {

  public function validateCreate(Request $request) {
    $first_name   =     $request->input("first_name");
    $last_name    =     $request->input("last_name");
    $email  =     $request->input("personal_email");

    $this->validateStringInput($first_name);
    $this->validateStringInput($last_name);
    $this->validateEmail($email);

    //validate create
    $position = Position::where("id", $request->input("position_id"))->first();
    if (is_null($position)) {
      throw new ValidationException('Invalid position');
    }
    $exists = Applicant::where("personal_email", $request->input("personal_email"))->first();
    if (!is_null($exists)) {
      throw new ValidationException('Duplicate entry');
    }
  }
}
