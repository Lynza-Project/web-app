<?php

namespace Database\Seeders;

use App\Models\Actuality;
use App\Models\Address;
use App\Models\Documentation;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Theme;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create "Les Minimes" organization
        $organization = $this->createOrganization();

        // Create theme for the organization
        $theme = $this->createTheme($organization);

        // Create address for the organization
        $this->createAddress($organization);

        // Create 3 admin users (including Louis REYNARD)
        $adminUsers = $this->createAdminUsers($organization, $theme);

        // Create 15 events between August 1 and December 31, 2025
        $this->createEvents($organization, $adminUsers);

        // Create 10 documentation items
        $this->createDocumentations($organization, $adminUsers);

        // Create 10 news articles between June 1 and August 31
        $this->createActualities($organization, $adminUsers);

        // Create 100 student users with tickets
        $this->createStudentsWithTickets($organization, $theme, $adminUsers);
    }

    /**
     * Create "Les Minimes" organization
     */
    private function createOrganization(): Organization
    {
        $organization = Organization::create([
            'name' => 'Les Minimes',
            'type' => 'School',
            'logo' => null, // Could be updated with a real logo path if needed
        ]);

        return $organization;
    }

    /**
     * Create theme for the organization
     */
    private function createTheme(Organization $organization): Theme
    {
        $theme = Theme::create([
            'organization_id' => $organization->id,
            'title' => 'Les Minimes Theme',
            'primary' => 'blue-600', // School blue color
            'font' => 'Inter',
            'background_color' => 'white',
            'button_color' => 'blue-500',
            'logo_path' => null, // Could be updated with a real logo path if needed
        ]);

        return $theme;
    }

    /**
     * Create address for the organization
     */
    private function createAddress(Organization $organization): Address
    {
        $address = Address::create([
            'organization_id' => $organization->id,
            'number' => '12',
            'name' => 'Rue des Éducateurs',
            'zip_code' => '75001',
            'country' => 'France',
            'region' => 'Île-de-France',
        ]);

        return $address;
    }

    /**
     * Create 3 admin users (including Louis REYNARD)
     */
    private function createAdminUsers(Organization $organization, Theme $theme): array
    {
        $password = Hash::make('password');
        $adminUsers = [];

        // Create Louis REYNARD admin user
        $adminUsers[] = User::create([
            'email' => 'louisreynard919@gmail.com',
            'password' => $password,
            'first_name' => 'Louis',
            'last_name' => 'REYNARD',
            'organization_id' => $organization->id,
            'theme_id' => $theme->id,
            'role' => 'admin',
            'profile_picture' => null,
        ]);

        // Create 2 more admin users
        $adminNames = [
            ['first_name' => 'Marie', 'last_name' => 'DUPONT'],
            ['first_name' => 'Jean', 'last_name' => 'MARTIN'],
        ];

        foreach ($adminNames as $admin) {
            $adminUsers[] = User::create([
                'email' => strtolower($admin['first_name']) . '.' . strtolower($admin['last_name']) . '@lesminimes.edu',
                'password' => $password,
                'first_name' => $admin['first_name'],
                'last_name' => $admin['last_name'],
                'organization_id' => $organization->id,
                'theme_id' => $theme->id,
                'role' => 'admin',
                'profile_picture' => null,
            ]);
        }

        return $adminUsers;
    }

    /**
     * Create 10 news articles between June 1 and August 31
     */
    private function createActualities(Organization $organization, array $adminUsers): void
    {
        $actualityData = [
            [
                'title' => 'Résultats exceptionnels au baccalauréat 2025 ! 🎓',
                'content' => '<p>Nous sommes fiers d\'annoncer les résultats exceptionnels de nos élèves au baccalauréat 2025 ! 🎉</p><p>Cette année, le lycée Les Minimes a obtenu :</p><ul><li>98% de réussite toutes sections confondues</li><li>65% de mentions</li><li>15 mentions Très Bien</li></ul><p>Félicitations à tous nos bacheliers pour leur travail et leur persévérance ! 👏</p><p>Une cérémonie de remise des diplômes sera organisée le 15 septembre 2025 à 18h dans l\'amphithéâtre.</p>',
                'date' => '2025-07-10',
            ],
            [
                'title' => 'Victoire au tournoi inter-lycées de basketball ! 🏀',
                'content' => '<p>L\'équipe de basketball des Minimes remporte le tournoi inter-lycées 2025 ! 🏆</p><p>Après une finale haletante contre le lycée Saint-Exupéry (68-65), nos joueurs ont soulevé la coupe devant une salle comble.</p><p>Un grand bravo à toute l\'équipe et à leur coach, M. Dupont, pour cette magnifique performance !</p><p>Les photos du tournoi sont disponibles dans la galerie de notre site web.</p>',
                'date' => '2025-06-15',
            ],
            [
                'title' => 'Rénovation de la cantine pour la rentrée 2025 🍽️',
                'content' => '<p>Nous sommes heureux de vous annoncer que la cantine du lycée sera entièrement rénovée cet été ! 🏗️</p><p>Au programme :</p><ul><li>Nouvel espace de restauration plus spacieux</li><li>Mobilier ergonomique</li><li>Insonorisation améliorée</li><li>Nouveau self-service plus fluide</li><li>Espace extérieur aménagé pour les beaux jours</li></ul><p>Les travaux débuteront le 5 juillet et s\'achèveront fin août, pour une cantine flambant neuve à la rentrée !</p>',
                'date' => '2025-06-25',
            ],
            [
                'title' => 'Projet Erasmus+ : 10 élèves en Espagne 🇪🇸',
                'content' => '<p>Dix élèves de Première ont participé à un échange Erasmus+ à Barcelone du 10 au 20 juin ! 🌍</p><p>Au programme de ce séjour linguistique et culturel :</p><ul><li>Cours en immersion au lycée Cervantes</li><li>Visites culturelles (Sagrada Familia, Parc Güell...)</li><li>Ateliers de cuisine catalane</li><li>Hébergement dans des familles locales</li></ul><p>Nos élèves ont été de formidables ambassadeurs des Minimes et ont tissé des liens durables avec leurs correspondants espagnols.</p><p>Nous accueillerons à notre tour les élèves espagnols en octobre 2025.</p>',
                'date' => '2025-06-22',
            ],
            [
                'title' => 'Conférence sur le changement climatique 🌍',
                'content' => '<p>Le 5 juin, Journée mondiale de l\'environnement, nous avons eu l\'honneur d\'accueillir le Dr. Martin, climatologue renommé, pour une conférence sur le changement climatique. 🌡️</p><p>Plus de 200 élèves ont assisté à cette présentation passionnante qui a abordé :</p><ul><li>Les dernières données scientifiques</li><li>Les conséquences déjà observables</li><li>Les solutions à notre portée</li><li>Les métiers d\'avenir dans ce domaine</li></ul><p>Cette conférence s\'inscrit dans notre démarche d\'établissement éco-responsable et a suscité de nombreuses vocations parmi nos élèves.</p>',
                'date' => '2025-06-06',
            ],
            [
                'title' => 'Exposition d\'arts plastiques : "Rêves et Réalités" 🎨',
                'content' => '<p>L\'exposition annuelle des travaux d\'arts plastiques "Rêves et Réalités" s\'est tenue du 15 au 20 juillet dans le hall du lycée. 🖼️</p><p>Les visiteurs ont pu admirer plus de 100 œuvres réalisées par nos élèves tout au long de l\'année :</p><ul><li>Peintures</li><li>Sculptures</li><li>Photographies</li><li>Installations numériques</li><li>Art vidéo</li></ul><p>Un grand merci à Mme Leroy, professeure d\'arts plastiques, pour son accompagnement inspirant, et félicitations à tous nos artistes en herbe pour leur créativité débordante !</p>',
                'date' => '2025-07-21',
            ],
            [
                'title' => 'Collecte solidaire : merci pour votre générosité ! ❤️',
                'content' => '<p>La collecte solidaire organisée en juin au profit de l\'association "Un toit pour tous" a été un immense succès ! 📦</p><p>Grâce à votre générosité, nous avons pu récolter :</p><ul><li>150 kg de denrées alimentaires</li><li>200 vêtements en bon état</li><li>50 kg de fournitures scolaires</li><li>1500€ de dons</li></ul><p>Ces dons permettront d\'aider des familles en difficulté pendant l\'été.</p><p>Un grand merci à tous les participants et aux élèves du CVL qui ont organisé cette belle action citoyenne ! 🙏</p>',
                'date' => '2025-06-30',
            ],
            [
                'title' => 'Nos élèves brillent aux Olympiades de Mathématiques ! 🧮',
                'content' => '<p>Félicitations à nos mathématiciens qui ont brillé aux Olympiades Nationales de Mathématiques 2025 ! 🏅</p><p>Palmarès :</p><ul><li>Emma Dubois (1ère S) : Médaille d\'or au niveau national</li><li>Lucas Martin (1ère S) : Médaille d\'argent</li><li>Chloé Petit (1ère S) : Mention honorable</li></ul><p>Emma représentera la France aux Olympiades Internationales de Mathématiques qui se tiendront à Tokyo en septembre 2025.</p><p>Un grand bravo à ces élèves exceptionnels et à M. Bernard, leur professeur de mathématiques, pour cette préparation d\'excellence !</p>',
                'date' => '2025-07-05',
            ],
            [
                'title' => 'Nouveau partenariat avec l\'Université Paris-Saclay 🤝',
                'content' => '<p>Nous sommes heureux d\'annoncer la signature d\'un partenariat avec l\'Université Paris-Saclay pour l\'année 2025-2026 ! 🎓</p><p>Ce partenariat offrira à nos élèves :</p><ul><li>Des conférences mensuelles par des chercheurs</li><li>Des visites des laboratoires universitaires</li><li>Des stages d\'observation pour les Terminales</li><li>Un accès privilégié aux journées portes ouvertes</li><li>Un programme de tutorat par des étudiants</li></ul><p>Cette collaboration prestigieuse enrichira le parcours de nos élèves et facilitera leur transition vers l\'enseignement supérieur.</p>',
                'date' => '2025-07-15',
            ],
            [
                'title' => 'Réaménagement de la cour : les travaux ont commencé ! 🏗️',
                'content' => '<p>Les travaux de réaménagement de la cour ont débuté le 15 août et avancent à grands pas ! 🚧</p><p>Ce projet, conçu en collaboration avec les élèves du CVL, comprend :</p><ul><li>Installation de nouveaux bancs et tables</li><li>Création d\'un espace vert avec jardin pédagogique</li><li>Rénovation du terrain multisport</li><li>Installation d\'une fontaine à eau</li><li>Mise en place d\'un préau supplémentaire</li></ul><p>Les travaux seront terminés pour la rentrée, offrant à tous un cadre de vie agréable et convivial.</p><p>Merci à la Région pour le financement de ce beau projet !</p>',
                'date' => '2025-08-20',
            ]
        ];

        foreach ($actualityData as $data) {
            Actuality::create([
                'organization_id' => $organization->id,
                'user_id' => $adminUsers[array_rand($adminUsers)]->id,
                'title' => $data['title'],
                'content' => $data['content'],
                'image' => null,
                'created_at' => $data['date'],
                'updated_at' => $data['date'],
            ]);
        }
    }

    /**
     * Create 10 documentation items for students
     */
    private function createDocumentations(Organization $organization, array $adminUsers): void
    {
        $documentationData = [
            [
                'title' => 'Guide de rentrée 2025-2026 📚',
                'content' => '<h2>Bienvenue aux Minimes !</h2><p>Ce guide contient toutes les informations essentielles pour bien débuter l\'année scolaire.</p><h3>Horaires</h3><ul><li>Ouverture des portes : 7h45</li><li>Début des cours : 8h15</li><li>Pause déjeuner : 12h00-13h30</li><li>Fin des cours : 17h30</li></ul><h3>Documents à fournir</h3><p>Merci de remettre au secrétariat avant le 15 septembre :</p><ul><li>Fiche de renseignements complétée</li><li>Attestation d\'assurance scolaire</li><li>Photocopie du carnet de vaccination</li></ul><p>Bonne rentrée à tous ! 🎓</p>'
            ],
            [
                'title' => 'Règlement intérieur 📋',
                'content' => '<h2>Règlement intérieur du Lycée Les Minimes</h2><p>Ce règlement définit les droits et devoirs de chacun au sein de notre établissement.</p><h3>Assiduité et ponctualité</h3><p>La présence à tous les cours est obligatoire. Toute absence doit être justifiée par les parents ou le responsable légal.</p><h3>Respect des personnes et des biens</h3><p>Chacun doit faire preuve de respect envers autrui et prendre soin du matériel et des locaux.</p><h3>Usage des appareils électroniques</h3><p>L\'utilisation des téléphones portables est interdite pendant les cours sauf autorisation expresse de l\'enseignant à des fins pédagogiques.</p><p>Le non-respect du règlement entraînera des sanctions proportionnées à la gravité des faits.</p>'
            ],
            [
                'title' => 'Guide d\'utilisation de l\'ENT 💻',
                'content' => '<h2>Espace Numérique de Travail - Guide d\'utilisation</h2><p>L\'ENT est votre plateforme numérique pour suivre votre scolarité.</p><h3>Première connexion</h3><ol><li>Rendez-vous sur <a href="https://ent.lesminimes.edu">https://ent.lesminimes.edu</a></li><li>Utilisez l\'identifiant et le mot de passe fournis par l\'établissement</li><li>Changez votre mot de passe à la première connexion</li></ol><h3>Fonctionnalités principales</h3><ul><li>Emploi du temps 📅</li><li>Cahier de texte 📝</li><li>Notes et bulletins 📊</li><li>Messagerie 📧</li><li>Ressources pédagogiques 📚</li></ul><p>En cas de difficulté, contactez le référent numérique : <a href="mailto:support@lesminimes.edu">support@lesminimes.edu</a></p>'
            ],
            [
                'title' => 'Orientation post-bac 🎓',
                'content' => '<h2>Guide d\'orientation post-baccalauréat</h2><p>Ce document vous accompagne dans vos choix d\'études supérieures.</p><h3>Calendrier Parcoursup</h3><ul><li>Décembre : Ouverture du site d\'information</li><li>Janvier-Mars : Formulation des vœux</li><li>Avril-Mai : Confirmation des vœux</li><li>Juin-Juillet : Phase d\'admission</li></ul><h3>Les filières principales</h3><ul><li>Université (Licence, Master, Doctorat)</li><li>Classes préparatoires (CPGE)</li><li>BTS et BUT</li><li>Écoles spécialisées</li><li>Formations en alternance</li></ul><p>N\'hésitez pas à prendre rendez-vous avec notre conseiller d\'orientation ! 🧭</p>'
            ],
            [
                'title' => 'Protocole sanitaire 🧼',
                'content' => '<h2>Protocole sanitaire - Année 2025-2026</h2><p>Pour la santé de tous, merci de respecter ces consignes.</p><h3>Gestes barrières</h3><ul><li>Lavage régulier des mains</li><li>Utilisation du gel hydroalcoolique disponible dans chaque salle</li><li>Aération des salles pendant les pauses</li></ul><h3>En cas de symptômes</h3><p>Ne pas venir au lycée et prévenir la vie scolaire en cas de :</p><ul><li>Fièvre (38°C ou plus)</li><li>Toux persistante</li><li>Maux de gorge sévères</li></ul><p>Prenons soin les uns des autres ! ❤️</p>'
            ],
            [
                'title' => 'Options et spécialités 🔍',
                'content' => '<h2>Guide des options et spécialités</h2><p>Découvrez toutes les options et spécialités proposées aux Minimes.</p><h3>Spécialités en Première et Terminale</h3><ul><li>Mathématiques</li><li>Physique-Chimie</li><li>Sciences de la Vie et de la Terre</li><li>Sciences Économiques et Sociales</li><li>Histoire-Géographie, Géopolitique et Sciences Politiques</li><li>Humanités, Littérature et Philosophie</li><li>Langues, Littératures et Cultures Étrangères</li><li>Numérique et Sciences Informatiques</li></ul><h3>Options facultatives</h3><ul><li>Latin</li><li>Grec ancien</li><li>Arts plastiques</li><li>Musique</li><li>Théâtre</li><li>EPS renforcée</li></ul><p>Faites vos choix selon vos goûts et votre projet d\'orientation ! 🌟</p>'
            ],
            [
                'title' => 'Bourses et aides financières 💰',
                'content' => '<h2>Guide des bourses et aides financières</h2><p>Informations sur les dispositifs d\'aide accessibles aux familles.</p><h3>Bourses nationales</h3><p>Les demandes doivent être déposées avant le 15 octobre 2025.</p><p>Documents nécessaires :</p><ul><li>Avis d\'imposition 2024</li><li>Livret de famille</li><li>RIB</li></ul><h3>Fonds social lycéen</h3><p>Aide ponctuelle pour les familles en difficulté (cantine, voyages, matériel).</p><p>Contactez l\'assistante sociale de l\'établissement pour constituer un dossier.</p><p>Permanences : lundi et jeudi de 9h à 16h.</p>'
            ],
            [
                'title' => 'Clubs et activités extrascolaires 🎨',
                'content' => '<h2>Clubs et activités des Minimes</h2><p>Découvrez toutes les activités proposées en dehors des cours !</p><h3>Clubs artistiques</h3><ul><li>Club théâtre (mardi, 17h30-19h30)</li><li>Chorale (mercredi, 13h30-15h30)</li><li>Arts plastiques (jeudi, 17h30-19h30)</li></ul><h3>Clubs scientifiques</h3><ul><li>Robotique (lundi, 17h30-19h30)</li><li>Astronomie (vendredi, 20h-22h)</li><li>Développement durable (mercredi, 13h30-15h30)</li></ul><h3>Clubs sportifs</h3><ul><li>Basket (mercredi, 15h30-17h30)</li><li>Badminton (vendredi, 17h30-19h30)</li><li>Escalade (mardi, 17h30-19h30)</li></ul><p>Inscriptions auprès de la vie scolaire jusqu\'au 30 septembre ! 🎭🔬🏀</p>'
            ],
            [
                'title' => 'Calendrier des examens 📅',
                'content' => '<h2>Calendrier des examens 2025-2026</h2><p>Dates importantes à retenir pour cette année scolaire.</p><h3>Épreuves anticipées de Première</h3><ul><li>Français écrit : 15 juin 2026</li><li>Français oral : du 22 au 26 juin 2026</li></ul><h3>Épreuves de spécialité Terminale</h3><ul><li>Du 15 au 17 mars 2026</li></ul><h3>Épreuves finales Terminale</h3><ul><li>Philosophie : 15 juin 2026</li><li>Grand oral : du 22 juin au 3 juillet 2026</li></ul><h3>Brevet</h3><ul><li>Épreuves écrites : 29 et 30 juin 2026</li></ul><p>Résultats du baccalauréat : 7 juillet 2026 🎓</p>'
            ],
            [
                'title' => 'Guide de la médiathèque 📚',
                'content' => '<h2>Médiathèque des Minimes - Guide pratique</h2><p>Tout ce qu\'il faut savoir pour profiter de notre médiathèque.</p><h3>Horaires d\'ouverture</h3><ul><li>Lundi au vendredi : 8h00-18h00</li><li>Mercredi : 8h00-16h00</li></ul><h3>Emprunts</h3><p>Chaque élève peut emprunter :</p><ul><li>3 livres pour 3 semaines</li><li>2 revues pour 2 semaines</li><li>1 DVD pour 1 semaine</li></ul><h3>Espaces</h3><ul><li>Espace travail silencieux</li><li>Espace travail collaboratif</li><li>Espace informatique (12 postes)</li><li>Espace détente et lecture</li></ul><p>La médiathèque propose également un accès aux ressources numériques Éduthèque et Universalis. 📖💻</p>'
            ]
        ];

        // Create all 10 documentations
        foreach ($documentationData as $data) {
            Documentation::create([
                'organization_id' => $organization->id,
                'user_id' => $adminUsers[array_rand($adminUsers)]->id,
                'title' => $data['title'],
                'content' => $data['content'],
                'image' => null,
            ]);
        }
    }

    /**
     * Create 100 student users with tickets
     */
    private function createStudentsWithTickets(Organization $organization, Theme $theme, array $adminUsers): void
    {
        $password = Hash::make('password');
        $studentUsers = [];
        $ticketStatuses = ['open', 'closed'];
        $ticketSubjects = [
            'Problème de connexion à l\'ENT',
            'Demande de changement d\'option',
            'Absence prévue',
            'Problème avec mon emploi du temps',
            'Question sur les devoirs',
            'Demande de rendez-vous avec un conseiller',
            'Problème technique avec mon compte',
            'Inscription à un club',
            'Demande de bourse',
            'Perte de carte d\'étudiant',
            'Question sur les examens',
            'Demande de certificat de scolarité',
            'Problème dans la cantine',
            'Suggestion pour l\'établissement',
            'Signalement d\'un incident'
        ];

        // First names for students
        $firstNames = [
            'Emma', 'Lucas', 'Chloé', 'Nathan', 'Léa', 'Thomas', 'Camille', 'Hugo', 'Sarah', 'Théo',
            'Manon', 'Maxime', 'Jade', 'Alexandre', 'Inès', 'Antoine', 'Lola', 'Louis', 'Julie', 'Paul',
            'Zoé', 'Mathis', 'Lucie', 'Enzo', 'Clara', 'Ethan', 'Océane', 'Gabriel', 'Maëlys', 'Yanis',
            'Juliette', 'Clément', 'Lilou', 'Rayan', 'Eva', 'Mathéo', 'Romane', 'Axel', 'Louise', 'Jules',
            'Ambre', 'Nolan', 'Alice', 'Valentin', 'Lina', 'Maxence', 'Anaïs', 'Evan', 'Louna', 'Raphaël'
        ];

        // Last names for students
        $lastNames = [
            'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit', 'Durand', 'Leroy', 'Moreau',
            'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia', 'David', 'Bertrand', 'Roux', 'Vincent', 'Fournier',
            'Morel', 'Girard', 'André', 'Lefevre', 'Mercier', 'Dupont', 'Lambert', 'Bonnet', 'Francois', 'Martinez',
            'Legrand', 'Garnier', 'Faure', 'Rousseau', 'Blanc', 'Guerin', 'Muller', 'Henry', 'Roussel', 'Nicolas',
            'Perrin', 'Morin', 'Mathieu', 'Clement', 'Gauthier', 'Dumont', 'Lopez', 'Fontaine', 'Chevalier', 'Robin'
        ];

        // Create 100 student users
        for ($i = 0; $i < 100; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];

            $student = User::create([
                'email' => strtolower($firstName) . '.' . strtolower($lastName) . rand(10, 99) . '@lesminimes.edu',
                'password' => $password,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'organization_id' => $organization->id,
                'theme_id' => $theme->id,
                'role' => 'user',
                'profile_picture' => null,
            ]);

            $studentUsers[] = $student;

            // Create 1-3 open tickets for each student
            $openTicketsCount = rand(1, 3);
            for ($j = 0; $j < $openTicketsCount; $j++) {
                $this->createTicketWithMessages($student, $organization, $adminUsers, 'open');
            }

            // Create 1-2 closed tickets for each student
            $closedTicketsCount = rand(1, 2);
            for ($j = 0; $j < $closedTicketsCount; $j++) {
                $this->createTicketWithMessages($student, $organization, $adminUsers, 'closed');
            }
        }
    }

    /**
     * Create a ticket with messages
     */
    private function createTicketWithMessages(User $student, Organization $organization, array $adminUsers, string $status): void
    {
        $ticketSubjects = [
            'Problème de connexion à l\'ENT',
            'Demande de changement d\'option',
            'Absence prévue',
            'Problème avec mon emploi du temps',
            'Question sur les devoirs',
            'Demande de rendez-vous avec un conseiller',
            'Problème technique avec mon compte',
            'Inscription à un club',
            'Demande de bourse',
            'Perte de carte d\'étudiant',
            'Question sur les examens',
            'Demande de certificat de scolarité',
            'Problème dans la cantine',
            'Suggestion pour l\'établissement',
            'Signalement d\'un incident'
        ];

        $subject = $ticketSubjects[array_rand($ticketSubjects)];

        // Create initial descriptions based on the subject
        $descriptions = [
            'Problème de connexion à l\'ENT' => 'Bonjour, je n\'arrive pas à me connecter à l\'ENT depuis hier. J\'ai essayé de réinitialiser mon mot de passe mais je ne reçois pas l\'email de confirmation. Pouvez-vous m\'aider ?',
            'Demande de changement d\'option' => 'Bonjour, je souhaiterais changer mon option de spécialité. Je suis actuellement en Mathématiques mais je préférerais passer en Sciences Économiques et Sociales. Est-ce encore possible ?',
            'Absence prévue' => 'Bonjour, je vous informe que je serai absent du 15 au 18 octobre pour raison médicale. J\'ai un rendez-vous important à l\'hôpital. Pourriez-vous prévenir mes professeurs ?',
            'Problème avec mon emploi du temps' => 'Bonjour, il semble y avoir une erreur dans mon emploi du temps. J\'ai deux cours en même temps le jeudi de 14h à 16h (Mathématiques et Anglais). Pouvez-vous vérifier ?',
            'Question sur les devoirs' => 'Bonjour, je n\'ai pas pu noter tous les devoirs pour la semaine prochaine en cours de physique. Pourriez-vous me dire ce qui a été demandé ?',
            'Demande de rendez-vous avec un conseiller' => 'Bonjour, j\'aimerais prendre rendez-vous avec un conseiller d\'orientation pour discuter de mes choix post-bac. Quelles sont les disponibilités ?',
            'Problème technique avec mon compte' => 'Bonjour, je ne peux plus accéder à mes documents sur l\'espace de stockage en ligne. Un message d\'erreur s\'affiche indiquant "quota dépassé" mais je n\'ai presque rien stocké.',
            'Inscription à un club' => 'Bonjour, je souhaiterais m\'inscrire au club de théâtre. Comment dois-je procéder ? Y a-t-il encore des places disponibles ?',
            'Demande de bourse' => 'Bonjour, je voudrais savoir comment faire une demande de bourse pour l\'année prochaine. Quels sont les documents nécessaires et les délais ?',
            'Perte de carte d\'étudiant' => 'Bonjour, j\'ai perdu ma carte d\'étudiant hier dans l\'établissement. Comment puis-je en obtenir une nouvelle ? Y a-t-il des frais ?',
            'Question sur les examens' => 'Bonjour, j\'aimerais savoir si les dates des examens blancs du deuxième trimestre sont déjà fixées. J\'ai besoin de planifier un rendez-vous médical.',
            'Demande de certificat de scolarité' => 'Bonjour, j\'aurais besoin d\'un certificat de scolarité pour mon dossier de demande de logement étudiant. Comment puis-je l\'obtenir ?',
            'Problème dans la cantine' => 'Bonjour, je souffre d\'une allergie alimentaire (arachides) et j\'ai constaté que les allergènes ne sont pas toujours bien indiqués à la cantine. Pourriez-vous faire le nécessaire ?',
            'Suggestion pour l\'établissement' => 'Bonjour, j\'aimerais suggérer l\'installation de plus de prises électriques dans la salle d\'étude pour que nous puissions charger nos ordinateurs pendant les heures de travail.',
            'Signalement d\'un incident' => 'Bonjour, je souhaite signaler un problème de fuite d\'eau dans les toilettes du deuxième étage. L\'eau coule en permanence et inonde parfois le sol.'
        ];

        // Create the ticket
        $ticket = Ticket::create([
            'organization_id' => $organization->id,
            'user_id' => $student->id,
            'subject' => $subject,
            'description' => $descriptions[$subject] ?? 'Bonjour, j\'ai une question concernant ' . $subject . '. Pouvez-vous m\'aider ?',
            'status' => $status,
        ]);

        // Create initial message from student
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => $student->id,
            'organization_id' => $organization->id,
            'content' => $descriptions[$subject] ?? 'Bonjour, j\'ai une question concernant ' . $subject . '. Pouvez-vous m\'aider ?',
        ]);

        // Create 2-5 messages for conversation
        $messageCount = rand(2, 5);
        $admin = $adminUsers[array_rand($adminUsers)];

        // Admin response templates
        $adminResponses = [
            'Problème de connexion à l\'ENT' => [
                'Bonjour, merci pour votre message. Avez-vous essayé de vider le cache de votre navigateur ? Cela résout souvent ce type de problème.',
                'Je viens de vérifier votre compte et il semble qu\'il y ait eu un problème technique. J\'ai réinitialisé vos accès, vous devriez pouvoir vous connecter maintenant.',
                'N\'hésitez pas à nous tenir informés si le problème persiste. Bonne journée !'
            ],
            'Demande de changement d\'option' => [
                'Bonjour, merci pour votre demande. Les changements d\'option sont possibles jusqu\'au 15 octobre. Pouvez-vous me préciser votre classe actuelle ?',
                'J\'ai bien noté votre demande. Je vais la transmettre au responsable pédagogique qui prendra la décision finale.',
                'Votre demande a été acceptée. Le changement sera effectif à partir de lundi prochain. Votre nouvel emploi du temps sera disponible sur l\'ENT.'
            ],
            'default' => [
                'Bonjour, merci pour votre message. Nous avons bien pris en compte votre demande.',
                'Après vérification, je peux vous apporter les informations suivantes...',
                'N\'hésitez pas à nous recontacter si vous avez d\'autres questions. Bonne journée !'
            ]
        ];

        // Student follow-up templates
        $studentFollowUps = [
            'Merci beaucoup pour votre réponse rapide !',
            'J\'ai une question supplémentaire concernant ce sujet...',
            'Le problème est résolu, merci pour votre aide.',
            'Parfait, je vous remercie pour ces informations.',
            'D\'accord, j\'attendrai votre retour.'
        ];

        // Create conversation
        $lastSender = $student;

        for ($i = 0; $i < $messageCount; $i++) {
            // Alternate between admin and student
            if ($lastSender->id === $student->id) {
                // Admin response
                $responseSet = $adminResponses[$subject] ?? $adminResponses['default'];
                $content = $responseSet[$i % count($responseSet)];

                TicketMessage::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $admin->id,
                    'organization_id' => $organization->id,
                    'content' => $content,
                ]);

                $lastSender = $admin;
            } else {
                // Student follow-up
                $content = $studentFollowUps[array_rand($studentFollowUps)];

                TicketMessage::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $student->id,
                    'organization_id' => $organization->id,
                    'content' => $content,
                ]);

                $lastSender = $student;
            }
        }

        // If status is closed, add a closing message from admin
        if ($status === 'closed') {
            TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => $admin->id,
                'organization_id' => $organization->id,
                'content' => 'Ce ticket est maintenant résolu et va être clôturé. N\'hésitez pas à ouvrir un nouveau ticket si vous avez d\'autres questions.',
            ]);
        }
    }

    /**
     * Create 15 events between August 1 and December 31, 2025
     */
    private function createEvents(Organization $organization, array $adminUsers): void
    {
        $eventData = [
            [
                'title' => 'Rentrée scolaire 2025-2026 📚',
                'description' => '<p>Bienvenue à tous les élèves pour cette nouvelle année scolaire ! 🎉</p><p>La rentrée se déroulera selon le planning suivant :</p><ul><li>8h30 : Accueil des nouveaux élèves</li><li>9h30 : Discours de bienvenue</li><li>10h30 : Distribution des emplois du temps</li><li>12h00 : Déjeuner de bienvenue</li></ul><p>N\'oubliez pas vos fournitures scolaires ! 📝</p>',
                'start_date' => '2025-09-01',
                'end_date' => null,
                'start_time' => '08:30',
                'end_time' => '16:00',
                'location' => 'Cour principale',
            ],
            [
                'title' => 'Bal de rentrée 💃🕺',
                'description' => '<p>Le traditionnel bal de rentrée des Minimes est de retour ! 🎵</p><p>Une soirée festive pour célébrer le début de l\'année scolaire et faire connaissance.</p><p>Tenue correcte exigée. Collation et rafraîchissements offerts par l\'établissement.</p>',
                'start_date' => '2025-09-15',
                'end_date' => null,
                'start_time' => '19:00',
                'end_time' => '23:00',
                'location' => 'Gymnase',
            ],
            [
                'title' => 'Journée portes ouvertes 🚪',
                'description' => '<p>Venez découvrir notre établissement lors de notre journée portes ouvertes annuelle ! 🏫</p><p>Au programme :</p><ul><li>Visite guidée des locaux</li><li>Rencontre avec les enseignants</li><li>Présentation des options et spécialités</li><li>Démonstrations des clubs et associations</li></ul><p>Entrée libre et gratuite. Bienvenue à tous !</p>',
                'start_date' => '2025-10-05',
                'end_date' => null,
                'start_time' => '10:00',
                'end_time' => '17:00',
                'location' => 'Tout l\'établissement',
            ],
            [
                'title' => 'Semaine des sciences 🔬',
                'description' => '<p>Une semaine dédiée aux sciences et à la découverte ! 🧪</p><p>Chaque jour, des ateliers, conférences et expériences seront proposés aux élèves.</p><p>Programme détaillé :</p><ul><li>Lundi : Physique-Chimie</li><li>Mardi : Sciences de la Vie et de la Terre</li><li>Mercredi : Mathématiques</li><li>Jeudi : Technologie et Informatique</li><li>Vendredi : Conférence d\'un scientifique renommé</li></ul>',
                'start_date' => '2025-10-13',
                'end_date' => '2025-10-17',
                'start_time' => '08:00',
                'end_time' => '17:00',
                'location' => 'Laboratoires et amphithéâtre',
            ],
            [
                'title' => 'Tournoi sportif inter-classes 🏆',
                'description' => '<p>Le grand tournoi sportif annuel est de retour ! 🏀⚽🏐</p><p>Chaque classe constituera des équipes pour s\'affronter dans différentes disciplines :</p><ul><li>Football</li><li>Basketball</li><li>Volleyball</li><li>Athlétisme</li></ul><p>Que le meilleur gagne ! Des médailles et une coupe seront remises aux vainqueurs.</p>',
                'start_date' => '2025-10-25',
                'end_date' => '2025-10-26',
                'start_time' => '09:00',
                'end_time' => '18:00',
                'location' => 'Terrains de sport',
            ],
            [
                'title' => 'Halloween aux Minimes 👻',
                'description' => '<p>Une journée spéciale pour célébrer Halloween ! 🎃</p><p>Au programme :</p><ul><li>Concours de déguisements</li><li>Décoration de citrouilles</li><li>Chasse aux bonbons dans l\'établissement</li><li>Projection d\'un film d\'horreur (adapté) en soirée</li></ul><p>Venez déguisés et prêts à vous amuser !</p>',
                'start_date' => '2025-10-31',
                'end_date' => null,
                'start_time' => '14:00',
                'end_time' => '21:00',
                'location' => 'Salle polyvalente',
            ],
            [
                'title' => 'Cérémonie du 11 novembre 🇫🇷',
                'description' => '<p>Commémoration de l\'Armistice du 11 novembre 1918.</p><p>Une délégation d\'élèves représentera l\'établissement lors de la cérémonie officielle au monument aux morts de la ville.</p><p>Un travail pédagogique sera mené en amont dans les classes d\'histoire.</p>',
                'start_date' => '2025-11-11',
                'end_date' => null,
                'start_time' => '10:00',
                'end_time' => '12:00',
                'location' => 'Monument aux morts',
            ],
            [
                'title' => 'Semaine de l\'orientation 🧭',
                'description' => '<p>Une semaine dédiée à l\'orientation et aux choix d\'études ! 🎓</p><p>Au programme :</p><ul><li>Forum des métiers</li><li>Rencontres avec des professionnels</li><li>Présentation des filières post-bac</li><li>Ateliers CV et lettre de motivation</li><li>Simulations d\'entretiens</li></ul><p>Un événement essentiel pour préparer votre avenir !</p>',
                'start_date' => '2025-11-17',
                'end_date' => '2025-11-21',
                'start_time' => '09:00',
                'end_time' => '17:00',
                'location' => 'CDI et salles de conférence',
            ],
            [
                'title' => 'Collecte alimentaire solidaire 🥫',
                'description' => '<p>Grande collecte alimentaire au profit des Restos du Cœur ! ❤️</p><p>Nous collectons :</p><ul><li>Conserves</li><li>Pâtes, riz</li><li>Produits d\'hygiène</li><li>Produits pour bébés</li></ul><p>Merci pour votre générosité qui fera une différence pour les plus démunis en cette période de fêtes.</p>',
                'start_date' => '2025-11-24',
                'end_date' => '2025-12-05',
                'start_time' => null,
                'end_time' => null,
                'location' => 'Hall d\'entrée',
            ],
            [
                'title' => 'Spectacle de fin d\'année 🎭',
                'description' => '<p>Le grand spectacle annuel des talents des Minimes ! 🌟</p><p>Venez découvrir les performances artistiques de nos élèves :</p><ul><li>Théâtre</li><li>Danse</li><li>Musique</li><li>Chant</li><li>Arts du cirque</li></ul><p>Un moment magique à ne pas manquer avant les vacances !</p>',
                'start_date' => '2025-12-12',
                'end_date' => null,
                'start_time' => '19:00',
                'end_time' => '22:00',
                'location' => 'Amphithéâtre',
            ],
            [
                'title' => 'Marché de Noël 🎄',
                'description' => '<p>Le traditionnel marché de Noël des Minimes ! ✨</p><p>Venez découvrir et acheter les créations des élèves :</p><ul><li>Objets artisanaux</li><li>Décorations de Noël</li><li>Pâtisseries et confiseries</li><li>Cartes de vœux</li></ul><p>Les bénéfices financeront les voyages scolaires. Vin chaud et chocolat chaud offerts !</p>',
                'start_date' => '2025-12-15',
                'end_date' => '2025-12-16',
                'start_time' => '16:00',
                'end_time' => '20:00',
                'location' => 'Préau couvert',
            ],
            [
                'title' => 'Repas de Noël 🍽️',
                'description' => '<p>Le grand repas de Noël de la cantine ! 🎅</p><p>Au menu :</p><ul><li>Entrée festive</li><li>Dinde aux marrons</li><li>Bûche de Noël</li></ul><p>Animation musicale et décoration spéciale pour ce moment convivial avant les vacances.</p>',
                'start_date' => '2025-12-18',
                'end_date' => null,
                'start_time' => '12:00',
                'end_time' => '14:00',
                'location' => 'Cantine',
            ],
            [
                'title' => 'Cérémonie de remise des bulletins 📝',
                'description' => '<p>Remise officielle des bulletins du premier trimestre en présence des parents.</p><p>Un moment d\'échange avec les professeurs principaux pour faire le point sur le début d\'année.</p><p>Collation offerte par l\'association des parents d\'élèves.</p>',
                'start_date' => '2025-12-19',
                'end_date' => null,
                'start_time' => '17:00',
                'end_time' => '20:00',
                'location' => 'Salles de classe',
            ],
            [
                'title' => 'Voyage scolaire à Londres 🇬🇧',
                'description' => '<p>Séjour linguistique et culturel à Londres pour les élèves de Première ! 🚌</p><p>Au programme :</p><ul><li>Visite des principaux monuments</li><li>British Museum</li><li>Natural History Museum</li><li>Comédie musicale à West End</li><li>Immersion dans des familles anglaises</li></ul><p>Un voyage inoubliable pour pratiquer l\'anglais et découvrir la culture britannique !</p>',
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-05',
                'start_time' => null,
                'end_time' => null,
                'location' => 'Londres',
            ],
            [
                'title' => 'Conférence sur l\'intelligence artificielle 🤖',
                'description' => '<p>Conférence exceptionnelle sur les enjeux de l\'intelligence artificielle dans notre société.</p><p>Intervenant : Dr. Sophie Martin, chercheuse en IA à l\'Université Paris-Saclay.</p><p>Thèmes abordés :</p><ul><li>Les fondements de l\'IA</li><li>Applications actuelles et futures</li><li>Questions éthiques</li><li>Impact sur l\'emploi et l\'éducation</li></ul><p>Ouvert aux élèves de Première et Terminale.</p>',
                'start_date' => '2025-12-08',
                'end_date' => null,
                'start_time' => '14:00',
                'end_time' => '16:00',
                'location' => 'Amphithéâtre',
            ],
        ];

        foreach ($eventData as $data) {
            Event::create([
                'organization_id' => $organization->id,
                'user_id' => $adminUsers[array_rand($adminUsers)]->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'location' => $data['location'],
                'image' => null,
            ]);
        }
    }
}
