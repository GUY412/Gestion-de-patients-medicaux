<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Patients
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <form method="GET" class="flex gap-2">
                        <x-text-input type="text" name="recherche" :value="request('recherche')"
                                      placeholder="Rechercher par téléphone ou CMU" />
                        <x-secondary-button type="submit">
                            Rechercher
                        </x-secondary-button>
                    </form>

                    <a href="{{ route('patients.create') }}">
                        <x-primary-button type="button">
                            + Nouveau patient
                        </x-primary-button>
                    </a>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Nom</th>
                            <th class="px-4 py-2 text-left">Téléphone</th>
                            <th class="px-4 py-2 text-left">CMU</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $patient)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $patient->nom }} {{ $patient->prenom }}</td>
                                <td class="px-4 py-2">{{ $patient->telephone }}</td>
                                <td class="px-4 py-2">{{ $patient->numero_cmu ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-blue-600">Voir</a>
                                    <a href="{{ route('patients.edit', $patient) }}" class="text-yellow-600 ml-2">Modifier</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-4 text-center text-gray-500">Aucun patient trouvé.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $patients->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>