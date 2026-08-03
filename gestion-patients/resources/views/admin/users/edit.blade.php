<x-admin-layout>
    <x-slot name="title">Modifier l'utilisateur</x-slot>

    <div class="max-w-xl bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <x-input-label for="name" value="Nom complet" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="role" value="Rôle" />
                <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="medecin" @selected($user->role == 'medecin')>Médecin</option>
                    <option value="receptionniste" @selected($user->role == 'receptionniste')>Réceptionniste</option>
                    <option value="admin" @selected($user->role == 'admin')>Admin</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-1" />
            </div>

            <div class="flex gap-2 pt-2">
                <x-primary-button type="submit">Enregistrer</x-primary-button>
                <a href="{{ route('admin.users.index') }}"><x-secondary-button type="button">Annuler</x-secondary-button></a>
            </div>
        </form>
    </div>
</x-admin-layout>