<?php

namespace App\Http\Service;
use Illuminate\Support\Facades\DB;
use App\UserRequestStatus;


class UserRequestService {
  private $table = "user_request";

  public function insert($data) {
      $date = date('Y-m-d H:i:s');
    DB::table($this->table)->insert([
      'type_id' => $data['type_id'],
      'user_id' => $data['user_id'],
      'details' => $data['details'],
      'status_id' => $data['status_id'],
      'date_from' => $data['date_from'],
      'date_to' => $data['date_to'],
        'created_at' => $date,
        'updated_at' => $date
      ]);
  }

  public function update($data, $id) {
    $date = date('Y-m-d H:i:s');
    DB::table($this->table)->where('id', $id)->update([
        'type_id' => $data['type_id'],
        'user_id' => $data['user_id'],
        'details' => $data['details'],
        'status_id' => $data['status_id'],
        'date_from' => $data['date_from'],
        'date_to' => $data['date_to'],
          'updated_at' => $date
      ]);
  }

  public function approve($id) {
    DB::table($this->table)->where('id', $id)->update([
        'status_id' => UserRequestStatus::$APPROVED,
    ]);
  }

  public function deny($id) {
    DB::table($this->table)->where('id', $id)->update([
        'status_id' => UserRequestStatus::$DENIED,
    ]);
  }
}
