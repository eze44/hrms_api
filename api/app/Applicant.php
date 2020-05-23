<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = "applicant";

    public $with = ['position'];
    public $timestamps = true;


    public function position() {
      return $this->belongsTo('App\Position', 'position_id');
    }
}
