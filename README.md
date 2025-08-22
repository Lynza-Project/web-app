# 🌐 Lynza – Intranet Modulaire

**Lynza** est une plateforme **marque blanche** destinée aux structures éducatives (écoles, collèges, lycées) et aux clubs sportifs ou aux associations.
Chaque organisation peut créer son propre intranet **personnalisable** pour gérer sa communauté, communiquer efficacement et organiser ses événements.

---

## 🚀 Fonctionnalités

- 🎨 **Personnalisation**  
  Couleurs et logo propres à chaque entité.

- 👥 **Gestion des Membres**
    - Importation d’e-mails pour inviter des utilisateurs.
    - Rôles : Administrateurs / Utilisateurs standards.
    - Profil utilisateur de base.

- 📅 **Événements**
    - Création et gestion (titre, description, date, lieu).

- 💬 **Communication & Ticketing**  
  Messagerie interne entre membres et administrateurs.

- 📚 **Ressources documentaires**  
  Gestion de resources documentaires internes.

- 📰 **Actualités**
    - Publication d’annonces et articles (texte, images, vidéos, fichiers).

- 📩 **Formulaire de contact**  
  Formulaire de contact support.
---

## 🧰 Prérequis

- Docker Desktop
- WSL 2 avec une distribution Linux (ex. Debian)
- PHP 8.2
- Node.js ≥ 18 et NPM
- Git
- PostgreSQL (via Laravel Sail)

---

## ⚙️ Installation & Lancement (via Laravel Sail)

1. **Cloner le dépôt**  
   git clone https://github.com/Lynza-Project/web-app.git  
   cd web-app

2. **Copier l’environnement**  
   cp .env.example .env

3. **Installer les dépendances**  
   composer install

4. **Démarrer Sail**  
   ./vendor/bin/sail up -d

5. **Installer les dépendances front**  
   npm install  
   npm run dev

6. **Initialiser l’application**  
   ./vendor/bin/sail artisan key:generate  
   ./vendor/bin/sail artisan migrate --seed

   > ℹ️ Les seeders créent une organisation de démonstration.

**URL par défaut :** http://localhost

---

## 🔧 Commandes utiles

- Démarrer Sail : ./vendor/bin/sail up -d
- Arrêter Sail : ./vendor/bin/sail down
- Logs : ./vendor/bin/sail logs -f
- Migrations : ./vendor/bin/sail artisan migrate
- Reset DB : ./vendor/bin/sail artisan migrate:fresh --seed
- Vider caches : ./vendor/bin/sail artisan optimize:clear
- Tests : ./vendor/bin/sail artisan test

---

## 📂 Stack & Architecture

- **TALL Stack** : Tailwind CSS, Alpine.js, Laravel, Livewire
- **Base de données** : PostgreSQL (via Sail)
- **Stockage médias** : Laravel cloud S3 (AWS S3)
- **Notifications** : Email

---

## 🔮 Roadmap

- **v2.0** : Gestion des sondages, objets perdus/trouvés.
- **v3.0** : IA (objets trouvés), gamification, API publique.

---

## 📄 Licence

Projet académique – **Master 2 Expert en Développement Web**.  
Usage pédagogique et démonstratif.  
Auteur : **Louis REYNARD**  
Date : **2024-2025**
