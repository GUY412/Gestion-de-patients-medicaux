<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Gestion Patients</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-slate-800 antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside class="w-64 border-r border-slate-200 bg-white flex flex-col justify-between">
            <div>
                <div class="flex h-16 items-center px-6 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="h-6 w-6 rounded bg-emerald-600 flex items-center justify-center text-white">
                            <iconify-icon icon="solar:health-linear" width="16"></iconify-icon>
                        </div>
                        <span class="text-lg font-extrabold text-slate-900 tracking-tight">GESTION PATIENTS</span>
                    </div>
                </div>

                <nav class="space-y-1 px-3 py-6">
                    <a href="{{ route('admin.dashboard') }}"
                       class="group flex items-center gap-3 text-sm font-medium rounded-lg px-3 py-2.5
                       {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <iconify-icon icon="solar:widget-5-linear" width="20"></iconify-icon>
                        Dashboard
                    </a>
                    <a href="{{ route('patients.index') }}"
                       class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                        <iconify-icon icon="solar:users-group-rounded-linear" width="20"></iconify-icon>
                        Patients
                    </a>
                    <a href="#"
                       class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                        <iconify-icon icon="solar:stethoscope-linear" width="20"></iconify-icon>
                        Consultations
                    </a>
                   <a href="{{ route('admin.users.index') }}"
   class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900">
    <iconify-icon icon="solar:user-id-linear" width="20"></iconify-icon>
    Utilisateurs
</a>
                </nav>
            </div>

            <div class="border-t border-slate-100 p-3">
                <div class="flex items-center gap-3 px-3 py-2">
                    <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-xs font-bold text-emerald-700">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-slate-900">{{ auth()->user()->name }}</span>
                        <span class="text-xxs text-slate-500">Administrateur</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="mt-2 w-full text-left flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                        <iconify-icon icon="solar:logout-2-linear" width="20"></iconify-icon>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-8">
                <h1 class="text-lg font-semibold text-slate-900">{{ $title ?? 'Dashboard' }}</h1>
            </header>

            <div class="flex-1 overflow-y-auto p-8 bg-slate-50/50">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>