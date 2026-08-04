<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Gestion Patients</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background text-foreground antialiased">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="hidden w-64 shrink-0 flex-col border-r border-border/70 bg-card/40 lg:flex">
            <div class="flex h-16 items-center gap-2 border-b border-border/70 px-6">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-11 w-11 object-contain">
    <span class="font-display text-lg font-semibold tracking-tight">Gestion Patients</span>
</div>

            <nav class="flex-1 space-y-1 p-4">
                <p class="px-3 pb-2 pt-2 text-xs font-medium uppercase tracking-wider text-muted-foreground/70">Gestion</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-secondary hover:text-foreground' }}">
                    <iconify-icon icon="solar:widget-5-linear" width="18"></iconify-icon>
                    Dashboard
                </a>
                <a href="{{ route('patients.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                   {{ request()->routeIs('patients.*') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-secondary hover:text-foreground' }}">
                    <iconify-icon icon="solar:users-group-rounded-linear" width="18"></iconify-icon>
                    Patients
                </a>
                <a href="#"
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground">
                    <iconify-icon icon="solar:stethoscope-linear" width="18"></iconify-icon>
                    Consultations
                </a>
                <a href="{{ route('admin.medecins.index') }}"
   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
   {{ request()->routeIs('admin.medecins.*') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-secondary hover:text-foreground' }}">
    <iconify-icon icon="solar:stethoscope-linear" width="18"></iconify-icon>
    Médecins
</a>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.users.*') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-secondary hover:text-foreground' }}">
                    <iconify-icon icon="solar:user-id-linear" width="18"></iconify-icon>
                    Utilisateurs
                </a>
            </nav>

            <div class="m-4 rounded-xl border border-border/70 bg-gradient-to-br from-primary to-primary/80 p-4 text-primary-foreground">
                <div class="mb-1 flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-accent text-white">
                        <iconify-icon icon="solar:shield-check-bold" width="14"></iconify-icon>
                    </span>
                    <p class="font-display text-sm font-semibold">Sécurité active</p>
                </div>
                <p class="text-xs leading-relaxed text-primary-foreground/80">Les dossiers patients sont protégés par un accès restreint.</p>
            </div>

        </aside>

        {{-- Main --}}
        <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-primary/20 bg-primary px-4 sm:px-6 lg:px-8">
    <form method="GET" action="{{ route('recherche.index') }}" class="relative flex-1 max-w-md">
        <iconify-icon icon="solar:magnifer-linear" width="16" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></iconify-icon>
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un patient, médecin..."
               class="h-9 w-full rounded-lg border border-border/80 bg-card pl-9 pr-3 text-sm text-foreground placeholder:text-muted-foreground/70 focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
    </form>

    <div class="ml-auto flex items-center gap-3" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center gap-2" @click.outside="open = false">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-xs font-semibold text-primary-foreground">
                {{ substr(auth()->user()->name, 0, 2) }}
            </span>
            <div class="hidden text-left sm:block">
                <p class="text-sm font-medium leading-none text-foreground">{{ auth()->user()->name }}</p>
                <p class="mt-0.5 text-xs text-muted-foreground capitalize">{{ auth()->user()->role }}</p>
            </div>
            <iconify-icon icon="solar:alt-arrow-down-linear" width="14" class="text-muted-foreground"></iconify-icon>
        </button>

        <div x-show="open" x-cloak
             class="absolute right-4 top-14 z-40 w-48 rounded-lg border border-border bg-card shadow-lg py-1 sm:right-6 lg:right-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-muted-foreground hover:bg-secondary hover:text-foreground transition-colors">
                    <iconify-icon icon="solar:logout-2-linear" width="16"></iconify-icon>
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
</header>

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                <div class="mx-auto flex max-w-[1400px] flex-col gap-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">{{ now()->locale('fr')->translatedFormat('l j F Y') }}</p>
                            <h1 class="mt-1 font-display text-2xl font-semibold tracking-tight text-foreground sm:text-3xl">{{ $title ?? 'Dashboard' }}</h1>
                        </div>
                    </div>

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>