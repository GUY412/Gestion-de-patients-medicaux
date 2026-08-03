<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Actions rapides --}}
            <div class="flex gap-3">
                <a href="{{ route('patients.create') }}">
                    <x-primary-button type="button">+ Nouveau patient</x-primary-button>
                </a>
                <a href="{{ route('patients.index') }}">
                    <x-secondary-button type="button">Rechercher un patient</x-secondary-button>
                </a>
            </div>

            {{-- Stats du jour --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <p class="text-xs font-medium text-gray-500">PATIENTS ENREGISTRÉS AUJOURD'HUI</p>
                    <h3 class="mt-2 text-2xl font-semibold text-gray-900">{{ $patientsAujourdhui }}</h3>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <p class="text-xs font-medium text-gray-500">CONSULTATIONS AUJOURD'HUI</p>
                    <h3 class="mt-2 text-2xl font-semibold text-gray-900">{{ $consultationsAujourdhui }}</h3>
                </div>
            </div>

            {{-- Derniers patients --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="font-semibold text-gray-900">Derniers patients enregistrés</h3>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($derniersPatients as $patient)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 font-medium text-gray-900">{{ $patient->nom }} {{ $patient->prenom }}</td>
                                <td class="p-4 text-gray-500">{{ $patient->telephone }}</td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-emerald-700">Voir la fiche</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="p-4 text-center text-gray-400">Aucun patient enregistré.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>