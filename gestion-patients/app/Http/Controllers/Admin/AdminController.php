<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPatients = Patient::count();
        $consultationsMois = Consultation::whereMonth('date', now()->month)->count();
        $totalMedecins = User::where('role', 'medecin')->count();
        $patientsAssures = Patient::where('a_assurance', true)->count();
        $patientsNonAssures = $totalPatients - $patientsAssures;

        $consultationsParMois = Consultation::selectRaw("MONTH(date) as mois, COUNT(*) as total")
            ->whereYear('date', now()->year)
            ->groupBy('mois')
            ->pluck('total', 'mois');

        $consultationsRecentes = Consultation::with('patient', 'medecin')
            ->latest('date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPatients', 'consultationsMois', 'totalMedecins',
            'patientsAssures', 'patientsNonAssures', 'consultationsParMois', 'consultationsRecentes'
        ));
    }
}