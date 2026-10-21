<h1 align="center">🚗 SelectCars — Plateforme de gestion de pièces et machines</h1>

<p align="center">
  <strong>Application web full-stack de gestion de pièces automobiles, de machines industrielles et de commandes</strong><br>
  Projet de Fin d'Études (PFE) — Laravel 10
</p>

<p align="center">
  <a href="#a-propos">À propos</a> •
  <a href="#fonctionnalites">Fonctionnalités</a> •
  <a href="#roles-et-permissions">Rôles</a> •
  <a href="#stack-technique">Stack technique</a> •
  <a href="#installation">Installation</a> •
  <a href="#comptes-de-demonstration">Comptes</a> •
  <a href="#structure-du-projet">Structure</a> •
  <a href="#base-de-donnees">Base de données</a> •
  <a href="#routes-principales">Routes</a> •
  <a href="#securite">Sécurité</a>
</p>

---

## À propos

**SelectCars** est une plateforme e-commerce B2B/B2C destinée à une société de pièces automobiles et de machines. Elle couvre l'ensemble du cycle de vente :

- **Catalogue** de pièces et machines organisé par marque, modèle et catégorie
- **Gestion des commandes** avec affectation de livreur et suivi de livraison
- **Gestion des clients** (société, TVA, région…)
- **SAV** (Service Après-Vente) via un système de tickets de support
- **Facturation** avec génération et aperçu de factures
- **Back-office** complet (dashboard, statistiques, calendrier, contenu éditorial)

---

## Fonctionnalités

### Front Office (public)

| Page | Description |
|------|-------------|
| `/` | Page d'accueil : slider de bannières animé, formulaire de recherche, produits en avant |
| `/machine` | Catalogue public des machines/pièces |
| `/search` | Recherche par marque, modèle et fourchette de prix (chargement AJAX dynamique des modèles selon la marque) |
| `/FAQ` | Foire aux questions |
| `/contact-US` | Formulaire de contact avec enregistrement en base et notification par e-mail |

### Back Office (authentifié)

- **Dashboard** : statistiques (ventes, produits, supports, commandes)
- **Calendrier** : visualisation des commandes planifiées (dates de livraison)
- **Gestion des machines/pièces** : CRUD complet avec upload d'images, vérification d'unicité de la référence (AJAX)
- **Marques / Modèles / Catégories** : CRUD complet
- **Stock** : suivi et mise à jour des quantités par produit
- **Clients** : gestion des clients et de leurs comptes de connexion
- **Livreurs** : gestion des comptes livreurs
- **Commandes** : création, affectation d'un livreur, marquage « livré », suppression, facture et aperçu de facture
- **SAV / Support** : tickets créés par les clients, consultation et clôture par l'admin
- **Bannières** : gestion du slider de la page d'accueil
- **FAQ** : gestion du contenu de la page FAQ
- **Contacts** : consultation et suppression des messages reçus
- **Comptes** : gestion des comptes admin et client (création, édition, désactivation)

---

## Rôles et permissions

L'authentification repose sur le guard de session `admin` (table `admins`). Les accès sont contrôlés par les middlewares `admin`, `role` et `revalidate` (voir `routes/web.php`).

| Rôle | Accès |
|------|-------|
| **admin** | Accès total au back-office |
| **client** | Catalogue, détail des machines, création de commandes, consultation des commandes/factures, création de tickets SAV |
| **livreur** | Dashboard livreur, consultation des commandes, marquage « livré » |

| Groupe de routes | Middleware |
|------------------|------------|
| Gestion complète | `role:admin` |
| Vider le cache | `role:admin,livreur` |
| Consultation commandes + factures | `role:admin,client,livreur` |
| Création ticket SAV | `role:admin,client` |
| Création commande | `role:admin,client` |
| Catalogue client | `role:client` |
| Livraison | `role:livreur` |

---

## Stack technique

