<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    //
    protected $table = "user_request";

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function user_request_status() {
        return $this->belongsTo(UserRequestStatus::class, 'status_id', 'id');
    }

    public function user_request_type() {
        return $this->belongsTo(UserRequestType::class, 'type_id', 'id');
    }
}
