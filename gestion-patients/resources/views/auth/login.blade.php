<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Gestion Patients</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased">

    <div class="min-h-screen bg-gray-50 flex justify-center items-center">
        <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">

            {{-- Colonne formulaire --}}
            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
                <div class="flex justify-center">
                    <div class="h-12 w-12 rounded-xl bg-emerald-600 flex items-center justify-center text-white text-xl font-bold">
                        GP
                    </div>
                </div>
                <h2 class="mt-6 text-center text-xl font-bold text-slate-800">Gestion Patients</h2>
                <p class="text-center text-sm text-slate-500 mt-1">Connectez-vous à votre espace</p>

                <div class="mt-10 flex flex-col items-center">
                    <div class="w-full flex-1">

                        @if (session('status'))
                            <div class="mb-4 text-sm font-medium text-emerald-600 text-center">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="mx-auto max-w-xs">
                            @csrf

                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-emerald-400 focus:bg-white"
                                type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus />
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-emerald-400 focus:bg-white mt-5"
                                type="password" name="password" placeholder="Mot de passe" required />
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <div class="flex items-center justify-between mt-5">
                                <label class="flex items-center text-sm text-slate-600">
                                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 mr-2">
                                    Se souvenir de moi
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:underline">
                                        Mot de passe oublié ?
                                    </a>
                                @endif
                            </div>

                            <button type="submit"
                                class="mt-5 tracking-wide font-semibold bg-emerald-600 text-white w-full py-4 rounded-lg hover:bg-emerald-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:outline-none">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                    <circle cx="8.5" cy="7" r="4" />
                                    <path d="M20 8v6M23 11h-6" />
                                </svg>
                                <span>Se connecter</span>
                            </button>

                            <p class="mt-6 text-xs text-gray-500 text-center">
                                Accès réservé au personnel de l'hôpital.
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Colonne visuelle avec slider --}}
            <div class="flex-1 relative hidden lg:block overflow-hidden">
                <div id="login-slider" class="w-full h-full relative">
                    <img src="{{ asset('images/login/slide-1.jpg') }}"
                         class="slide absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-100">
                    <img src="{{ asset('images/login/slide-2.jpg') }}"
                         class="slide absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">
                    <img src="{{ asset('images/login/slide-3.jpg') }}"
                         class="slide absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">

                    <div class="absolute inset-0 bg-emerald-900/30"></div>

                    <div class="absolute bottom-10 left-0 right-0 text-center px-8">
                        <p class="text-white font-medium text-lg drop-shadow">Gestion simplifiée des dossiers patients</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('#login-slider .slide');

        setInterval(() => {
            slides[currentSlide].classList.remove('opacity-100');
            slides[currentSlide].classList.add('opacity-0');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.remove('opacity-0');
            slides[currentSlide].classList.add('opacity-100');
        }, 4000);
    </script>
</body>
</html>