**Backend**
- PHP 8.1+
- Laravel 10.x
- MySQL
- Laravel UI 4.x (scaffolding d'authentification)
- Yajra Laravel DataTables 10.x (tables du back-office)
- Laravel Tinker, Laravel Helpers

**Frontend**
- Blade (moteur de templates)
- Bootstrap 5 + AdminLTE (thème du back-office)
- Swiper (slider), AOS (animations au scroll), noUiSlider, Nice Select
- jQuery + AJAX
- Vite (+ Laravel Mix présent pour compatibilité) et SASS

**Qualité / Dev**
- PHPUnit 10, Laravel Pint, Laravel Sail, FakerPHP

---

## Installation

### Prérequis

- PHP 8.1 ou supérieur (extensions : `mbstring`, `openssl`, `pdo_mysql`, `fileinfo`, `gd`)
- Composer 2
- Node.js 18+ et npm
- MySQL 5.7+ / MariaDB

### Étapes

```bash
# 1. Cloner le dépôt
git clone <url-du-depot>
cd cars

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer la base de données dans .env (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 6. Créer la base puis lancer migrations + seeders
php artisan migrate --seed

# 7. Compiler les assets
npm run build

# 8. Lancer le serveur de développement
php artisan serve
```

> **Note** : le `.env.example` est pré-configuré pour la production (`APP_ENV=production`, `APP_DEBUG=false`, session en base et chiffrée, cookie sécurisé). En développement local, passez `APP_ENV=local`, `APP_DEBUG=true` et `SESSION_SECURE_COOKIE=false`.

### Serveur de mail (développement)

Le projet est configuré pour [Mailpit](https://github.com/axllent/mailpit) (`MAIL_MAILER=smtp`, `MAIL_HOST=mailpit`, `MAIL_PORT=1025`) afin de tester les notifications e-mail (formulaire de contact) sans envoyer de vrais mails.

---

## Comptes de démonstration

Les comptes sont créés par le seeder `adminSeeder` (exécuté via `migrate --seed` ou `php artisan db:seed --class=adminSeeder`).

| Rôle | Login | E-mail |
|------|-------|--------|
| Admin | `admin` | admin@cars.com |
| Client | `user` | user@cars.com |
| Livreur | `livreur` | livreur@cars.com |

**Mot de passe** : défini par la variable `SEED_ADMIN_PASSWORD` / `SEED_CLIENT_PASSWORD` / `SEED_LIVREUR_PASSWORD` du `.env`. Si la variable est vide, un mot de passe aléatoire fort (16 caractères) est généré **et affiché une seule fois dans la console** pendant le seed :

```bash
php artisan db:seed --class=adminSeeder
# Compte « admin » (admin) → mot de passe : XXXXXXXXXXXXXXXX
```

> ⚠️ Les mots de passe sont stockés hachés (bcrypt) en base. Le re-seed met à jour les comptes existants sans les dupliquer (`updateOrInsert`).

---

## Structure du projet

```
cars/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # AdminController (login, dashboard, comptes, livreurs)
│   │   │   ├── Auth/           # Authentification (Login, Register, Forgot/Reset password…)
│   │   │   ├── Front/          # Home, FAQ, Contact, Catégorie, Banner, Dash, Login
│   │   │   └── …               # GestionMachine, MarqueMachine, ModelMachine, Stock,
│   │   │                       # Client, CommandeMachine, Support, Cache
│   │   ├── Middleware/         # Admin, EnsureRole, RevalidateBackHistory, SecurityHeaders…
│   │   └── Requests/
│   ├── Models/                 # Admin, Client, Commande_M, Detail_commandeM, Gestion_machine,
│   │                           # MarqueMachine, Model_machine, stock_machine, Categorie,
│   │                           # Support, Banner, Faq, Contact, Settings, User
│   ├── Policies/               # CommandePolicy
│   ├── Providers/              # RouteServiceProvider (rate limiter login), AuthServiceProvider…
│   └── Rules/                  # ReCaptcha
├── config/                     # Configuration (auth, session, database…)
├── database/
│   ├── migrations/             # 22 migrations (tables métier + sessions)
│   ├── factories/              # UserFactory
│   └── seeders/                # adminSeeder, DatabaseSeeder, seeders de données fictives
├── public/                     # Assets compilés, images uploadées
├── resources/
│   ├── views/
│   │   ├── back/               # Vues du back-office (admin_login, sidebar, dashboard,
│   │   │                       # gestion_machine, commandeM, client, support, faq, banner…)
│   │   ├── front/              # Vues publiques (home, search, faq, contact, app)
│   │   ├── layouts/            # Layouts partagés (front/back)
│   │   └── auth/               # Vues d'authentification (laravel/ui)
│   └── …
├── routes/
│   ├── web.php                 # Toutes les routes web (publiques + protégées par rôle)
│   ├── api.php                 # Aucune route API (auth par session, pas de tokens)
│   ├── channels.php
│   └── console.php
├── SECURITE.md                 # Document de durcissement sécurité (audit + plan)
├── composer.json
└── package.json
```

---

## Base de données

### Tables

| Table | Rôle |
|-------|------|
| `admins` | Comptes utilisateurs (rôles `admin`, `client`, `livreur`) — table d'authentification du guard `admin` |
| `clients` | Fiches clients (société, code TVA, adresse, région, téléphone) |
| `gestion_machines` | Catalogue produits/pièces (référence, titre, description, images, prix, quantité, marque, modèle) |
| `marque_machines` | Marques de machines/pièces |
| `model_machines` | Modèles de machines (liés à une marque) |
| `categories` | Catégories de produits |
| `stock_machines` | Suivi de stock par produit |
| `commande__ms` | Commandes (réf, client, livreur, prix, TVA, dates, état, paiement) |
| `detail_commande_ms` | Lignes de commande (produit, quantité) |
| `supports` | Tickets SAV |
| `contacts` | Messages du formulaire de contact |
| `banners` | Bannières du slider d'accueil |
| `faqs` | Questions/réponses de la FAQ |
| `settings` | Paramètres de l'application |
| `livreurs` | Table livreurs (historique, la gestion actuelle passe par `admins` + rôle) |
| `sessions` | Sessions (driver `database`) |
| `users`, `password_reset_tokens`, `password_resets`, `failed_jobs`, `personal_access_tokens` | Tables Laravel standard |

### Relations principales (Eloquent)

- `Gestion_machine` → `belongsTo` **MarqueMachine**, **Model_machine** ; `hasOne` **stock_machine** ; `hasMany` **Detail_commandeM**
- `Commande_M` → `belongsTo` **Admin** (client) ; `belongsTo` **Admin** (livreur) ; `hasMany` **Detail_commandeM** (par `ref_commande`)
- `Detail_commandeM` → lié au produit (`id_produit`)

---

## Routes principales

### Publiques

| URL | Nom | Description |
|-----|-----|-------------|
| `/` | `home` | Accueil |
| `/machine` | `machine` | Catalogue public |
| `/search` | `search` | Recherche (marque/modèle/prix, AJAX) |
| `/FAQ` | `faq` | FAQ |
| `/contact-US` | `contact.us.add` | Formulaire de contact (GET) |
| `POST /contact-US/add` | `contact.us.store` | Envoi du formulaire |
| `/admin` | `login.form` | Page de connexion back-office |
| `POST /admin/login-functionality` | `login.functionality` | Connexion (throttle : 5 tentatives/min) |

### Back-office (extraits)

| URL | Description |
|-----|-------------|
| `GET /admin/dashboard` | Dashboard admin (statistiques) |
| `GET /admin/calendar` | Calendrier des commandes |
| `GET /admin/list_machine` … `POST /admin/list_machine/{id}/update` | CRUD machines |
| `GET /admin/list_marque`, `/admin/list_model`, `/admin/list_categories` | CRUD marques / modèles / catégories |
| `GET /admin/list_stock/machine` | Consultation du stock |
| `GET /admin/list_client`, `/admin/list_compte` | Gestion clients et comptes |
| `GET /admin/list_livreurs` | Gestion des livreurs |
| `GET /admin/list_commandeM` | Liste des commandes (DataTables) |
| `GET /admin/list_commandeM/{id}/facture` + `/apercu` | Facture et aperçu |
| `GET /admin/support` | Tickets SAV |
| `GET /admin/list_faq`, `/admin/list_banners`, `/admin/list_contact` | Contenus éditoriaux |
| `GET /client/list_machine` | Catalogue côté client |
| `GET /admin/dashboardL` | Dashboard livreur |
| `GET /admin/list_commandeM/{id}/mark-as-delivered` | Marquage livré (livreur) |
| `GET /clear-cache` | Vidage du cache (admin + livreur) |
| `GET /logoutSession` | Déconnexion |

---

## Sécurité

Le projet intègre un ensemble de mesures de durcissement documentées dans **[SECURITE.md](SECURITE.md)** :

- **CSRF** : token + middleware `VerifyCsrfToken` (aucune exception)
- **Anti-brute-force** : rate limiter `login` (5 tentatives/minute par couple login + IP)
- **Mots de passe** : hachage bcrypt, politique de mot de passe forte, messages d'erreur génériques (anti-énumération)
- **Comptes** : désactivation possible (`status`), session régénérée à la connexion
- **Session** : driver `database`, contenu **chiffré** (`SESSION_ENCRYPT`), cookie `http_only` + `same_site=lax` + `secure` en HTTPS, durée de vie configurable
- **Middleware `SecurityHeaders`** : en-têtes de sécurité HTTP
- **Middleware `RevalidateBackHistory`** : anti-retour-arrière après déconnexion (anti-cache)
- **Accès par rôle** : middlewares `admin` et `role` sur l'ensemble des routes protégées
- **Mot de passe masqué** dans les sorties (`hidden` sur le modèle `Admin`)

---

## Commandes utiles

```bash
# Serveur de développement
php artisan serve

# Compilation des assets (dev / prod)
npm run dev
npm run build

# Migrations et seeders
php artisan migrate
php artisan migrate --seed
php artisan migrate:fresh --seed          # Réinitialise la base + seed
php artisan db:seed --class=adminSeeder   # (Re)créer les comptes de démo

# Seeder de données fictives
php artisan db:seed --class=ProduitFakeSeeder
php artisan db:seed --class=CommandeFakeSeeder
php artisan db:seed --class=ClientCompteFakeSeeder
php artisan db:seed --class=ContactMessageFakeSeeder
php artisan db:seed --class=SavFakeSeeder

# Tests et qualité
php artisan test
./vendor/bin/pint

# Cache
php artisan optimize:clear
php artisan config:cache && php artisan route:cache   # production
```

---

## Environnement (.env) — variables spécifiques

| Variable | Description |
|----------|-------------|
| `DB_*` | Connexion MySQL (base `selectcars` par défaut) |
| `SESSION_DRIVER=database` | Sessions stockées en table `sessions` |
| `SESSION_ENCRYPT=true` | Chiffrement du contenu de session |
| `SESSION_SECURE_COOKIE=true` | Cookie `Secure` (nécessite HTTPS) |
| `SEED_ADMIN_PASSWORD` / `SEED_CLIENT_PASSWORD` / `SEED_LIVREUR_PASSWORD` | Mots de passe des comptes seedés (sinon aléatoire) |
| `MAIL_*` | SMTP configuré sur Mailpit en dev |

---

## Licence

Projet de Fin d'Études (PFE) — usage académique.
