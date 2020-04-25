<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = "positions";
    protected $with = ["department"];

    public function department() {
      return $this->belongsTo('App\Department', 'department_id');
    }
}
