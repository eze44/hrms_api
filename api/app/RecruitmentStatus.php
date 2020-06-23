<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecruitmentStatus extends Model
{
    protected $table = "recruitment_status";

    public $timestamps = true;

    public static $APPROVED_STATUS=4;
}
