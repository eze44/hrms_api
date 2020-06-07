<?php

namespace App\Http\Service;
use Illuminate\Support\Facades\DB;


class PositionService {
  private $table = "positions";

  public function insert($data) {
    DB::table($this->table)->insert([
      'name' => $data['name'],
      'department_id' => $data['department_id'],
      'qty' => $data['qty']
    ]);
  }
  
  public function update($data, $id) {
    DB::table($this->table)->where('id', $id)->update([
        'name' => $data['name'],
        'department_id' => $data['department_id'],
        'qty' => $data['qty']
    ]);
  }
}
