<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\User;

class UserController extends Controller
{
    public function signup(Request $request) {

        $this->validate($request, [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $actif = 1;
        $user = new User([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'actif' => $actif,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        return response()->json([
            'message' => 'Votre compte a été créé'], 201);

    }

    public function signin(Request $request) {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        try {
            if(!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'L\'email, et le mot de passe sont incorrect!'], 401);
            }
        } catch(JWTException $e) {
            return response()->json([
                'error' => 'Le token n\'a pas pu être créé.'], 500);
        }
        //User::whereEmail($request->email)->update(['remember_token' => $token]);
        return response()->json(['token' => $token], 200);

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

        if(!$user) {
            return response()->json(['message' => 'L\'utilisateur n\'a pas été trouvé.'], 404);
        }

        $user->update(['nom' => $nom, 'prenom' => $prenom, 'dateNaissance' => $dateNaissance, 'privee' => $privee, 'sexe' => $sexe, 'tel' => $tel, 'adresse' => $adresse, 'email' => $email, 'race' => $race]);

        return response()->json(['user' => $user], 200);
    }

    /** Fonction qui permet la demande d'invitation **/
    public function send($id) {

        $userFriend = User::find($id); 
        $user = JWTAuth::parseToken()->toUser();

        $user->addAmis($userFriend);

        return response()->json(['message' => 'Votre demande d\'invitation à été envoyé.'], 201);
    }

    public function getUsers() {
        
        $users = User::all();

        $response = [
            'users' => $users
        ];

        return response()->json($response, 200);
    }

    public function getUser($id) {
        
        $user = User::find($id);

        $response = [
            'user' => $user
        ];

        return response()->json($response, 200);
    }

    /** Fonction qui permet la supression d'un ami **/
    public function delete($id) {

        $userFriend = User::find($id); 
        $user = JWTAuth::parseToken()->toUser();

        $user->removeAmis($userFriend);

        return response()->json(['message' => $userFriend->prenom. ' '. $userFriend->nom. ' a été retiré de votre liste d\'amis!'], 200);
    }

    /** Fonction qui permet la supression d'une demande d'invitation **/
    public function refuse($id) {

        $userFriend = User::find($id); 
        $user = JWTAuth::parseToken()->toUser();

        $user->refuseAmis($userFriend);

        return response()->json(['message' => 'La demande d\'invitation de ' .$userFriend->nom.' '.$userFriend->prenom. 'a été décliné.'], 200);
    }

    /** Fonction qui annule la demande d'invitation **/
    public function annuler($id) {

        $userFriend = User::find($id); 
        $user = JWTAuth::parseToken()->toUser();
        $users = User::all();

        $user->refuseAmis($userFriend);

        return response()->json(['message' => 'La demande d\'invitation a été annulé.'], 200);
    }

    /** Fonction qui permet de changer le status lorsque l'utilisateur clic sur "accepter" **/
    public function accept($id) {

        $userFriend = User::find($id); 
        $user = JWTAuth::parseToken()->toUser();
        $users = User::all();

        $user->acceptFriend($userFriend);

        return response()->json(['message' => 'L\'utilisateur à rejoint votre liste d\'amis!']);
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
        JWTAuth::parseToken()->toUser()->addAmis($userCreated);

        return response()->json(['message' => 'Votre demande d\'invitation à rejoindre HoubaBook, été envoyé.'], 201);
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
            return response()->json(['users' => $users], 200);
        else {
            return response()->json(['message' => "Houba Houba ! Aucun Marsupilami n'a été trouvé ! Veuillez renouveller votre recherche."], 404);
        }
    }
}