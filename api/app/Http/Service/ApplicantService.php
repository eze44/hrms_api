<?php

namespace App\Http\Service;
use Illuminate\Support\Facades\DB;


class ApplicantService {
  private $table = "applicant";

  public function insert($data) {
    DB::table($this->table)->insert([
      'first_name' => $data['first_name'],
      'last_name' => $data['last_name'],
      'personal_email' => $data['personal_email'],
      'position_id' => $data['position_id']
    ]);
  }
}
