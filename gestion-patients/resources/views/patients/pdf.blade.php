<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { font-size: 18px; }
        h2 { font-size: 14px; margin-top: 20px; border-bottom: 1px solid #ccc; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        td { padding: 4px; vertical-align: top; }
        .label { font-weight: bold; width: 150px; }
    </style>
</head>
<body>
    <h1>Fiche patient — {{ $patient->nom }} {{ $patient->prenom }}</h1>

    <h2>Informations générales</h2>
    <table>
        <tr><td class="label">Téléphone</td><td>{{ $patient->telephone }}</td></tr>
        <tr><td class="label">Numéro CMU</td><td>{{ $patient->numero_cmu ?? '-' }}</td></tr>
        <tr><td class="label">Assurance</td><td>{{ $patient->a_assurance ? 'Oui (' . $patient->numero_assurance . ')' : 'Non' }}</td></tr>
        <tr><td class="label">Date de naissance</td><td>{{ $patient->date_naissance ?? '-' }}</td></tr>
        <tr><td class="label">Sexe</td><td>{{ $patient->sexe ?? '-' }}</td></tr>
        <tr><td class="label">Adresse</td><td>{{ $patient->adresse ?? '-' }}</td></tr>
    </table>

    <h2>Antécédents médicaux</h2>
    @forelse ($patient->antecedents as $a)
        <p>- {{ str_replace('_', ' ', $a->type) }} : {{ $a->description }} @if($a->date) ({{ $a->date }}) @endif</p>
    @empty
        <p>Aucun antécédent enregistré.</p>
    @endforelse

    <h2>Historique des consultations</h2>
    @forelse ($patient->consultations->sortByDesc('date') as $c)
        <p>
            <strong>{{ $c->date }}</strong> — Dr. {{ $c->medecin->name }}<br>
            Motif : {{ $c->motif }}<br>
            @if($c->diagnostic) Diagnostic : {{ $c->diagnostic }}<br> @endif
            @if($c->prescription) Prescription : {{ $c->prescription }} @endif
        </p>
    @empty
        <p>Aucune consultation enregistrée.</p>
    @endforelse
</body>
</html>