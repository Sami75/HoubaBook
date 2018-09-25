<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::User();
        $array = Auth::User()->toArray();


        if($user->dateNaissance == null || $user->sexe == null || $user->tel == null || $user->race == null || $user->adresse == null) {

        	$nb = count(array_filter($array));
        	$percent = 100-(((12 - $nb)*100)/12);

        	if($percent !=0) {
	            Session::flash('info', "Votre profil est complété à ".round($percent)."% !");
	            return view('account', compact('user', 'percent'));
        	}
        }
        else
            return view('account', compact('user', 'percent'));
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
        $privee = $request->privee;

        $user = User::find($id);

        $user->update(['nom' => $nom, 'prenom' => $prenom, 'dateNaissance' => $dateNaissance, 'privee' => $privee, 'sexe' => $sexe, 'tel' => $tel, 'adresse' => $adresse, 'email' => $email, 'race' => $race]);

        return back()->with('success', "Votre compte à bien été édité");
    }

    public function show($id) {

    	$user = User::find($id);

        $array = $user->toArray();
        $nb = count(array_filter($array));
        $percent = 100-(((12 - $nb)*100)/12);

         return view('detailUser ', compact('user', 'percent'));

    }

    public function send($id) {

        $userFriend = User::find($id); 
        $user = Auth::User();
        $users = User::All();

        $user->addAmis($userFriend);
        Session::flash('success', 'Votre demande d\'invitation a été envoyé!');

        return view('welcome', compact('users'));
    }

    public function delete($id) {

        $userFriend = User::find($id); 
        $user = Auth::User();
        $users = User::all();

        $user->removeAmis($userFriend);
        Session::flash('success', $userFriend->nom.' '.$userFriend->prenom. ' a été retiré de votre liste d\'amis!');

        return view('welcome', compact('users'));
    }

    public function accept($id) {

        $userFriend = User::find($id); 
        $user = Auth::User();
        $users = User::all();

        $user->acceptFriend($userFriend);

        Session::flash('success', $userFriend->nom.' '.$userFriend->prenom. ' a rejoint votre liste d\'amis!');

        return view('welcome', compact('users'));
    }
}