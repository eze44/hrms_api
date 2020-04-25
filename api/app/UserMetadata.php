<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMetadata extends Model
{
    protected $table = "user_metadata";
    public $timestamps = false;

    public function user() {
      return $this->belongsTo('App\User');
    }
}
