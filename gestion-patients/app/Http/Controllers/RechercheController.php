<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $patients = collect();
        $medecins = collect();
        $utilisateurs = collect();

        if ($q) {
            $patients = Patient::where('nom', 'like', "%{$q}%")
                ->orWhere('prenom', 'like', "%{$q}%")
                ->orWhere('telephone', 'like', "%{$q}%")
                ->orWhere('numero_cmu', 'like', "%{$q}%")
                ->get();

            $medecins = User::where('role', 'medecin')
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                          ->orWhere('email', 'like', "%{$q}%");
                })
                ->get();

            $utilisateurs = User::where('role', '!=', 'medecin')
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                          ->orWhere('email', 'like', "%{$q}%");
                })
                ->get();
        }

        return view('recherche.index', compact('q', 'patients', 'medecins', 'utilisateurs'));
    }
}