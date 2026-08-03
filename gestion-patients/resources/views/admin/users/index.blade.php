<x-admin-layout>
    <x-slot name="title">Utilisateurs</x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-emerald-50 text-emerald-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.users.create') }}">
            <x-primary-button type="button">+ Nouvel utilisateur</x-primary-button>
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50/50 text-xs font-medium uppercase text-slate-500">
                    <th class="p-4">Nom</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Rôle</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach ($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-medium text-slate-900">{{ $user->name }}</td>
                        <td class="p-4 text-slate-500">{{ $user->email }}</td>
                        <td class="p-4">
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 capitalize">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-emerald-700">Modifier</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 ml-2">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</x-admin-layout>