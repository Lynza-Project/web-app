<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lynza - L'intranet Réinventé 🚀</title>
    <link rel="icon" href="{{ asset('img/lynza_couleurs-svg.svg') }}" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

<!-- Navigation -->
<nav class="bg-white shadow-sm fixed w-full top-0 z-50 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="#" class="text-2xl font-extrabold text-indigo-600 tracking-wide hover:text-indigo-700 transition">
                <img src="{{ asset('img/lynza_couleurs-svg.svg') }}" alt="Lynza" class="h-20">
            </a>

            <div class="hidden md:flex space-x-10">
                <a href="#features" class="nav-link text-slate-700 hover:text-indigo-600 font-medium transition-all duration-300 relative group">
                    <span class="block">✨ Fonctionnalités</span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#about" class="nav-link text-slate-700 hover:text-indigo-600 font-medium transition-all duration-300 relative group">
                    <span class="block">📌 À Propos</span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#contact" class="nav-link text-slate-700 hover:text-indigo-600 font-medium transition-all duration-300 relative group">
                    <span class="block">📩 Contact</span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </div>

            @auth
                <a href="{{ route('dashboard') }}"
                   class="hidden md:inline-flex items-center px-5 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition font-medium">
                    <span> Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="hidden md:inline-flex items-center px-5 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition font-medium">
                    <span> Connexion</span>
                </a>
            @endauth

            <button id="mobile-menu-button" class="md:hidden focus:outline-none">
                <svg class="w-6 h-6 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden md:hidden flex-col space-y-4 mt-2 bg-white shadow-lg rounded-lg p-4">
            <a href="#features" class="nav-link text-slate-700 hover:text-indigo-600 font-medium py-2">
                <span class="block">✨ Fonctionnalités</span>
            </a>
            <a href="#about" class="nav-link text-slate-700 hover:text-indigo-600 font-medium py-2">
                <span class="block">📌 À Propos</span>
            </a>
            <a href="#contact" class="nav-link text-slate-700 hover:text-indigo-600 font-medium py-2">
                <span class="block">📩 Contact</span>
            </a>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition font-medium">
                    <span>📊 Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition font-medium">
                    <span>🔑 Connexion</span>
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>

