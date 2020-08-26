<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    //
    use SoftDeletes;

    //
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'from_api',
        'description',
        'shortcut',
//        'employee_id',
        'estimated_hours',
        'actual_hours',
        'start',
        'dead',
    ];
    //
    public function employees(){
        return $this->belongsToMany('App\Employee');
    }
}
