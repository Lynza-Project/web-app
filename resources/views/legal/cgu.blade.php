<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conditions Générales d'Utilisation - Lynza</title>
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
                <a href="{{ route('mentions-legales') }}" class="text-slate-700 hover:text-indigo-600 font-medium transition-all duration-300">
                    Mentions Légales
                </a>
                <a href="{{ route('confidentialite') }}" class="text-slate-700 hover:text-indigo-600 font-medium transition-all duration-300">
                    Confidentialité
                </a>
                <a href="{{ route('cgu') }}" class="text-indigo-600 font-medium transition-all duration-300 border-b-2 border-indigo-600">
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
            <h1 class="text-3xl font-bold text-slate-800 mb-6">Conditions Générales d'Utilisation</h1>

            <div class="space-y-8">
                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">1. Préambule</h2>
                    <p class="text-slate-600">
                        Les présentes Conditions Générales d'Utilisation (ci-après "CGU") régissent l'utilisation de la plateforme Lynza
                        (ci-après "la Plateforme"), accessible à l'adresse www.lynza.fr, éditée par la société Lynza SAS.
                    </p>
                    <p class="text-slate-600 mt-2">
                        L'utilisation de la Plateforme implique l'acceptation pleine et entière des présentes CGU. Si vous n'acceptez pas
                        ces conditions, veuillez ne pas utiliser la Plateforme.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">2. Définitions</h2>
                    <p class="text-slate-600">
                        Dans les présentes CGU, les termes suivants ont la signification qui leur est donnée ci-dessous :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2 space-y-1">
                        <li><strong>Plateforme</strong> : désigne le site web et l'application Lynza</li>
                        <li><strong>Utilisateur</strong> : désigne toute personne qui accède à la Plateforme et l'utilise</li>
                        <li><strong>Compte</strong> : désigne l'espace personnel de l'Utilisateur sur la Plateforme</li>
                        <li><strong>Contenu</strong> : désigne toutes les informations, données, textes, images, vidéos, messages ou autres matériels publiés sur la Plateforme</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">3. Inscription et compte utilisateur</h2>
                    <p class="text-slate-600">
                        Pour accéder à certaines fonctionnalités de la Plateforme, vous devez créer un compte utilisateur. Lors de votre inscription,
                        vous vous engagez à fournir des informations exactes, complètes et à jour.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Vous êtes responsable de la confidentialité de vos identifiants de connexion et de toutes les activités effectuées
                        depuis votre compte. Vous vous engagez à informer immédiatement Lynza SAS de toute utilisation non autorisée de votre compte.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Lynza SAS se réserve le droit de suspendre ou de supprimer votre compte en cas de violation des présentes CGU.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">4. Utilisation de la plateforme</h2>
                    <p class="text-slate-600">
                        En utilisant la Plateforme, vous vous engagez à :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2 space-y-1">
                        <li>Respecter les lois et réglementations en vigueur</li>
                        <li>Ne pas publier de contenu illégal, diffamatoire, injurieux, obscène, offensant ou portant atteinte aux droits des tiers</li>
                        <li>Ne pas utiliser la Plateforme à des fins commerciales sans autorisation préalable</li>
                        <li>Ne pas tenter de perturber le fonctionnement de la Plateforme ou d'accéder aux données d'autres utilisateurs</li>
                        <li>Ne pas utiliser de robots, spiders, scrapers ou autres moyens automatisés pour accéder à la Plateforme</li>
                        <li>Ne pas contourner les mesures de sécurité mises en place sur la Plateforme</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">5. Contenu utilisateur</h2>
                    <p class="text-slate-600">
                        Vous êtes responsable de tout contenu que vous publiez sur la Plateforme. En publiant du contenu, vous garantissez
                        que vous disposez des droits nécessaires pour le faire et que ce contenu ne viole pas les droits des tiers.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Vous accordez à Lynza SAS une licence mondiale, non exclusive, gratuite, transférable et sous-licenciable pour utiliser,
                        reproduire, modifier, adapter, publier et afficher ce contenu sur la Plateforme.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Lynza SAS se réserve le droit de supprimer tout contenu qui violerait les présentes CGU ou qui serait signalé comme inapproprié.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">6. Propriété intellectuelle</h2>
                    <p class="text-slate-600">
                        La Plateforme et son contenu (textes, images, logos, logiciels, etc.) sont protégés par des droits de propriété intellectuelle
                        et appartiennent à Lynza SAS ou à ses partenaires.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Toute reproduction, représentation, modification, publication, adaptation ou exploitation de tout ou partie de la Plateforme
                        ou de son contenu, par quelque procédé que ce soit, sans l'autorisation préalable de Lynza SAS, est strictement interdite
                        et constitue une contrefaçon sanctionnée par le Code de la propriété intellectuelle.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">7. Responsabilité</h2>
                    <p class="text-slate-600">
                        Lynza SAS s'efforce d'assurer au mieux le bon fonctionnement de la Plateforme, mais ne peut garantir que celle-ci
                        sera exempte d'erreurs, de bugs ou d'interruptions.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Lynza SAS ne saurait être tenue responsable des dommages directs ou indirects résultant de l'utilisation ou de
                        l'impossibilité d'utiliser la Plateforme, sauf en cas de faute prouvée.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Lynza SAS n'est pas responsable du contenu publié par les utilisateurs et se réserve le droit de supprimer tout
                        contenu signalé comme inapproprié.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">8. Liens vers des sites tiers</h2>
                    <p class="text-slate-600">
                        La Plateforme peut contenir des liens vers des sites web tiers. Ces liens sont fournis uniquement pour votre commodité.
                        Lynza SAS n'exerce aucun contrôle sur ces sites et n'assume aucune responsabilité quant à leur contenu ou à leur politique
                        de confidentialité.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">9. Modification des CGU</h2>
                    <p class="text-slate-600">
                        Lynza SAS se réserve le droit de modifier les présentes CGU à tout moment. Les modifications entrent en vigueur dès
                        leur publication sur la Plateforme. Il vous appartient de consulter régulièrement les CGU pour vous tenir informé
                        des éventuelles modifications.
                    </p>
                    <p class="text-slate-600 mt-2">
                        L'utilisation continue de la Plateforme après la publication des modifications vaut acceptation de ces dernières.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">10. Résiliation</h2>
                    <p class="text-slate-600">
                        Vous pouvez cesser d'utiliser la Plateforme à tout moment. Lynza SAS se réserve le droit de suspendre ou de résilier
                        votre accès à la Plateforme en cas de violation des présentes CGU.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">11. Droit applicable et juridiction compétente</h2>
                    <p class="text-slate-600">
                        Les présentes CGU sont régies par le droit français. En cas de litige relatif à l'interprétation ou à l'exécution
                        des présentes CGU, les tribunaux français seront seuls compétents.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">12. Contact</h2>
                    <p class="text-slate-600">
                        Pour toute question concernant les présentes CGU, vous pouvez nous contacter :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2">
                        <li>Par email : <a href="mailto:contact@lynza.fr" class="text-indigo-600 hover:text-indigo-800">contact@lynza.fr</a></li>
                        <li>Par courrier : Lynza SAS, 123 Avenue des Champs-Élysées, 75008 Paris, France</li>
                    </ul>
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
                <a href="{{ route('mentions-legales') }}" class="text-slate-300 hover:text-white transition">Mentions légales</a>
                <a href="{{ route('confidentialite') }}" class="text-slate-300 hover:text-white transition">Confidentialité</a>
                <a href="{{ route('cgu') }}" class="text-indigo-400 hover:text-white transition">CGU</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
