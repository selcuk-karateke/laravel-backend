<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'email', 'password',
        'from_api',
        'forename',
        'surename',
        'role_id',
        'email',
        'www',
    ];
    //
    public function roles(){
        return $this->hasMany('App\Role');
    }
}
