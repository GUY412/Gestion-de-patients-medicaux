<x-admin-layout>
    <x-slot name="title">Vue d'ensemble</x-slot>

    {{-- Cartes KPI --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="relative overflow-hidden rounded-xl border border-border/70 bg-card py-5 pl-8 pr-5">
            <p class="text-sm font-medium text-muted-foreground">Total patients</p>
            <p class="mt-2 font-display text-2xl font-semibold tracking-tight text-foreground">{{ $totalPatients }}</p>
            <div class="mt-3 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-2 py-0.5 text-xs font-medium text-primary">
                    <iconify-icon icon="solar:users-group-rounded-linear" width="12"></iconify-icon>
                    Enregistrés
                </span>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-border/70 bg-card py-5 pl-8 pr-5">
            <p class="text-sm font-medium text-muted-foreground">Consultations ce mois</p>
            <p class="mt-2 font-display text-2xl font-semibold tracking-tight text-foreground">{{ $consultationsMois }}</p>
            <div class="mt-3 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-2 py-0.5 text-xs font-medium text-primary">
                    <iconify-icon icon="solar:stethoscope-linear" width="12"></iconify-icon>
                    Ce mois-ci
                </span>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-border/70 bg-card py-5 pl-8 pr-5">
            <p class="text-sm font-medium text-muted-foreground">Médecins</p>
            <p class="mt-2 font-display text-2xl font-semibold tracking-tight text-foreground">{{ $totalMedecins }}</p>
            <div class="mt-3 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 rounded-full bg-secondary px-2 py-0.5 text-xs font-medium text-secondary-foreground">
                    <iconify-icon icon="solar:user-id-linear" width="12"></iconify-icon>
                    Actifs
                </span>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-border/70 bg-card py-5 pl-8 pr-5">
            <p class="text-sm font-medium text-muted-foreground">Patients assurés</p>
            <p class="mt-2 font-display text-2xl font-semibold tracking-tight text-foreground">{{ $patientsAssures }}</p>
            <div class="mt-3 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-2 py-0.5 text-xs font-medium text-primary">
                    <iconify-icon icon="solar:shield-check-linear" width="12"></iconify-icon>
                    Avec CMU/assurance
                </span>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <section class="xl:col-span-2 rounded-xl border border-border/70 bg-card p-5 sm:p-6">
            <header class="flex items-start justify-between">
                <div>
                    <h2 class="font-display text-base font-semibold tracking-tight text-foreground">Consultations par mois</h2>
                    <p class="mt-1 text-sm text-muted-foreground">Évolution sur l'année {{ now()->year }}</p>
                </div>
            </header>
            <div class="relative mt-6 h-72 w-full">
                <canvas id="consultationsChart"></canvas>
            </div>
        </section>

        <section class="rounded-xl border border-border/70 bg-card p-5 sm:p-6">
            <header>
                <h2 class="font-display text-base font-semibold tracking-tight text-foreground">Assurés vs non-assurés</h2>
                <p class="mt-1 text-sm text-muted-foreground">Répartition des patients</p>
            </header>
            <div class="relative mt-4 h-52 w-full flex items-center justify-center">
                <canvas id="assuranceChart"></canvas>
            </div>
            <ul class="mt-6 space-y-3 text-sm">
                <li class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-2 text-muted-foreground">
                        <span class="h-2 w-2 rounded-full bg-primary"></span> Assurés
                    </span>
                    <span class="font-medium text-foreground">{{ $patientsAssures }}</span>
                </li>
                <li class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-2 text-muted-foreground">
                        <span class="h-2 w-2 rounded-full bg-secondary"></span> Non-assurés
                    </span>
                    <span class="font-medium text-foreground">{{ $patientsNonAssures }}</span>
                </li>
            </ul>
        </section>
    </div>

    {{-- Consultations récentes --}}
    <section class="rounded-xl border border-border/70 bg-card">
        <header class="flex items-center justify-between border-b border-border/70 px-6 py-4">
            <div>
                <h2 class="font-display text-base font-semibold tracking-tight text-foreground">Consultations récentes</h2>
                <p class="mt-1 text-sm text-muted-foreground">Dernières fiches enregistrées</p>
            </div>
        </header>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border/70 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                        <th class="px-6 py-3">Patient</th>
                        <th class="px-6 py-3">Médecin</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Motif</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/60">
                    @forelse ($consultationsRecentes as $c)
                        <tr class="hover:bg-secondary/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary text-xs font-semibold">
                                        {{ substr($c->patient->nom, 0, 2) }}
                                    </span>
                                    <span class="font-medium text-foreground">{{ $c->patient->nom }} {{ $c->patient->prenom }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-muted-foreground">Dr. {{ $c->medecin->name }}</td>
                            <td class="px-6 py-4 text-muted-foreground font-mono">{{ $c->date }}</td>
                            <td class="px-6 py-4 text-muted-foreground">{{ $c->motif }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-6 text-center text-muted-foreground">Aucune consultation enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

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
                    borderColor: 'rgb(6, 95, 70)',
                    backgroundColor: 'rgba(6, 95, 70, 0.1)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgb(209, 231, 218)' } },
                    x: { grid: { display: false } }
                }
            }
        });

        new Chart(document.getElementById('assuranceChart'), {
            type: 'doughnut',
            data: {
                labels: ['Assurés', 'Non-assurés'],
                datasets: [{
                    data: [{{ $patientsAssures }}, {{ $patientsNonAssures }}],
                    backgroundColor: ['rgb(6, 95, 70)', 'rgb(236, 245, 240)'],
                    borderWidth: 0,
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '75%', plugins: { legend: { display: false } } }
        });
    </script>
</x-admin-layout>