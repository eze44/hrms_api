<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    protected $table = "recruitment";
    public $with = ['applicant', 'recruitment_status'];

    public function applicant() {
        return $this->belongsTo('App\Applicant', 'applicant_id');
    }

    public function recruitment_status() {
        return $this->belongsTo('App\RecruitmentStatus', 'status_id');
    }
}
