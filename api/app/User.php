<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'metadata_id',
        'department_id', 'created_at', 'updated_at', 'email_verified_at', 'role_id'
    ];

    public static $DEFAULT_PWD = "123123";

    public $with = ['department', 'role'];

//    public function metadata() {
//      return $this->belongsTo('App\UserMetadata', 'metadata_id');
//    }

    public function fullname() {
        return $this->first_name . " " . $this->last_name;
    }

    public function department() {
      return $this->belongsTo('App\Department', 'department_id');
    }

    public function role() {
      return $this->belongsTo('App\Role', 'role_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
