<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\user;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
        $array = Auth::User()->toArray();
        $users = User::all();

        /** On vérifie si l'utilisateur a completé son profil **/
        if($user->dateNaissance == null || $user->sexe == null || $user->tel == null || $user->race == null || $user->adresse == null) {

            /** On compte le nombre de champ rempli par l'utilisateur **/
            $nb = count(array_filter($array));
            $percent = 100-(((12 - $nb)*100)/12); //On calcul le pourcentage

            if($percent !=0) { //Si le pourcentage n'atteint pas les 100% on affiche un message flash.

                $msg = 'Votre profil est complété à '.round($percent).'% ! Consultez l\'onglet <a href='.url('/account').'>Mon Compte</a>, pour pouvoir le completer';

                Session::flash('info', $msg);

                return view('welcome', compact('users'));
            }
        }
        else
            return view('welcome', compact('users'));
    }

    /** Fonction permettant la recherche d'utilisateur **/
    public function search(Request $request) {

        $search = $request->search;

        //On cherche les utilisateur, où la variable est contenu dans son nom ou prenom
        if($search != "") {
            $users = User::where('id', '!=', Auth::User()->id)
            ->where('nom', 'LIKE', '%' .$search. '%')
            ->orWhere('prenom', 'LIKE', '%' .$search. '%')
            ->get();                
        }

        //Si la collection $users n'est pas vide, on envoie la collection, sinon on affiche un message flash qui indique qu'aucun utilisateur n'a été trouvé
        if(count($users) > 0) 
            return view('search', compact('users'))->withDetails($users)->withQuery($search);
        else {
            Session::flash('warning', "Houba Houba ! Aucun Marsupilami n'a été trouvé ! Veuillez renouveller votre recherche.");
            return view('search', compact('users'));
        }
    }
}
