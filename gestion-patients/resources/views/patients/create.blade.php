<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouveau patient
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('patients.store') }}">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="nom" value="Nom" />
                            <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom')" required />
                            <x-input-error :messages="$errors->get('nom')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="prenom" value="Prénom" />
                            <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full" :value="old('prenom')" required />
                            <x-input-error :messages="$errors->get('prenom')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="telephone" value="Téléphone" />
                            <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full" :value="old('telephone')" required />
                            <x-input-error :messages="$errors->get('telephone')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="numero_cmu" value="Numéro CMU" />
                            <x-text-input id="numero_cmu" name="numero_cmu" type="text" class="mt-1 block w-full" :value="old('numero_cmu')" />
                            <x-input-error :messages="$errors->get('numero_cmu')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="date_naissance" value="Date de naissance" />
                            <x-text-input id="date_naissance" name="date_naissance" type="date" class="mt-1 block w-full" :value="old('date_naissance')" />
                            <x-input-error :messages="$errors->get('date_naissance')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="sexe" value="Sexe" />
                            <select id="sexe" name="sexe" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-</option>
                                <option value="M" @selected(old('sexe') == 'M')>Masculin</option>
                                <option value="F" @selected(old('sexe') == 'F')>Féminin</option>
                            </select>
                            <x-input-error :messages="$errors->get('sexe')" class="mt-1" />
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="adresse" value="Adresse" />
                            <x-text-input id="adresse" name="adresse" type="text" class="mt-1 block w-full" :value="old('adresse')" />
                            <x-input-error :messages="$errors->get('adresse')" class="mt-1" />
                        </div>

                        <div class="col-span-2 flex items-center gap-2">
                            <input type="checkbox" name="a_assurance" value="1" id="a_assurance"
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm"
                                   onchange="document.getElementById('champ_assurance').classList.toggle('hidden')">
                            <x-input-label for="a_assurance" value="Le patient a une assurance" class="mb-0" />
                        </div>

                        <div id="champ_assurance" class="col-span-2 hidden">
                            <x-input-label for="numero_assurance" value="Numéro d'assurance" />
                            <x-text-input id="numero_assurance" name="numero_assurance" type="text" class="mt-1 block w-full" :value="old('numero_assurance')" />
                            <x-input-error :messages="$errors->get('numero_assurance')" class="mt-1" />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2">
                        <x-primary-button type="submit">Enregistrer</x-primary-button>
                        <a href="{{ route('patients.index') }}">
                            <x-secondary-button type="button">Annuler</x-secondary-button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>