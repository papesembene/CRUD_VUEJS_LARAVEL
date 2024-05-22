<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use PHPUnit\Exception;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try
        {
            $user = new User();
            //dd($request);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password,[
                'rounds'=>12
            ]);
            $user->save();
            return response()->json([
                'status_code'=>200,
                'status_message'=>'l\'utilisateur a ete cree',
                'user'=>$user,
            ]);
        }catch (Exception $e)
        {
            return response()->json($e);
        }



    }
    public function all_users()
    {
        $users = User::all();
        return response()->json([
            'users'=>$users,
        ]);
    }
    public function login(LoginRequest $request)
    {
        if(auth()->attempt($request->only(['email','password'])))
        {
            $user = auth()->user();
            //dd($user);
            //crée un nouveau jeton d'authentification pour l'utilisateur
            //visible uniquement au niveau du BackEnd
            $token = $user->createToken('MY_KEY')
            ->plainTextToken;
            return response()->json([
                'status_code'=>200,
                'status_message'=>'utilisateur connecte',
                'user'=>$user,
                'token'=>$token
            ]);
        }else
        {
            return response()->json([
                'status_code'=>402,
                'status_message'=>'informations non valides ',

            ]);
        }
    }

    public function logout(Request $request)
    {
        // Vérifie que la requête HTTP entrante contient un jeton d'authentification valide
        $token = $request->bearerToken();
        if ($token === null) {
            // Renvoie une réponse d'erreur si la requête HTTP entrante ne contient pas de jeton d'authentification valide
            return response()->json([
                'status_code' => 401,
                'status_message' => 'Jeton d\'authentification manquant ou invalide',
            ]);
        }

        // Vérifie que le jeton d'authentification est associé à un utilisateur dans la base de données
        $tokenRecord = PersonalAccessToken::findToken($token);
        if ($tokenRecord === null) {
            // Renvoie une réponse d'erreur si le jeton d'authentification n'est pas associé à un utilisateur dans la base de données
            return response()->json([
                'status_code' => 401,
                'status_message' => 'Jeton d\'authentification manquant ou invalide',
            ]);
        }

        // Révoque tous les jetons d'authentification de l'utilisateur courant
        $tokenRecord->tokenable->tokens()->delete();

        // Renvoie une réponse de succès
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Deconnexion reussie',
        ]);
    }

}
