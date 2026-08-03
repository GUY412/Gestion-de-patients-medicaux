<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\FichePatientMail;
use Illuminate\Support\Facades\Mail;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $recherche = $request->input('recherche');

        $patients = Patient::when($recherche, function ($query, $recherche) {
            $query->where('telephone', 'like', "%{$recherche}%")
                  ->orWhere('numero_cmu', 'like', "%{$recherche}%");
        })->orderBy('nom')->paginate(15);

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'numero_cmu' => 'nullable|string|max:50',
            'a_assurance' => 'boolean',
            'numero_assurance' => 'nullable|string|max:50',
            'date_naissance' => 'nullable|date',
            'sexe' => 'nullable|in:M,F',
            'adresse' => 'nullable|string|max:255',
        ]);

        $patient = Patient::create($validated);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Patient enregistré avec succès.');
    }

    public function show(Patient $patient)
    {
        $patient->load('antecedents', 'consultations.medecin');

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'numero_cmu' => 'nullable|string|max:50',
            'a_assurance' => 'boolean',
            'numero_assurance' => 'nullable|string|max:50',
            'date_naissance' => 'nullable|date',
            'sexe' => 'nullable|in:M,F',
            'adresse' => 'nullable|string|max:255',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Patient mis à jour.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient supprimé.');
    }

    public function downloadPdf(Patient $patient)
{
    $patient->load('antecedents', 'consultations.medecin');
    $pdf = Pdf::loadView('patients.pdf', compact('patient'));

    return $pdf->download('fiche-patient-' . $patient->nom . '.pdf');
}

public function sendPdfToMedecin(Request $request, Patient $patient)
{
    $request->validate(['medecin_id' => 'required|exists:users,id']);

    $medecin = \App\Models\User::findOrFail($request->medecin_id);
    $patient->load('antecedents', 'consultations.medecin');
    $pdf = Pdf::loadView('patients.pdf', compact('patient'));

    Mail::to($medecin->email)->send(new FichePatientMail($patient, $pdf->output()));

    return back()->with('success', 'Fiche envoyée au médecin par email.');
}
}