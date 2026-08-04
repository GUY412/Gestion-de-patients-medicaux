<x-admin-layout>
    <x-slot name="title">Médecins</x-slot>

    <div x-data="{
        showCreate: false,
        showEdit: false,
        editing: {}
    }">

        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-primary/10 text-primary text-sm">{{ session('success') }}</div>
        @endif

        <div class="flex justify-end mb-4">
            <button @click="showCreate = true"
                    class="inline-flex h-9 items-center gap-2 rounded-md bg-primary px-3 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                Ajouter un médecin
            </button>
        </div>

        <section class="rounded-xl border border-border/70 bg-card">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border/70 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                        <th class="px-6 py-3">Nom</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/60">
                    @forelse ($medecins as $medecin)
                        <tr class="hover:bg-secondary/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary text-xs font-semibold">
                                        {{ substr($medecin->name, 0, 2) }}
                                    </span>
                                    <span class="font-medium text-foreground">Dr. {{ $medecin->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-muted-foreground">{{ $medecin->email }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button
                                    @click="editing = {
                                        id: {{ $medecin->id }},
                                        name: '{{ addslashes($medecin->name) }}',
                                        email: '{{ addslashes($medecin->email) }}'
                                    }; showEdit = true"
                                    class="text-primary font-medium">
                                    Modifier
                                </button>
                                <form method="POST" action="{{ route('admin.medecins.destroy', $medecin) }}"
                                      class="inline" onsubmit="return confirm('Supprimer ce médecin ?')">
                                    @csrf @method('DELETE')
                                    <button class="text-destructive font-medium ml-2">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-6 py-6 text-center text-muted-foreground">Aucun médecin enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4">{{ $medecins->links() }}</div>
        </section>

        {{-- MODAL CRÉATION --}}
        <div x-show="showCreate" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-foreground/40 backdrop-blur-sm p-4"
             @click.self="showCreate = false">
            <div class="w-full max-w-md rounded-xl bg-card border border-border shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-lg font-semibold">Inscrire un médecin</h3>
                    <button @click="showCreate = false" class="text-muted-foreground hover:text-foreground">
                        <iconify-icon icon="solar:close-circle-linear" width="22"></iconify-icon>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.medecins.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="name" value="Nom complet" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="password" value="Mot de passe" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                    </div>

                    <div class="flex gap-2 justify-end pt-2">
                        <button type="button" @click="showCreate = false"
                                class="h-9 rounded-lg border border-border px-4 text-sm font-medium hover:bg-secondary transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                                class="h-9 rounded-lg bg-primary px-4 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                            Inscrire
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div x-show="showEdit" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-foreground/40 backdrop-blur-sm p-4"
             @click.self="showEdit = false">
            <div class="w-full max-w-md rounded-xl bg-card border border-border shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-lg font-semibold">Modifier le médecin</h3>
                    <button @click="showEdit = false" class="text-muted-foreground hover:text-foreground">
                        <iconify-icon icon="solar:close-circle-linear" width="22"></iconify-icon>
                    </button>
                </div>

                <form method="POST" :action="`/admin/medecins/${editing.id}`" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <x-input-label value="Nom complet" />
                        <input type="text" name="name" x-model="editing.name" class="mt-1 block w-full border-border rounded-md" required>
                    </div>
                    <div>
                        <x-input-label value="Email" />
                        <input type="email" name="email" x-model="editing.email" class="mt-1 block w-full border-border rounded-md" required>
                    </div>

                    <div class="flex gap-2 justify-end pt-2">
                        <button type="button" @click="showEdit = false"
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
</x-admin-layout>