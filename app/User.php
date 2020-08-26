<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Diese Funktion ruft das Profil des zugehörigen Users von der Tabelle 'employees' ab.
     */
    public function employee()
    {
        return $this->hasOne('App\Employee');
    }
    /**
     * Diese Funktion ruft alle Rollen des zugehörigen Users von der Tabelle 'roles' ab.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    /**
     * Funktion zeigt alle Rollen des Users.
     */
    public function getAllRoles(){
        return $this->roles()->orderBy('id','asc')->get();
    }
}
