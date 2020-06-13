<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    protected $table = "recruitment";
    public $with = ['applicant'];

    public function applicant() {
        return $this->belongsTo('App\Applicant', 'applicant_id');
    }
}
