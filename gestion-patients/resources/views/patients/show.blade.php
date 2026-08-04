<x-app-layout>
    <x-slot name="header">Fiche patient — {{ $patient->nom }} {{ $patient->prenom }}</x-slot>

    <div x-data="{ showAntecedent: false, showConsultation: false, showEditPatient: false }" class="space-y-6">

        @if (session('success'))
            <div class="p-4 rounded-lg bg-primary/10 text-primary text-sm">{{ session('success') }}</div>
        @endif

        {{-- Boutons PDF --}}
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('patients.pdf', $patient) }}"
               class="inline-flex h-9 items-center gap-2 rounded-md border border-border bg-card px-3 text-sm font-medium hover:bg-secondary transition-colors">
                <iconify-icon icon="solar:download-linear" width="16"></iconify-icon>
                Télécharger la fiche PDF
            </a>

            <form method="POST" action="{{ route('patients.send-pdf', $patient) }}" class="flex items-center gap-2">
                @csrf
                <select name="medecin_id" class="h-9 rounded-lg border border-border bg-card px-2 text-sm" required>
                    <option value="">Envoyer à...</option>
                    @foreach (\App\Models\User::where('role', 'medecin')->get() as $medecin)
                        <option value="{{ $medecin->id }}">Dr. {{ $medecin->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex h-9 items-center gap-2 rounded-md bg-primary px-3 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                    Envoyer par email
                </button>
            </form>
        </div>

        {{-- Informations générales --}}
        <section class="rounded-xl border border-border/70 bg-card p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="font-display text-lg font-semibold text-foreground">Informations générales</h3>
                <button @click="showEditPatient = true"
        class="inline-flex h-8 items-center gap-2 rounded-md border border-border px-3 text-sm font-medium hover:bg-secondary transition-colors">
    Modifier
</button>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="font-medium text-foreground">Nom :</span> <span class="text-muted-foreground">{{ $patient->nom }} {{ $patient->prenom }}</span></div>
                <div><span class="font-medium text-foreground">Téléphone :</span> <span class="text-muted-foreground">{{ $patient->telephone }}</span></div>
                <div><span class="font-medium text-foreground">Numéro CMU :</span> <span class="text-muted-foreground">{{ $patient->numero_cmu ?? '-' }}</span></div>
                <div><span class="font-medium text-foreground">Assurance :</span> <span class="text-muted-foreground">{{ $patient->a_assurance ? 'Oui (' . $patient->numero_assurance . ')' : 'Non' }}</span></div>
                <div><span class="font-medium text-foreground">Date de naissance :</span> <span class="text-muted-foreground">{{ $patient->date_naissance ?? '-' }}</span></div>
                <div><span class="font-medium text-foreground">Sexe :</span> <span class="text-muted-foreground">{{ $patient->sexe ?? '-' }}</span></div>
                <div class="col-span-2"><span class="font-medium text-foreground">Adresse :</span> <span class="text-muted-foreground">{{ $patient->adresse ?? '-' }}</span></div>
            </div>
        </section>

        {{-- Antécédents --}}
        <section class="rounded-xl border border-border/70 bg-card p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-display text-lg font-semibold text-foreground">Antécédents médicaux</h3>
                <button @click="showAntecedent = true"
                        class="inline-flex h-8 items-center gap-2 rounded-md bg-primary px-3 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                    <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                    Ajouter
                </button>
            </div>

            @forelse ($patient->antecedents as $antecedent)
                <div class="border-t border-border/60 py-3 text-sm">
                    <span class="font-medium text-foreground capitalize">{{ str_replace('_', ' ', $antecedent->type) }}</span>
                    <span class="text-muted-foreground"> — {{ $antecedent->description }}</span>
                    @if ($antecedent->date)
                        <span class="text-muted-foreground text-xs">({{ $antecedent->date }})</span>
                    @endif
                </div>
            @empty
                <p class="text-muted-foreground text-sm">Aucun antécédent enregistré.</p>
            @endforelse
        </section>

        {{-- Historique des consultations --}}
        <section class="rounded-xl border border-border/70 bg-card p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-display text-lg font-semibold text-foreground">Historique des consultations</h3>
                <button @click="showConsultation = true"
                        class="inline-flex h-8 items-center gap-2 rounded-md bg-primary px-3 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                    <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                    Ajouter
                </button>
            </div>

            @forelse ($patient->consultations->sortByDesc('date') as $consultation)
                <div class="border-t border-border/60 py-3 text-sm">
                    <div class="flex justify-between text-muted-foreground text-xs">
                        <span>{{ $consultation->date }}</span>
                        <span>Dr. {{ $consultation->medecin->name }}</span>
                    </div>
                    <p class="mt-1"><span class="font-medium text-foreground">Motif :</span> <span class="text-muted-foreground">{{ $consultation->motif }}</span></p>
                    @if ($consultation->diagnostic)
                        <p><span class="font-medium text-foreground">Diagnostic :</span> <span class="text-muted-foreground">{{ $consultation->diagnostic }}</span></p>
                    @endif
                    @if ($consultation->prescription)
                        <p><span class="font-medium text-foreground">Prescription :</span> <span class="text-muted-foreground">{{ $consultation->prescription }}</span></p>
                    @endif
                </div>
            @empty
                <p class="text-muted-foreground text-sm">Aucune consultation enregistrée pour ce patient.</p>
            @endforelse
        </section>

        <a href="{{ route('patients.index') }}" class="text-primary text-sm font-medium">← Retour à la liste des patients</a>

        {{-- MODAL ANTÉCÉDENT --}}
        <div x-show="showAntecedent" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-foreground/40 backdrop-blur-sm p-4"
             @click.self="showAntecedent = false">
            <div class="w-full max-w-lg rounded-xl bg-card border border-border shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-lg font-semibold">Ajouter un antécédent</h3>
                    <button @click="showAntecedent = false" class="text-muted-foreground hover:text-foreground">
                        <iconify-icon icon="solar:close-circle-linear" width="22"></iconify-icon>
                    </button>
                </div>

                <form method="POST" action="{{ route('antecedents.store', $patient) }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="type" value="Type" />
                        <select id="type" name="type" class="mt-1 block w-full border-border rounded-md">
                            <option value="maladie_chronique">Maladie chronique</option>
                            <option value="allergie">Allergie</option>
                            <option value="chirurgie">Chirurgie</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="date_ant" value="Date (optionnel)" />
                        <x-text-input id="date_ant" name="date" type="date" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-border rounded-md" required></textarea>
                    </div>

                    <div class="flex gap-2 justify-end pt-2">
                        <button type="button" @click="showAntecedent = false"
                                class="h-9 rounded-lg border border-border px-4 text-sm font-medium hover:bg-secondary transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                                class="h-9 rounded-lg bg-primary px-4 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL CONSULTATION --}}
        <div x-show="showConsultation" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-foreground/40 backdrop-blur-sm p-4"
             @click.self="showConsultation = false">
            <div class="w-full max-w-lg rounded-xl bg-card border border-border shadow-xl p-6 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-lg font-semibold">Ajouter une consultation</h3>
                    <button @click="showConsultation = false" class="text-muted-foreground hover:text-foreground">
                        <iconify-icon icon="solar:close-circle-linear" width="22"></iconify-icon>
                    </button>
                </div>

                <form method="POST" action="{{ route('consultations.store', $patient) }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="medecin_id" value="Médecin" />
                        <select id="medecin_id" name="medecin_id" class="mt-1 block w-full border-border rounded-md" required>
                            <option value="">-- Choisir un médecin --</option>
                            @foreach (\App\Models\User::where('role', 'medecin')->get() as $medecin)
                                <option value="{{ $medecin->id }}">{{ $medecin->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="date_cons" value="Date" />
                        <x-text-input id="date_cons" name="date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                    </div>
                    <div>
                        <x-input-label for="motif" value="Motif" />
                        <x-text-input id="motif" name="motif" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="diagnostic" value="Diagnostic (optionnel)" />
                        <textarea id="diagnostic" name="diagnostic" rows="2" class="mt-1 block w-full border-border rounded-md"></textarea>
                    </div>
                    <div>
                        <x-input-label for="prescription" value="Prescription (optionnel)" />
                        <textarea id="prescription" name="prescription" rows="2" class="mt-1 block w-full border-border rounded-md"></textarea>
                    </div>

                    <div class="flex gap-2 justify-end pt-2">
                        <button type="button" @click="showConsultation = false"
                                class="h-9 rounded-lg border border-border px-4 text-sm font-medium hover:bg-secondary transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                                class="h-9 rounded-lg bg-primary px-4 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>