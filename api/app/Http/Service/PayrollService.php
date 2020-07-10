<?php

namespace App\Http\Service;
use Illuminate\Support\Facades\DB;


class PayrollService {
  private $table = "payroll";

  public function insert($data) {
      $date = date('Y-m-d H:i:s');
    DB::table($this->table)->insert([
      'manager_id' => $data['manager_id'],
      'user_id' => $data['user_id'],
      'sum' => $data['sum'],
      'bonus' => $data['bonus'],
        'created_at' => $date,
        'updated_at' => $date

      ]);
  }

  public function update($data, $id) {
    $date = date('Y-m-d H:i:s');
    DB::table($this->table)->where('id', $id)->update([
      'manager_id' => $data['manager_id'],
      'user_id' => $data['user_id'],
      'sum' => $data['sum'],
      'bonus' => $data['bonus'],
        'created_at' => $date,
        'updated_at' => $date

      ]);
  }
}
