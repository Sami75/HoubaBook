<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use DB;
use Auth;

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
        return $this->belongsToMany('App\User', 'invitation', 'emetteur_id', 'recepteur_id');
    }

    public function famille() {
        return $this->belongsToMany('User', 'famille', 'user_id', 'memberFamille_id', 'action');
    }

    public function getAge() {
        return Carbon::parse($this->attributes['dateNaissance'])->age;
    }

    public function addAmis(User $user) {
        $this->amis()->attach($user->id);
    }

    public function removeAmis(User $user) {
        $this->amis()->detach($user->id);
    }

    public function newAmis() {
        return DB::table('invitation')
            ->where('recepteur_id', '=', $this->id)
            ->where('emetteur_id', '=', $this->id)
            ->get();
    }

    public function invitations() {

        return DB::table('invitation')
            ->where('recepteur_id', Auth::User()->id)
            ->where('status', 0)
            ->get();
    }


    public function invitationsEnvoyer() {
        
        return DB::table('invitation')
            ->where('emetteur_id', Auth::User()->id)
            ->where('recepteur_id', $this->id)
            ->where('status', 0)
            ->exists();

    }

    public function invitationsRecus() {
        
        return DB::table('invitation')
            ->where('emetteur_id', $this->id)
            ->where('recepteur_id', Auth::User()->id)
            ->where('status', 0)
            ->exists();

    }

    public function getFullName() {
        return $this->prenom . ' ' . $this->nom;
    }

    public function acceptFriend(User $userFriend) {

        DB::table('invitation')
            ->where('emetteur_id', $userFriend->id)
            ->where('recepteur_id', $this->id)
            ->update(['status' => 1]);
    }

    public function myFriend() {

        return DB::table('invitation')
                ->where('status', 1)
                ->where(function ($query) {
                    $query->where('emetteur_id', $this->id)
                          ->Where('recepteur_id', Auth::User()->id)
                          ->orwhere('emetteur_id', Auth::User()->id)
                          ->Where('recepteur_id', $this->id);
                      })
                ->exists();
    }

    public function nbMyFriend() {

        return DB::table('invitation')
                ->where('status', 1)
                ->where(function ($query) {
                    $query
                          ->Where('recepteur_id', Auth::User()->id)
                          ->orwhere('emetteur_id', Auth::User()->id);
                      })
                ->get();
    }
}
