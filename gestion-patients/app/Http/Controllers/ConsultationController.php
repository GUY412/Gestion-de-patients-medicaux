<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'motif' => 'required|string|max:255',
            'diagnostic' => 'nullable|string',
            'prescription' => 'nullable|string',
        ]);

        $validated['medecin_id'] = auth()->id();

        $patient->consultations()->create($validated);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Consultation enregistrée.');
    }

    public function destroy(Patient $patient, Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Consultation supprimée.');
    }
}