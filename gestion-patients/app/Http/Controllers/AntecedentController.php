<?php

namespace App\Http\Controllers;

use App\Models\Antecedent;
use App\Models\Patient;
use Illuminate\Http\Request;

class AntecedentController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'type' => 'required|in:maladie_chronique,allergie,chirurgie,autre',
            'description' => 'required|string',
            'date' => 'nullable|date',
        ]);

        $patient->antecedents()->create($validated);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Antécédent ajouté.');
    }

    public function destroy(Patient $patient, Antecedent $antecedent)
    {
        $antecedent->delete();

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Antécédent supprimé.');
    }
}