<main class="mt-16">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-indigo-50 to-slate-50 overflow-hidden">
        <!-- Image de fond -->
        <img
            src="{{ asset('img/university.jpg') }}"
            alt="Image de fond pour Lynza"
            class="absolute inset-0 w-full h-full object-cover opacity-20"
        >
        <!-- Overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/10 to-purple-500/10"></div>

        <!-- Contenu -->
        <section class="relative max-w-6xl mx-auto px-4 py-28 md:py-36 flex flex-col items-center">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-100 rounded-full opacity-50 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-purple-100 rounded-full opacity-50 blur-3xl"></div>

            <span class="px-4 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium mb-6">Plateforme collaborative</span>

            <h1 class="text-4xl md:text-6xl font-bold text-slate-800 text-center leading-tight">
                Lynza - <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">L'Intranet Nouvelle Génération</span> 🚀
            </h1>

            <p class="mt-6 text-xl text-slate-600 max-w-3xl text-center">
                Simplifiez la communication, la gestion et l'organisation au sein de votre structure avec une solution moderne et intuitive.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#features"
                   class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition text-lg font-medium">
                    🔍 Découvrir Lynza
                </a>
                <a href="#contact"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white text-indigo-600 border border-indigo-200 rounded-lg shadow-sm hover:bg-indigo-50 transition text-lg font-medium">
                    📩 Nous contacter
                </a>
            </div>
        </section>
    </div>

    <!-- Fonctionnalités Clés -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="px-4 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">Fonctionnalités</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-4 text-slate-800">⚡ Des outils puissants pour votre organisation</h2>
                <p class="text-slate-600 mt-4 text-lg max-w-3xl mx-auto">Un intranet moderne, évolutif et conçu pour
                    simplifier votre gestion quotidienne et améliorer la collaboration.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">
                <!-- Gestion des Événements -->
                <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">📅</span>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800">Gestion des Événements</h3>
                    <p class="text-slate-600 mt-3 flex-grow">
                        Créez, planifiez et partagez des événements en quelques clics. Ajoutez une date, un lieu et
                        des détails pour informer votre communauté avec un calendrier dynamique et des rappels automatisés.
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                            En savoir plus
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Communication Interne -->
                <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">💬</span>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800">Communication Interne</h3>
                    <p class="text-slate-600 mt-3 flex-grow">
                        Une messagerie intégrée pour fluidifier les échanges entre membres. Centralisez vos discussions,
                        partagez des fichiers et posez vos questions directement aux administrateurs.
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                            En savoir plus
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Ressources Documentaires -->
                <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">📚</span>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800">Ressources Documentaires</h3>
                    <p class="text-slate-600 mt-3 flex-grow">
                        Un espace de stockage sécurisé pour partager des documents importants. Organisez vos fichiers
                        par catégories et offrez un accès rapide à tous vos membres.
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                            En savoir plus
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Actualités et Annonces -->
                <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">📣</span>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800">Actualités et Annonces</h3>
                    <p class="text-slate-600 mt-3 flex-grow">
                        Diffusez facilement les actualités et annonces importantes. Publiez des mises à jour, informez sur
                        des événements à venir et gardez vos membres connectés aux informations essentielles.
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                            En savoir plus
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Objets Perdus / Retrouvés -->
                <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">🔍</span>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800">Objets Perdus / Retrouvés</h3>
                    <p class="text-slate-600 mt-3 flex-grow">
                        Une solution simple pour signaler, rechercher et récupérer des objets perdus. Filtrez par catégorie,
                        date et lieu pour retrouver vos affaires plus facilement.
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                            En savoir plus
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Espace vide pour équilibrer la grille -->
                <div class="p-6 bg-gradient-to-br from-indigo-50 to-purple-50 border border-slate-200 rounded-xl shadow-sm flex flex-col h-full justify-center items-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                        <span class="text-3xl">✨</span>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800 text-center">Et bien plus encore...</h3>
                    <p class="text-slate-600 mt-3 text-center">
                        De nouvelles fonctionnalités sont régulièrement ajoutées pour répondre à vos besoins.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Nouveautés à venir -->
    <section id="upcoming-features" class="py-24 bg-gradient-to-b from-white to-slate-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="px-4 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">Bientôt disponible</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-4 text-slate-800">🪴 Lynza évolue avec vous</h2>
                <p class="text-slate-600 mt-4 text-lg max-w-3xl mx-auto">
                    Notre plateforme s'améliore constamment pour répondre à vos besoins. Découvrez les fonctionnalités qui arriveront prochainement.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-10">
                <!-- Sondages et Enquêtes -->
                <div class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur-sm opacity-25 group-hover:opacity-40 transition duration-300"></div>
                    <div class="relative p-8 bg-white rounded-xl shadow-sm border border-slate-100 flex flex-col h-full">
                        <div class="flex items-center mb-6">
                            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                                <span class="text-2xl">📊</span>
                            </div>
                            <h3 class="text-xl font-semibold text-slate-800">Sondages et Enquêtes</h3>
                        </div>
                        <p class="text-slate-600">
                            Engagez votre communauté en recueillant des avis et en analysant des retours grâce à des
                            sondages interactifs. Les résultats seront affichés sous forme de graphiques pour une analyse claire et rapide.
                        </p>
                        <div class="mt-6 inline-flex items-center text-sm text-purple-600 font-medium">
                            <span class="relative flex h-3 w-3 mr-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-purple-500"></span>
                            </span>
                            Disponible au 2ème trimestre 2025
                        </div>
                    </div>
                </div>

                <!-- Notifications et Alertes -->
                <div class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur-sm opacity-25 group-hover:opacity-40 transition duration-300"></div>
                    <div class="relative p-8 bg-white rounded-xl shadow-sm border border-slate-100 flex flex-col h-full">
                        <div class="flex items-center mb-6">
                            <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mr-4">
                                <span class="text-2xl">🔔</span>
                            </div>
                            <h3 class="text-xl font-semibold text-slate-800">Notifications en Temps Réel</h3>
                        </div>
                        <p class="text-slate-600">
                            Recevez des alertes instantanées pour les événements, annonces, messages et mises à jour.
                            Ne manquez plus aucune information importante grâce à un système de notifications
                            centralisé et personnalisable.
                        </p>
                        <div class="mt-6 inline-flex items-center text-sm text-purple-600 font-medium">
                            <span class="relative flex h-3 w-3 mr-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-purple-500"></span>
                            </span>
                            Disponible au 3ème trimestre 2025
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 text-center">
                <a href="#contact" class="inline-flex items-center justify-center px-6 py-3 bg-white text-indigo-600 border border-indigo-200 rounded-lg shadow-sm hover:bg-indigo-50 transition text-lg font-medium">
                    💡 Suggérer une fonctionnalité
                </a>
            </div>
        </div>
    </section>

    <!-- À Propos -->
    <section id="about" class="py-24 bg-slate-900 text-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="px-4 py-1 bg-indigo-900 text-indigo-300 rounded-full text-sm font-medium">Notre vision</span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-4 text-white">💡 Pourquoi choisir <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Lynza</span> ?</h2>

                    <div class="mt-8 space-y-6">
                        <div class="flex">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-white">Simplicité d'utilisation</h3>
                                <p class="mt-2 text-slate-300">Interface intuitive et épurée, accessible à tous les membres de votre organisation sans formation complexe.</p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-6 h-6 rounded-full bg-purple-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-white">Personnalisation complète</h3>
                                <p class="mt-2 text-slate-300">Adaptez Lynza à votre image et à vos besoins spécifiques, avec des options de personnalisation étendues.</p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-white">Sécurité renforcée</h3>
                                <p class="mt-2 text-slate-300">Protection des données et contrôle des accès pour garantir la confidentialité de vos informations sensibles.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur-xl opacity-20"></div>
                    <div class="relative bg-slate-800 p-8 rounded-xl border border-slate-700">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-indigo-900/50 rounded-lg flex items-center justify-center mr-4">
                                <span class="text-2xl">🚀</span>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Un écosystème complet</h3>
                        </div>
                        <p class="text-slate-300 mb-6">
                            Lynza est bien plus qu'un simple intranet. C'est un écosystème digital conçu pour renforcer la
                            communication, la gestion et l'organisation au sein de votre structure.
                        </p>
                        <p class="text-slate-300 mb-6">
                            Facile à configurer, sécurisé et 100% personnalisable, Lynza vous offre une flexibilité sans
                            précédent pour répondre aux besoins spécifiques de votre organisation.
                        </p>
                        <div class="flex justify-between items-center pt-4 border-t border-slate-700">
                            <div class="flex items-center">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Témoignage" class="w-10 h-10 rounded-full">
                                <div class="ml-3">
                                    <p class="text-white font-medium">Marie Dupont</p>
                                    <p class="text-slate-400 text-sm">Directrice Communication</p>
                                </div>
                            </div>
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="py-24 bg-gradient-to-b from-slate-50 to-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <span class="px-4 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">Contact</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-4 text-slate-800">📩 Discutons de votre projet</h2>
                <p class="text-slate-600 mt-4 text-lg max-w-3xl mx-auto">
                    Besoin d'une démo personnalisée ? Des questions sur nos fonctionnalités ? Notre équipe est là pour vous aider.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100">
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nom complet</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Votre nom">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="votre@email.com">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                            <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Comment pouvons-nous vous aider ?"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 transition text-lg font-medium">
                                Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>

                <div class="space-y-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-semibold text-slate-800">Email</h3>
                            <p class="mt-1 text-slate-600">Notre équipe vous répond sous 24h</p>
                            <a href="mailto:contact@lynza.com" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 font-medium">contact@lynza.com</a>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-semibold text-slate-800">Téléphone</h3>
                            <p class="mt-1 text-slate-600">Du lundi au vendredi, 9h-18h</p>
                            <a href="tel:+33123456789" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 font-medium">+33 1 23 45 67 89</a>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-semibold text-slate-800">Chat en direct</h3>
                            <p class="mt-1 text-slate-600">Assistance immédiate</p>
                            <a href="#" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 font-medium">Démarrer une conversation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <img src="{{ asset('img/lynza_couleurs-svg.svg') }}" alt="Lynza" class="h-10">
                    <p class="mt-2 text-slate-400 text-sm">© 2025 Lynza. Tous droits réservés.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-slate-300 hover:text-white transition">Mentions légales</a>
                    <a href="#" class="text-slate-300 hover:text-white transition">Confidentialité</a>
                    <a href="#" class="text-slate-300 hover:text-white transition">CGU</a>
                </div>
            </div>
        </div>
    </footer>
</main>
</body>
<script>
    // Fonction pour gérer le scroll avec animation
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth', // Animation fluide
                    block: 'start'     // Alignement au début
                });
            }
        });
    });
</script>
</html>
