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
}
