<?php

namespace App\Http\Service;
use Illuminate\Support\Facades\DB;
use App\UserMetadata;


class UserService {
  private $table = "users";

  public function insert($data) {
    DB::table($this->table)->insert([
        'email' => $data['email'],
        'department_id' => $data['department_id'],
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'base_salary' => $data['base_salary'],
        'street' => $data['street'],
        'city' => $data['city'],
        'country' => $data['country'],
        'active' => 1,
        'role_id' => $data['role_id'],
        'password' => $data['password']
    ]);
  }
}

//class UserMetadataService {
//  private $table = "user_metadata";
//
//  public function insert($data) {
//    $md = new UserMetadata();
//    $md->first_name = $data['first_name'];
//    $md->last_name = $data['last_name'];
//    $md->base_salary = $data['base_salary'];
//    $md->street = $data['street'];
//    $md->city = $data['city'];
//    $md->country = $data['country'];
//    $md->active = 1;
//
//    if ($md->save()) {
//      return $md->id;
//    }
//    return 0;
//  }
//}
