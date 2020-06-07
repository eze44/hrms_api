<?php

namespace App\Http\Service;
use Illuminate\Support\Facades\DB;


class DepartmentService {
  private $table = "department";

  public function insert($data) {
    DB::table($this->table)->insert([
      'name' => $data['name']
    ]);
  }
  
  public function update($data, $id) {
    DB::table($this->table)->where('id', $id)->update([
      'name' => $data['name']
    ]);
  }
}
