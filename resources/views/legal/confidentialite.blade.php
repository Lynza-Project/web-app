<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique de Confidentialité - Lynza</title>
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
                <a href="{{ route('confidentialite') }}" class="text-indigo-600 font-medium transition-all duration-300 border-b-2 border-indigo-600">
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
            <h1 class="text-3xl font-bold text-slate-800 mb-6">Politique de Confidentialité</h1>

            <div class="space-y-8">
                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">1. Introduction</h2>
                    <p class="text-slate-600">
                        Chez Lynza, nous accordons une grande importance à la protection de vos données personnelles.
                        Cette politique de confidentialité vous informe sur la manière dont nous collectons, utilisons,
                        partageons et protégeons vos données personnelles lorsque vous utilisez notre plateforme.
                    </p>
                    <p class="text-slate-600 mt-2">
                        En utilisant Lynza, vous acceptez les pratiques décrites dans la présente politique de confidentialité.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">2. Données collectées</h2>
                    <p class="text-slate-600">
                        Nous collectons différents types de données personnelles lorsque vous utilisez notre plateforme :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2 space-y-1">
                        <li><strong>Données d'identification</strong> : nom, prénom, adresse email, numéro de téléphone</li>
                        <li><strong>Données de profil</strong> : photo de profil, fonction, département</li>
                        <li><strong>Données d'utilisation</strong> : informations sur votre utilisation de la plateforme, interactions avec les fonctionnalités</li>
                        <li><strong>Données techniques</strong> : adresse IP, type de navigateur, appareil utilisé, système d'exploitation</li>
                        <li><strong>Cookies et technologies similaires</strong> : informations stockées sur votre appareil pour améliorer votre expérience</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">3. Finalités du traitement</h2>
                    <p class="text-slate-600">
                        Nous utilisons vos données personnelles pour les finalités suivantes :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2 space-y-1">
                        <li>Fournir, exploiter et maintenir notre plateforme</li>
                        <li>Améliorer, personnaliser et développer nos services</li>
                        <li>Comprendre comment vous utilisez notre plateforme</li>
                        <li>Communiquer avec vous et vous envoyer des informations importantes</li>
                        <li>Assurer la sécurité de notre plateforme et de vos données</li>
                        <li>Se conformer aux obligations légales</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">4. Base légale du traitement</h2>
                    <p class="text-slate-600">
                        Nous traitons vos données personnelles sur les bases légales suivantes :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2 space-y-1">
                        <li><strong>Exécution du contrat</strong> : traitement nécessaire à l'exécution du contrat auquel vous êtes partie</li>
                        <li><strong>Consentement</strong> : vous avez donné votre consentement au traitement de vos données personnelles</li>
                        <li><strong>Intérêts légitimes</strong> : le traitement est nécessaire aux fins des intérêts légitimes poursuivis par Lynza</li>
                        <li><strong>Obligation légale</strong> : le traitement est nécessaire au respect d'une obligation légale à laquelle Lynza est soumise</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">5. Partage des données</h2>
                    <p class="text-slate-600">
                        Nous pouvons partager vos données personnelles avec les catégories de destinataires suivantes :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2 space-y-1">
                        <li><strong>Prestataires de services</strong> : entreprises qui nous fournissent des services (hébergement, maintenance, analyse)</li>
                        <li><strong>Partenaires commerciaux</strong> : uniquement avec votre consentement préalable</li>
                        <li><strong>Autorités légales</strong> : lorsque la loi l'exige ou pour protéger nos droits</li>
                    </ul>
                    <p class="text-slate-600 mt-2">
                        Nous ne vendons pas vos données personnelles à des tiers.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">6. Conservation des données</h2>
                    <p class="text-slate-600">
                        Nous conservons vos données personnelles aussi longtemps que nécessaire pour atteindre les finalités
                        pour lesquelles elles ont été collectées, sauf si une période de conservation plus longue est requise
                        ou permise par la loi.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Les critères utilisés pour déterminer nos périodes de conservation comprennent :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2 space-y-1">
                        <li>La durée pendant laquelle nous entretenons une relation avec vous</li>
                        <li>Nos obligations légales</li>
                        <li>Les prescriptions applicables en matière de litiges</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">7. Sécurité des données</h2>
                    <p class="text-slate-600">
                        Nous mettons en œuvre des mesures de sécurité techniques et organisationnelles appropriées pour
                        protéger vos données personnelles contre la perte, l'utilisation abusive, l'accès non autorisé,
                        la divulgation, l'altération et la destruction.
                    </p>
                    <p class="text-slate-600 mt-2">
                        Ces mesures comprennent le chiffrement des données, les contrôles d'accès, les pare-feu et
                        les audits de sécurité réguliers.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">8. Vos droits</h2>
                    <p class="text-slate-600">
                        Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez des droits suivants :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2 space-y-1">
                        <li><strong>Droit d'accès</strong> : vous pouvez demander une copie de vos données personnelles</li>
                        <li><strong>Droit de rectification</strong> : vous pouvez demander la correction de vos données inexactes</li>
                        <li><strong>Droit à l'effacement</strong> : vous pouvez demander la suppression de vos données dans certaines circonstances</li>
                        <li><strong>Droit à la limitation du traitement</strong> : vous pouvez demander la limitation du traitement de vos données</li>
                        <li><strong>Droit à la portabilité</strong> : vous pouvez demander le transfert de vos données à un autre responsable du traitement</li>
                        <li><strong>Droit d'opposition</strong> : vous pouvez vous opposer au traitement de vos données dans certaines circonstances</li>
                    </ul>
                    <p class="text-slate-600 mt-2">
                        Pour exercer ces droits, veuillez nous contacter à <a href="mailto:privacy@lynza.fr" class="text-indigo-600 hover:text-indigo-800">privacy@lynza.fr</a>.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">9. Cookies</h2>
                    <p class="text-slate-600">
                        Nous utilisons des cookies et des technologies similaires pour améliorer votre expérience sur notre plateforme.
                        Vous pouvez gérer vos préférences en matière de cookies via les paramètres de votre navigateur.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">10. Modifications de la politique de confidentialité</h2>
                    <p class="text-slate-600">
                        Nous pouvons mettre à jour cette politique de confidentialité de temps à autre. La version la plus récente
                        sera toujours disponible sur notre site web. Nous vous encourageons à consulter régulièrement cette page
                        pour rester informé des changements.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-slate-800 mb-3">11. Contact</h2>
                    <p class="text-slate-600">
                        Si vous avez des questions concernant cette politique de confidentialité ou nos pratiques en matière de
                        protection des données, veuillez nous contacter :
                    </p>
                    <ul class="list-disc list-inside text-slate-600 mt-2">
                        <li>Par email : <a href="mailto:privacy@lynza.fr" class="text-indigo-600 hover:text-indigo-800">privacy@lynza.fr</a></li>
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
                <a href="{{ route('confidentialite') }}" class="text-indigo-400 hover:text-white transition">Confidentialité</a>
                <a href="{{ route('cgu') }}" class="text-slate-300 hover:text-white transition">CGU</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
