<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\user;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::User();
        $array = Auth::User()->toArray();
        if($user->dateNaissance == null || $user->sexe == null || $user->tel == null || $user->race == null || $user->adresse == null) {
        	$nb = count(array_filter($array));
        	$percent = 100-(((15 - $nb)*100)/15);
        	if($percent !=0) {
	            Session::flash('info', "Votre profil est complété à ".round($percent)."% !");
	            return view('account', compact('user'));
        	}
        }
        else
            return view('account', compact('user'));
    }

    public function edit(Request $request, $id)
    {
    	$this->validate($request, [
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'dateNaissance' => 'required|date',
                'sexe' => 'required|string',
                'tel' => 'required|regex:/[0-9]{10}/',
                'adresse' => 'required|string',
                'email' => 'required|email',
                'race' => 'required|string',
          ]);

        $nom = $request->nom;
        $prenom = $request->prenom;
        $dateNaissance = $request->dateNaissance;
        $sexe = $request->sexe;
        $tel = $request->tel;
        $adresse = $request->adresse;
        $email = $request->email;
        $race = $request->race;

        $user = User::find($id);

        $user->update(['nom' => $nom, 'prenom' => $prenom, 'dateNaissance' => $dateNaissance, 'sexe' => $sexe, 'tel' => $tel, 'adresse' => $adresse, 'email' => $email, 'race' => $race]);

        return back()->with('success', "Votre compte à bien été édité");
    }
}
