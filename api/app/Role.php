<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "role";

    public static $EMPLOYEE = 6;
    public static $FINANCIAL_MANAGER = 3;
    public static $HR_MANAGER = 2;
    public static $CEO = 1;
    // public static $ADMINS = [$HR_MANAGER, $CEO];
}
