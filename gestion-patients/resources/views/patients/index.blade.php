<x-app-layout>
    <x-slot name="header">Patients</x-slot>

    <div x-data="{
        showCreate: false,
        showEdit: false,
        editing: {}
    }">

        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-primary/10 text-primary text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Barre d'action --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
            <form method="GET" class="flex gap-2">
                <input type="text" name="recherche" value="{{ request('recherche') }}"
                       placeholder="Rechercher par téléphone ou CMU"
                       class="h-9 rounded-lg border border-border bg-card px-3 text-sm focus:outline-none focus:ring-2 focus:ring-ring/30">
                <button type="submit" class="h-9 rounded-lg border border-border bg-card px-3 text-sm font-medium hover:bg-secondary transition-colors">
                    Rechercher
                </button>
            </form>

            <button @click="showCreate = true"
                    class="inline-flex h-9 items-center gap-2 rounded-md bg-primary px-3 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                Nouveau patient
            </button>
        </div>

        {{-- Tableau --}}
        <section class="rounded-xl border border-border/70 bg-card">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border/70 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                        <th class="px-6 py-3">Nom</th>
                        <th class="px-6 py-3">Téléphone</th>
                        <th class="px-6 py-3">CMU</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/60">
                    @forelse ($patients as $patient)
                        <tr class="hover:bg-secondary/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary text-xs font-semibold">
                                        {{ substr($patient->nom, 0, 2) }}
                                    </span>
                                    <span class="font-medium text-foreground">{{ $patient->nom }} {{ $patient->prenom }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-muted-foreground">{{ $patient->telephone }}</td>
                            <td class="px-6 py-4 text-muted-foreground">{{ $patient->numero_cmu ?? '-' }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('patients.show', $patient) }}" class="text-primary font-medium">Voir</a>
                                <button
                                    @click="editing = {
                                        id: {{ $patient->id }},
                                        nom: '{{ addslashes($patient->nom) }}',
                                        prenom: '{{ addslashes($patient->prenom) }}',
                                        telephone: '{{ addslashes($patient->telephone) }}',
                                        numero_cmu: '{{ addslashes($patient->numero_cmu ?? '') }}',
                                        a_assurance: {{ $patient->a_assurance ? 'true' : 'false' }},
                                        numero_assurance: '{{ addslashes($patient->numero_assurance ?? '') }}',
                                        date_naissance: '{{ $patient->date_naissance }}',
                                        sexe: '{{ $patient->sexe }}',
                                        adresse: '{{ addslashes($patient->adresse ?? '') }}'
                                    }; showEdit = true"
                                    class="text-muted-foreground hover:text-foreground font-medium">
                                    Modifier
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-6 text-center text-muted-foreground">Aucun patient trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4">{{ $patients->links() }}</div>
        </section>

        {{-- MODAL CREATE --}}
        <div x-show="showCreate" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-foreground/40 backdrop-blur-sm p-4"
             @click.self="showCreate = false">
            <div class="w-full max-w-2xl rounded-xl bg-card border border-border shadow-xl p-6 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-lg font-semibold">Nouveau patient</h3>
                    <button @click="showCreate = false" class="text-muted-foreground hover:text-foreground">
                        <iconify-icon icon="solar:close-circle-linear" width="22"></iconify-icon>
                    </button>
                </div>

                <form method="POST" action="{{ route('patients.store') }}">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="nom" value="Nom" />
                            <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom')" required />
                        </div>
                        <div>
                            <x-input-label for="prenom" value="Prénom" />
                            <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full" :value="old('prenom')" required />
                        </div>
                        <div>
                            <x-input-label for="telephone" value="Téléphone" />
                            <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full" :value="old('telephone')" required />
                        </div>
                        <div>
                            <x-input-label for="numero_cmu" value="Numéro CMU" />
                            <x-text-input id="numero_cmu" name="numero_cmu" type="text" class="mt-1 block w-full" :value="old('numero_cmu')" />
                        </div>
                        <div>
                            <x-input-label for="date_naissance" value="Date de naissance" />
                            <x-text-input id="date_naissance" name="date_naissance" type="date" class="mt-1 block w-full" :value="old('date_naissance')" />
                        </div>
                        <div>
                            <x-input-label for="sexe" value="Sexe" />
                            <select name="sexe" class="mt-1 block w-full border-border rounded-md">
                                <option value="">-</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <x-input-label for="adresse" value="Adresse" />
                            <x-text-input id="adresse" name="adresse" type="text" class="mt-1 block w-full" :value="old('adresse')" />
                        </div>
                        <div class="col-span-2 flex items-center gap-2">
                            <input type="checkbox" name="a_assurance" value="1" id="a_assurance_create"
                                   x-data @change="$refs.champAssuranceCreate.classList.toggle('hidden')">
                            <x-input-label for="a_assurance_create" value="Le patient a une assurance" class="mb-0" />
                        </div>
                        <div x-ref="champAssuranceCreate" class="col-span-2 hidden">
                            <x-input-label for="numero_assurance" value="Numéro d'assurance" />
                            <x-text-input id="numero_assurance" name="numero_assurance" type="text" class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2 justify-end">
                        <button type="button" @click="showCreate = false"
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

        {{-- MODAL EDIT --}}
        <div x-show="showEdit" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-foreground/40 backdrop-blur-sm p-4"
             @click.self="showEdit = false">
            <div class="w-full max-w-2xl rounded-xl bg-card border border-border shadow-xl p-6 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-lg font-semibold">Modifier le patient</h3>
                    <button @click="showEdit = false" class="text-muted-foreground hover:text-foreground">
                        <iconify-icon icon="solar:close-circle-linear" width="22"></iconify-icon>
                    </button>
                </div>

                <form method="POST" :action="`/patients/${editing.id}`">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Nom" />
                            <input type="text" name="nom" x-model="editing.nom" class="mt-1 block w-full border-border rounded-md" required>
                        </div>
                        <div>
                            <x-input-label value="Prénom" />
                            <input type="text" name="prenom" x-model="editing.prenom" class="mt-1 block w-full border-border rounded-md" required>
                        </div>
                        <div>
                            <x-input-label value="Téléphone" />
                            <input type="text" name="telephone" x-model="editing.telephone" class="mt-1 block w-full border-border rounded-md" required>
                        </div>
                        <div>
                            <x-input-label value="Numéro CMU" />
                            <input type="text" name="numero_cmu" x-model="editing.numero_cmu" class="mt-1 block w-full border-border rounded-md">
                        </div>
                        <div>
                            <x-input-label value="Date de naissance" />
                            <input type="date" name="date_naissance" x-model="editing.date_naissance" class="mt-1 block w-full border-border rounded-md">
                        </div>
                        <div>
                            <x-input-label value="Sexe" />
                            <select name="sexe" x-model="editing.sexe" class="mt-1 block w-full border-border rounded-md">
                                <option value="">-</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <x-input-label value="Adresse" />
                            <input type="text" name="adresse" x-model="editing.adresse" class="mt-1 block w-full border-border rounded-md">
                        </div>
                        <div class="col-span-2 flex items-center gap-2">
                            <input type="checkbox" name="a_assurance" value="1" x-model="editing.a_assurance">
                            <x-input-label value="Le patient a une assurance" class="mb-0" />
                        </div>
                        <div class="col-span-2" x-show="editing.a_assurance">
                            <x-input-label value="Numéro d'assurance" />
                            <input type="text" name="numero_assurance" x-model="editing.numero_assurance" class="mt-1 block w-full border-border rounded-md">
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2 justify-end">
                        <button type="button" @click="showEdit = false"
                                class="h-9 rounded-lg border border-border px-4 text-sm font-medium hover:bg-secondary transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                                class="h-9 rounded-lg bg-primary px-4 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
        {{-- MODAL EDIT PATIENT --}}
