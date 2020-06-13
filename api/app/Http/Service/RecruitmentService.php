<?php

namespace App\Http\Service;
use Illuminate\Support\Facades\DB;


class RecruitmentService {
  private $table = "recruitment";

  public function insert($data) {
    DB::table($this->table)->insert([
      'status_id' => $data['status_id'],
      'applicant_id' => $data['applicant_id'],
      'notes' => $data['notes']
    ]);
  }
  
  public function update($data, $id) {
    DB::table($this->table)->where('id', $id)->update([
        'status_id' => $data['status_id'],
        'applicant_id' => $data['applicant_id'],
        'notes' => $data['notes']
    ]);
  }
}
