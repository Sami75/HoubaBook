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
        'nom', 'prenom', 'dateNaissance', 'email', 'password', 'privee', 'sexe', 'tel', 'race', 'adresse', 'actif'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /** Relation many-to-many permettant l'enregistrement des invitations/liste d'amis, la table invitation devient une table pivot **/
    public function amis() {
        return $this->belongsToMany('App\User', 'invitation', 'emetteur_id', 'recepteur_id');
    }

    /** Fonction permettant de recuperer l'âge de l'user **/
    public function getAge() {
        return Carbon::parse($this->attributes['dateNaissance'])->age;
    }

    /** Fonction permettant l'ajout d'amis, par defaut le status est égal à 0, cela signifie que l'invitation est envoyé, lorsqu'il est égal à 1, cela signifie que l'utilisateur à accepter la demande d'ajout **/
    public function addAmis(User $user) {
        $this->amis()->attach($user->id);
    }

    /** Fonction qui permet la suppression d'amis **/
    public function removeAmis(User $user) {
        $user->amis()->detach($this->id);
        $this->amis()->detach($user->id);
    }

    /** Fonction qui permet de recuperer les utilisateur qui ont fais une demande d'ajout d'ami **/
    public function invitations() {

        return DB::table('invitation')
            ->where('recepteur_id', Auth::User()->id)
            ->where('status', 0)
            ->get();
    }

    /** Fonction qui verifie si l'utilisateur est celui qui a fait la demande d'ami, renvoie true or false **/
    public function invitationsEnvoyer() {
        
        return DB::table('invitation')
            ->where('emetteur_id', Auth::User()->id)
            ->where('recepteur_id', $this->id)
            ->where('status', 0)
            ->exists();

    }

    /** Fonction qui verifie si l'utilisateur est celui qui recois la demande d'ami, renvoie true or false **/
    public function invitationsRecus() {
        
        return DB::table('invitation')
            ->where('emetteur_id', $this->id)
            ->where('recepteur_id', Auth::User()->id)
            ->where('status', 0)
            ->exists();

    }

    /** Fonction qui met a jour le status lorque l'utilisateur accepte une demande d'ami **/
    public function acceptFriend(User $userFriend) {

        DB::table('invitation')
            ->where('emetteur_id', $userFriend->id)
            ->where('recepteur_id', $this->id)
            ->update(['status' => 1]);
    }

    /** Fonction qui verifie si l'utilisateur connecté est ami avec les autres utilisateurs, renvoie true or false **/
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

    /** Fonction qui renvoie une collection contenant les utilisateur qui ne sont pas ami avec l'utilsateur connecté **/
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

    /** Fonction qui permet de refuser une invitation **/
    public function refuseAmis(User $user) {
        return DB::table('invitation')
            ->where('status', 0)
            ->where('recepteur_id', $user->id)
            ->where('emetteur_id', $this->id)
            ->orwhere('emetteur_id', $user->id)
            ->Where('recepteur_id', $this->id)
            ->delete();

    }

    /** Fonction qui rend le compte d'un utilisateur invité à rejoindre HoubaBook actif, lorsqu'il se connecte **/
    public function actifUser() {
        $this->actif = 1;
       return  $this->save();
    }
}
