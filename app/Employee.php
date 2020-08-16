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
        'forename',
        'surename',
        'role_id',
        'email',
        'www',
    ];
}