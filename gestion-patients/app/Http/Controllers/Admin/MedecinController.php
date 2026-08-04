<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MedecinController extends Controller
{
    public function index()
    {
        $medecins = User::where('role', 'medecin')->orderBy('name')->paginate(15);
        return view('admin.medecins.index', compact('medecins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'medecin';

        User::create($validated);

        return redirect()->route('admin.medecins.index')
            ->with('success', 'Médecin ajouté avec succès.');
    }

    public function update(Request $request, User $medecin)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $medecin->id,
    ]);

    $medecin->update($validated);

    return redirect()->route('admin.medecins.index')
        ->with('success', 'Médecin mis à jour.');
}

    public function destroy(User $medecin)
    {
        $medecin->delete();

        return redirect()->route('admin.medecins.index')
            ->with('success', 'Médecin supprimé.');
    }
}