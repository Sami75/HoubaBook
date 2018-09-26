<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Auth;

class UserController extends Controller
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

    /** Fonction permettant l'affichage de la page account de l'utilisateur connecté **/
    public function index()
    {
        $user = Auth::User();
        $array = Auth::User()->toArray();

        $nb = count(array_filter($array));
        $percent = 100-(((12 - $nb)*100)/12);

        if($user->dateNaissance == null || $user->sexe == null || $user->tel == null || $user->race == null || $user->adresse == null) {

        	if($percent !=0) {
	            Session::flash('info', "Votre profil est complété à ".round($percent)."% !");
	            return view('account', compact('user', 'percent'));
        	}
        }
        else
            return view('account', compact('user', 'percent'));
    }

    /** Fonction qui verfie la validité des champs, et qui édite par la suite le profil de l'utilisateur connecté **/
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

    /** Fonction qui affiche le profil de l'utilisateur selectionné **/
    public function show($id) {

    	$user = User::find($id);

        $array = $user->toArray();
        $nb = count(array_filter($array));
        $percent = 100-(((12 - $nb)*100)/12);

         return view('detailUser ', compact('user', 'percent'));

    }

    /** Fonction qui permet la demande d'invitation **/
    public function send($id) {

        $userFriend = User::find($id); 
        $user = Auth::User();
        $users = User::All();

        $user->addAmis($userFriend);
        Session::flash('success', 'Votre demande d\'invitation a été envoyé!');

        return view('welcome', compact('users'));
    }

    /** Fonction qui permet la supression d'un ami **/
    public function delete($id) {

        $userFriend = User::find($id); 
        $user = Auth::User();
        $users = User::all();

        $user->removeAmis($userFriend);
        Session::flash('success', $userFriend->nom.' '.$userFriend->prenom. ' a été retiré de votre liste d\'amis!');

        return view('welcome', compact('users'));
    }

    /** Fonction qui permet la supression d'une demande d'invitation **/
    public function refuse($id) {

        $userFriend = User::find($id); 
        $user = Auth::User();
        $users = User::all();

        $user->refuseAmis($userFriend);
        Session::flash('success', 'Vous avez refusé, la demande d\'invitation de ' .$userFriend->nom.' '.$userFriend->prenom);

        return view('welcome', compact('users'));
    }

    /** Fonction qui annule la demande d'invitation **/
    public function annuler($id) {

        $userFriend = User::find($id); 
        $user = Auth::User();
        $users = User::all();

        $user->refuseAmis($userFriend);
        Session::flash('success', 'Vous avez annulé, votre demande d\'invitation');

        return view('welcome', compact('users'));
    }

    /** Fonction qui permet de changer le status lorsque l'utilisateur clic sur "accepter" **/
    public function accept($id) {

        $userFriend = User::find($id); 
        $user = Auth::User();
        $users = User::all();

        $user->acceptFriend($userFriend);

        Session::flash('success', $userFriend->nom.' '.$userFriend->prenom. ' a rejoint votre liste d\'amis!');

        return view('welcome', compact('users'));
    }

    /** Fonction qui permet l'ajout d'un nouvel utilisateur, le compte est inactif, lorsque l'utilisateur se connecte, le champs actif passe à 1 **/
    public function newUserAmis(Request $request) {

        $this->validate($request, [
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'email' => 'required|email',
          ]);

        $nom = $request->nom;
        $prenom = $request->prenom;
        $email = $request->email;
        $password = '123456';
        $actif = 0;

        $userCreated = User::create([
            
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => bcrypt($password),
            'actif' => $actif,

        ]);
        Auth::User()->addAmis($userCreated);

        return back();
    }
}