<div x-show="showEditPatient" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-foreground/40 backdrop-blur-sm p-4"
     @click.self="showEditPatient = false">
    <div class="w-full max-w-2xl rounded-xl bg-card border border-border shadow-xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-display text-lg font-semibold">Modifier le patient</h3>
            <button @click="showEditPatient = false" class="text-muted-foreground hover:text-foreground">
                <iconify-icon icon="solar:close-circle-linear" width="22"></iconify-icon>
            </button>
        </div>

        <form method="POST" action="{{ route('patients.update', $patient) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label value="Nom" />
                    <x-text-input name="nom" type="text" class="mt-1 block w-full" :value="$patient->nom" required />
                </div>
                <div>
                    <x-input-label value="Prénom" />
                    <x-text-input name="prenom" type="text" class="mt-1 block w-full" :value="$patient->prenom" required />
                </div>
                <div>
                    <x-input-label value="Téléphone" />
                    <x-text-input name="telephone" type="text" class="mt-1 block w-full" :value="$patient->telephone" required />
                </div>
                <div>
                    <x-input-label value="Numéro CMU" />
                    <x-text-input name="numero_cmu" type="text" class="mt-1 block w-full" :value="$patient->numero_cmu" />
                </div>
                <div>
                    <x-input-label value="Date de naissance" />
                    <x-text-input name="date_naissance" type="date" class="mt-1 block w-full" :value="$patient->date_naissance" />
                </div>
                <div>
                    <x-input-label value="Sexe" />
                    <select name="sexe" class="mt-1 block w-full border-border rounded-md">
                        <option value="">-</option>
                        <option value="M" @selected($patient->sexe == 'M')>Masculin</option>
                        <option value="F" @selected($patient->sexe == 'F')>Féminin</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <x-input-label value="Adresse" />
                    <x-text-input name="adresse" type="text" class="mt-1 block w-full" :value="$patient->adresse" />
                </div>
                <div class="col-span-2 flex items-center gap-2">
                    <input type="checkbox" name="a_assurance" value="1" @checked($patient->a_assurance)>
                    <x-input-label value="Le patient a une assurance" class="mb-0" />
                </div>
                <div class="col-span-2">
                    <x-input-label value="Numéro d'assurance" />
                    <x-text-input name="numero_assurance" type="text" class="mt-1 block w-full" :value="$patient->numero_assurance" />
                </div>
            </div>

            <div class="mt-6 flex gap-2 justify-end">
                <button type="button" @click="showEditPatient = false"
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