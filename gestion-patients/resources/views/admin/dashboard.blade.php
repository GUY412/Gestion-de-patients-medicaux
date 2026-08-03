<x-admin-layout>
    <x-slot name="title">Vue d'ensemble</x-slot>

    {{-- Cartes de stats --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">TOTAL PATIENTS</p>
                    <h3 class="mt-2 text-2xl font-semibold text-slate-900">{{ $totalPatients }}</h3>
                </div>
                <div class="text-emerald-700 bg-emerald-50 rounded-lg p-2">
                    <iconify-icon icon="solar:users-group-rounded-linear" width="20"></iconify-icon>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">CONSULTATIONS CE MOIS</p>
                    <h3 class="mt-2 text-2xl font-semibold text-slate-900">{{ $consultationsMois }}</h3>
                </div>
                <div class="text-emerald-700 bg-emerald-50 rounded-lg p-2">
                    <iconify-icon icon="solar:stethoscope-linear" width="20"></iconify-icon>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">MÉDECINS</p>
                    <h3 class="mt-2 text-2xl font-semibold text-slate-900">{{ $totalMedecins }}</h3>
                </div>
                <div class="text-emerald-700 bg-emerald-50 rounded-lg p-2">
                    <iconify-icon icon="solar:user-id-linear" width="20"></iconify-icon>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">PATIENTS ASSURÉS</p>
                    <h3 class="mt-2 text-2xl font-semibold text-slate-900">{{ $patientsAssures }}</h3>
                </div>
                <div class="text-emerald-700 bg-emerald-50 rounded-lg p-2">
                    <iconify-icon icon="solar:shield-check-linear" width="20"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
            <h3 class="text-base font-semibold text-slate-900 mb-6">Consultations par mois</h3>
            <div class="relative h-64 w-full">
                <canvas id="consultationsChart"></canvas>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-900 mb-6">Assurés vs Non-assurés</h3>
            <div class="relative h-48 w-full flex items-center justify-center">
                <canvas id="assuranceChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Consultations récentes --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <h3 class="text-base font-semibold text-slate-900">Consultations récentes</h3>
        </div>
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50/50 text-xs font-medium uppercase text-slate-500">
                    <th class="p-4">Patient</th>
                    <th class="p-4">Médecin</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Motif</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse ($consultationsRecentes as $c)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-medium text-slate-900">{{ $c->patient->nom }} {{ $c->patient->prenom }}</td>
                        <td class="p-4 text-slate-500">Dr. {{ $c->medecin->name }}</td>
                        <td class="p-4 text-slate-500">{{ $c->date }}</td>
                        <td class="p-4 text-slate-500">{{ $c->motif }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-4 text-center text-slate-400">Aucune consultation enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        const consultationsData = @json($consultationsParMois);
        const mois = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
        const dataParMois = mois.map((_, i) => consultationsData[i + 1] ?? 0);

        new Chart(document.getElementById('consultationsChart'), {
            type: 'line',
            data: {
                labels: mois,
                datasets: [{
                    label: 'Consultations',
                    data: dataParMois,
                    borderColor: '#059669',
                    backgroundColor: 'rgba(5, 150, 105, 0.1)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('assuranceChart'), {
            type: 'doughnut',
            data: {
                labels: ['Assurés', 'Non-assurés'],
                datasets: [{
                    data: [{{ $patientsAssures }}, {{ $patientsNonAssures }}],
                    backgroundColor: ['#059669', '#d1fae5'],
                    borderWidth: 0,
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom' } } }
        });
    </script>
</x-admin-layout>