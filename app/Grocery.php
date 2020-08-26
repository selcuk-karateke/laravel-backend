<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grocery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'price',
    ];
}
