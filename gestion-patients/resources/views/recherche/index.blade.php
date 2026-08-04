<x-app-layout>
    <x-slot name="header">Résultats pour « {{ $q }} »</x-slot>

    <div class="space-y-6">

        {{-- Patients --}}
        <section class="rounded-xl border border-border/70 bg-card">
            <header class="border-b border-border/70 px-6 py-4">
                <h3 class="font-display text-base font-semibold text-foreground">Patients ({{ $patients->count() }})</h3>
            </header>
            <table class="w-full text-sm">
                <tbody class="divide-y divide-border/60">
                    @forelse ($patients as $patient)
                        <tr class="hover:bg-secondary/40 transition-colors">
                            <td class="px-6 py-3 font-medium text-foreground">{{ $patient->nom }} {{ $patient->prenom }}</td>
                            <td class="px-6 py-3 text-muted-foreground">{{ $patient->telephone }}</td>
                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('patients.show', $patient) }}" class="text-primary font-medium">Voir la fiche</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="px-6 py-4 text-center text-muted-foreground">Aucun patient trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        {{-- Médecins --}}
        <section class="rounded-xl border border-border/70 bg-card">
            <header class="border-b border-border/70 px-6 py-4">
                <h3 class="font-display text-base font-semibold text-foreground">Médecins ({{ $medecins->count() }})</h3>
            </header>
            <table class="w-full text-sm">
                <tbody class="divide-y divide-border/60">
                    @forelse ($medecins as $medecin)
                        <tr class="hover:bg-secondary/40 transition-colors">
                            <td class="px-6 py-3 font-medium text-foreground">Dr. {{ $medecin->name }}</td>
                            <td class="px-6 py-3 text-muted-foreground">{{ $medecin->email }}</td>
                        </tr>
                    @empty
                        <tr><td class="px-6 py-4 text-center text-muted-foreground">Aucun médecin trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        {{-- Utilisateurs --}}
        @if (auth()->user()->role === 'admin')
        <section class="rounded-xl border border-border/70 bg-card">
            <header class="border-b border-border/70 px-6 py-4">
                <h3 class="font-display text-base font-semibold text-foreground">Utilisateurs ({{ $utilisateurs->count() }})</h3>
            </header>
            <table class="w-full text-sm">
                <tbody class="divide-y divide-border/60">
                    @forelse ($utilisateurs as $user)
                        <tr class="hover:bg-secondary/40 transition-colors">
                            <td class="px-6 py-3 font-medium text-foreground">{{ $user->name }}</td>
                            <td class="px-6 py-3 text-muted-foreground">{{ $user->email }}</td>
                            <td class="px-6 py-3 text-muted-foreground capitalize">{{ $user->role }}</td>
                        </tr>
                    @empty
                        <tr><td class="px-6 py-4 text-center text-muted-foreground">Aucun utilisateur trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>
        @endif
    </div>
</x-app-layout>