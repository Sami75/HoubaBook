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
        if($user->dateNaissance == null || $user->sexe == null || $user->tel == null || $user->race == null || $user->adresse == null) {
            $nb = count(array_filter($array));
            $percent = 100-(((15 - $nb)*100)/15);
            if($percent !=0) {
                Session::flash('info', "Votre profil est complété à ".round($percent)."% ! Consultez l'onglet Mon Compte, pour pouvoir le completé");
                return view('welcome');
            }
        }
        else
            return view('welcome');
    }
}
