<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions Légales - Lynza</title>
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
            <a href="{{ route('home') }}" class="text-2xl font-extrabold text-indigo-600 tracking-wide hover:text-indigo-700 transition">
                <img src="{{ asset('img/lynza_couleurs-svg.svg') }}" alt="Lynza" class="h-20">
            </a>

            <div class="hidden md:flex space-x-6">
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-indigo-600 font-medium transition-all duration-300">
                    Accueil
                </a>
                <a href="{{ route('mentions-legales') }}" class="text-indigo-600 font-medium transition-all duration-300 border-b-2 border-indigo-600">
                    Mentions Légales
                </a>
                <a href="{{ route('confidentialite') }}" class="text-slate-700 hover:text-indigo-600 font-medium transition-all duration-300">
                    Confidentialité
                </a>
                <a href="{{ route('cgu') }}" class="text-slate-700 hover:text-indigo-600 font-medium transition-all duration-300">
                    CGU
                </a>
            </div>

            @auth
                <a href="{{ route('dashboard') }}"
                   class="hidden md:inline-flex items-center px-5 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition font-medium">
                    <span> Accueil</span>
                </a>
            @else
                <div class="hidden md:flex space-x-3">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center px-5 py-2 bg-white text-indigo-600 border border-indigo-200 rounded-lg shadow-sm hover:bg-indigo-50 transition font-medium">
                        <span> S'inscrire</span>
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition font-medium">
                        <span> Connexion</span>
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<main class="mt-24 mb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm p-8 border border-slate-100">
            <h1 class="text-3xl font-bold text-slate-800 mb-6">Mentions Légales</h1>

            <div class="space-y-8">
                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">1. Informations légales</h2>
                    <p class="text-slate-600">
                        Le site Lynza est édité par la société Lynza SAS, société par actions simplifiée au capital de 10 000 euros,
                        immatriculée au Registre du Commerce et des Sociétés de Paris sous le numéro 123 456 789,
                        dont le siège social est situé au 123 Avenue des Champs-Élysées, 75008 Paris, France.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Numéro de TVA intracommunautaire : FR 12 345 678 901
                    </p>
                    <p class="text-slate-600 mt-2">
                        Directeur de la publication : Jean Dupont, Président de Lynza SAS
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">2. Hébergement</h2>
                    <p class="text-slate-600">
                        Le site Lynza est hébergé par la société OVH SAS, société par actions simplifiée au capital de 10 174 560 euros,
                        immatriculée au Registre du Commerce et des Sociétés de Lille Métropole sous le numéro 424 761 419,
                        dont le siège social est situé au 2 rue Kellermann, 59100 Roubaix, France.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">3. Contact</h2>
                    <p class="text-slate-600">
                        Pour toute question concernant le site, vous pouvez nous contacter :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2">
                        <li>Par email : <a href="mailto:contact@lynza.fr" class="text-indigo-600 hover:text-indigo-800">contact@lynza.fr</a></li>
                        <li>Par téléphone : <a href="tel:+33123456789" class="text-indigo-600 hover:text-indigo-800">+33 1 23 45 67 89</a></li>
                        <li>Par courrier : Lynza SAS, 123 Avenue des Champs-Élysées, 75008 Paris, France</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">4. Propriété intellectuelle</h2>
                    <p class="text-slate-600">
                        L'ensemble du contenu du site Lynza (textes, graphismes, logos, images, vidéos, etc.) est protégé par le droit d'auteur.
                        Toute reproduction, représentation, modification, publication, adaptation ou exploitation de tout ou partie des éléments du site,
                        quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable de Lynza SAS.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Les marques et logos présents sur le site sont des marques déposées par Lynza SAS ou ses partenaires.
                        Toute reproduction, usage ou apposition de ces marques sans autorisation expresse et préalable de Lynza SAS
                        ou de ses partenaires est interdite et engagerait la responsabilité de l'utilisateur au sens des articles L.713-2 et L.713-3 du Code de la Propriété Intellectuelle.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">5. Limitation de responsabilité</h2>
                    <p class="text-slate-600">
                        Lynza SAS s'efforce d'assurer au mieux de ses possibilités l'exactitude et la mise à jour des informations diffusées sur son site.
                        Cependant, Lynza SAS ne peut garantir l'exactitude, la précision ou l'exhaustivité des informations mises à disposition sur le site.
                        En conséquence, Lynza SAS décline toute responsabilité pour toute imprécision, inexactitude ou omission portant sur des informations disponibles sur le site.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Lynza SAS ne pourra être tenue responsable des dommages directs ou indirects résultant de l'utilisation du site ou de l'impossibilité d'y accéder.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">6. Liens hypertextes</h2>
                    <p class="text-slate-600">
                        Le site Lynza peut contenir des liens hypertextes vers d'autres sites internet. Lynza SAS n'exerce aucun contrôle sur ces sites
                        et ne peut être tenue responsable de leur contenu ou de leur politique de confidentialité.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">7. Modification des mentions légales</h2>
                    <p class="text-slate-600">
                        Lynza SAS se réserve le droit de modifier les présentes mentions légales à tout moment. L'utilisateur est invité à les consulter régulièrement.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">8. Droit applicable et juridiction compétente</h2>
                    <p class="text-slate-600">
                        Les présentes mentions légales sont régies par le droit français. En cas de litige, les tribunaux français seront seuls compétents.
                    </p>
                </section>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100">
                <p class="text-slate-500 text-sm">
                    Dernière mise à jour : 26 juillet 2025
                </p>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-slate-900 text-white py-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0">
                <img src="{{ asset('img/lynza_couleurs-svg.svg') }}" alt="Lynza" class="h-10">
                <p class="mt-2 text-slate-400 text-sm">© 2025 Lynza. Tous droits réservés.</p>
            </div>
            <div class="flex space-x-6">
                <a href="{{ route('mentions-legales') }}" class="text-indigo-400 hover:text-white transition">Mentions légales</a>
                <a href="{{ route('confidentialite') }}" class="text-slate-300 hover:text-white transition">Confidentialité</a>
                <a href="{{ route('cgu') }}" class="text-slate-300 hover:text-white transition">CGU</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
