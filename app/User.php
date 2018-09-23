<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'prenom', 'dateNaissance', 'email', 'password', 'privee', 'sexe', 'tel', 'race', 'adresse'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function amis() {
        return $this->belongsToMany('User', 'ami', 'user_id', 'ami_id');
    }

    public function famille() {
        return $this->belongsToMany('User', 'famille', 'user_id', 'memberFamille_id');
    }

    public function getAge() {
        return Carbon::parse($this->attributes['dateNaissance'])->age;
    }
}
