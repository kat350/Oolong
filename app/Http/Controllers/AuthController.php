<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // gere connexion/deconnexion
use Illuminate\Support\Facades\Hash;  // chiffre les mots de passe

class AuthController extends Controller
{
    // affiche page connexion
    public function showLogin()
    {
        return view('connexion');
    }

    // traite le formulaire de connexion quand on clique sur "Se connecter"
    public function login(Request $request)
    {
        // Verif email et mot de passe bien rempli
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Verif email et compare mdp avec celui en db
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect()->intended('/taches');
        }

        // if identifiants pas bons on renvoie au formulaire avec message d'erreur
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email'); //garde juste email
    }

    // affiche page inscription
    public function showRegister()
    {
        return view('inscription');
    }

    // traite formulaire inscription quand on clique "creer mon compte"
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users', // verifie que email pas utilisé
            'password' => 'required|min:6|confirmed',    // confirme ça
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // hash le mdp
        ]);

        // connecte l'utilisateur
        Auth::login($user);

        return redirect('/taches');
    }

    // deco utilisateur
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
