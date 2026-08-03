<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Fiche patient — {{ $patient->nom }} {{ $patient->prenom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
                <div class="flex gap-2">
    <a href="{{ route('patients.pdf', $patient) }}">
        <x-secondary-button type="button">Télécharger la fiche PDF</x-secondary-button>
    </a>

    <form method="POST" action="{{ route('patients.send-pdf', $patient) }}" class="flex items-center gap-2">
        @csrf
        <select name="medecin_id" class="border-gray-300 rounded-md text-sm" required>
            <option value="">Envoyer à...</option>
            @foreach (\App\Models\User::where('role', 'medecin')->get() as $medecin)
                <option value="{{ $medecin->id }}">Dr. {{ $medecin->name }}</option>
            @endforeach
        </select>
        <x-primary-button type="submit">Envoyer par email</x-primary-button>
    </form>
</div>
            {{-- Informations générales --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold">Informations générales</h3>
                    <a href="{{ route('patients.edit', $patient) }}">
                        <x-secondary-button type="button">Modifier</x-secondary-button>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="font-medium">Nom :</span> {{ $patient->nom }} {{ $patient->prenom }}</div>
                    <div><span class="font-medium">Téléphone :</span> {{ $patient->telephone }}</div>
                    <div><span class="font-medium">Numéro CMU :</span> {{ $patient->numero_cmu ?? '-' }}</div>
                    <div><span class="font-medium">Assurance :</span>
                        {{ $patient->a_assurance ? 'Oui (' . $patient->numero_assurance . ')' : 'Non' }}
                    </div>
                    <div><span class="font-medium">Date de naissance :</span> {{ $patient->date_naissance ?? '-' }}</div>
                    <div><span class="font-medium">Sexe :</span> {{ $patient->sexe ?? '-' }}</div>
                    <div class="col-span-2"><span class="font-medium">Adresse :</span> {{ $patient->adresse ?? '-' }}</div>
                </div>
            </div>

            {{-- Antécédents --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Antécédents médicaux</h3>

                @forelse ($patient->antecedents as $antecedent)
                    <div class="border-t py-2">
                        <span class="font-medium capitalize">{{ str_replace('_', ' ', $antecedent->type) }}</span>
                        — {{ $antecedent->description }}
                        @if ($antecedent->date)
                            <span class="text-gray-500 text-sm">({{ $antecedent->date }})</span>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Aucun antécédent enregistré.</p>
                @endforelse
            </div>
            <div class="border-t pt-4 mt-4">
    <h4 class="font-medium mb-2">Ajouter un antécédent</h4>
    <form method="POST" action="{{ route('antecedents.store', $patient) }}" class="space-y-3">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="type" value="Type" />
                <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="maladie_chronique">Maladie chronique</option>
                    <option value="allergie">Allergie</option>
                    <option value="chirurgie">Chirurgie</option>
                    <option value="autre">Autre</option>
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="date" value="Date (optionnel)" />
                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" />
            </div>
            <div class="col-span-2">
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>
        </div>
        <x-primary-button type="submit">Ajouter l'antécédent</x-primary-button>
    </form>
</div>

            {{-- Historique des consultations --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Historique des consultations</h3>

                @forelse ($patient->consultations->sortByDesc('date') as $consultation)
                    <div class="border-t py-3">
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>{{ $consultation->date }}</span>
                            <span>Dr. {{ $consultation->medecin->name }}</span>
                        </div>
                        <p><span class="font-medium">Motif :</span> {{ $consultation->motif }}</p>
                        @if ($consultation->diagnostic)
                            <p><span class="font-medium">Diagnostic :</span> {{ $consultation->diagnostic }}</p>
                        @endif
                        @if ($consultation->prescription)
                            <p><span class="font-medium">Prescription :</span> {{ $consultation->prescription }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Aucune consultation enregistrée pour ce patient.</p>
                @endforelse
            </div>
      <div class="border-t pt-4 mt-4">
    <h4 class="font-medium mb-2">Ajouter une consultation</h4>
    <form method="POST" action="{{ route('consultations.store', $patient) }}" class="space-y-3">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="medecin_id" value="Médecin" />
                <select id="medecin_id" name="medecin_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">-- Choisir un médecin --</option>
                    @foreach (\App\Models\User::where('role', 'medecin')->get() as $medecin)
                        <option value="{{ $medecin->id }}">{{ $medecin->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('medecin_id')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="date" value="Date" />
                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                <x-input-error :messages="$errors->get('date')" class="mt-1" />
            </div>

            <div class="col-span-2">
                <x-input-label for="motif" value="Motif" />
                <x-text-input id="motif" name="motif" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('motif')" class="mt-1" />
            </div>

            <div class="col-span-2">
                <x-input-label for="diagnostic" value="Diagnostic (optionnel)" />
                <textarea id="diagnostic" name="diagnostic" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <div class="col-span-2">
                <x-input-label for="prescription" value="Prescription (optionnel)" />
                <textarea id="prescription" name="prescription" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
        </div>
        <x-primary-button type="submit">Enregistrer la consultation</x-primary-button>
    </form>
</div>
            <a href="{{ route('patients.index') }}" class="text-blue-600 text-sm">← Retour à la liste des patients</a>
        </div>
    </div>
</x-app-layout>