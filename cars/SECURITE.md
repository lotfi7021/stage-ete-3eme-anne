# Plan de sécurisation — Projet Cars

> Document de suivi. Chaque phase est indépendante et livrable séparément.
> Méthode cible : **authentification par session** → **autorisation centralisée (Gates/Policies)** → **middleware (rôle + throttle)** → **vérification de propriété dans les contrôleurs**.

---

## 1. Contexte

| Élément | Valeur |
|---|---|
| Framework | Laravel 10.43 (`php ^8.1`) |
| Auth | Session (guard `admin` → provider `admins`) |
| JWT / Token | ❌ non utilisé (Sanctum installé mais inutilisé) |
| Rôles | `admin`, `client`, `livreur` |
| Autorisation | Tests `role == '...'` dispersés (contrôleurs + vues Blade) |
| Base | MySQL `127.0.0.1:3307`, base `cars` |
| Session | driver `file`, lifetime 120 min, `expire_on_close=false` |

**Méthode actuelle** : session + contrôle d'accès par rôle « fait main », protégé par le middleware `admin`.

---

## 2. État des lieux (audit)

### 2.1 Déjà en place ✅

| Mesure | Emplacement |
|---|---|
| CSRF (token + middleware, aucune exception) | `resources/views/back/admin_login.blade.php:26`, `app/Http/Middleware/VerifyCsrfToken.php` |
| Hachage bcrypt des mots de passe | `database/seeders/adminSeeder.php`, `AdminController.php:173,231,320` |
| Politique de mot de passe forte | `AdminController.php:157,215,303` |
| Message d'erreur générique (anti-énumération) | `AdminController.php:57` |
| Comptes désactivés bloqués (`status => 1`) | `AdminController.php:42` |
| Routes admin protégées par middleware | `routes/web.php:39`, `app/Http/Middleware/Admin.php:19` |
| Anti-cache retour arrière | `app/Http/Middleware/RevalidateBackHistory.php` |
| Cookie session `http_only=true`, `same_site=lax` | `config/session.php:184,199` |
| Mot de passe masqué | `app/Models/Admin.php:30-32` |
| Régénération de l'ID de session au login | Natif Laravel (`SessionGuard`) |

### 2.2 Faiblesses identifiées ❌⚠️

| # | Sévérité | Faiblesse | Emplacement |
|---|---|---|---|
| 1 | 🔴 | Pas de protection anti-brute-force sur le login | `routes/web.php:36` |
| 2 | 🔴 | Autorisation dispersée (aucun Gate/Policy) | `app/` (pas de `app/Policies`) |
| 3 | 🔴 | Absence de contrôle de propriété (IDOR) | `GestionMachineController.php:282-291` |
| 4 | 🔴 | `APP_DEBUG=true` / `APP_ENV=local` | `.env` |
| 5 | 🟠 | Cookie session non `Secure` | `SESSION_SECURE_COOKIE` non défini |
| 6 | 🟠 | Identifiants par défaut faibles | `database/seeders/adminSeeder.php` |
| 7 | 🟠 | Sessions longues, driver `file` | `.env`, `config/session.php` |
| 8 | 🟡 | Code mort (constructeur) | `AdminController.php:17-22` |
| 9 | 🟡 | Pas de journalisation des échecs de connexion | `AdminController.php:56-59` |
| 10 | 🟡 | Validation `login` sans longueur max | `AdminController.php:37-40` |

---

## 3. Phases

### Phase 0 — Audit & cadrage ✅ TERMINÉ

- [x] Recenser l'architecture d'auth (session, guards, providers)
- [x] Cartographier les routes protégées / publiques
- [x] Repérer les points de contrôle de rôle (contrôleurs + vues)
- [x] Identifier les faiblesses et les prioriser (voir §2.2)

**Livrable** : ce document.

---

### Phase 1 (P0) — Autorisation centralisée & anti-IDOR

**Objectif** : remplacer les tests de rôle dispersés par des **Policies** et vérifier la **propriété** des ressources côté serveur.

**Tâches**
- [ ] Créer `app/Policies/AdminPolicy.php` (`viewAny`, `view`, `create`, `update`, `delete`, `isAdmin`)
- [ ] Créer `GestionMachinePolicy`, `CommandePolicy`, `SupportPolicy` selon les besoins
- [ ] Enregistrer les Policies (auto-discovery Laravel 10 ou `AuthServiceProvider`)
- [ ] Ajouter `$this->authorize('...', $model)` en tête de chaque action sensible
- [ ] Remplacer les `if ($admin->role == '...')` dans les contrôleurs par les Policies
- [ ] Ne plus se fier aux `@if($admin->role == ...)` des vues pour la sécurité (uniquement pour l'affichage)
- [ ] Ajouter des middlewares de rôle route-level : `can:admin`, ou `role:admin` custom
- [ ] Vérifier la **propriété** dans `clientshow_machine`, `clientlist_compte`, commandes, supports (un `client` ne voit que ses données)

**Fichiers concernés**
- `app/Policies/*` (nouveau), `app/Providers/AuthServiceProvider.php`
- `app/Http/Controllers/GestionMachineController.php`, `CommandeMachineController.php`, `Admin/AdminController.php`, `SupportController.php`
- `resources/views/layouts/back/header.blade.php` (affichage uniquement)

**Validation**
- [ ] Un `client` ne peut plus accéder à `/admin/...` ni aux données d'un autre client
- [ ] Toute action non autorisée renvoie 403
- [ ] Plus aucun `role ==` utilisé comme contrôle de sécurité

**Effort estimé** : 1–2 jours

---

### Phase 2 (P0) — Anti-brute-force & durcissement configuration ✅ TERMINÉ

**Objectif** : bloquer les attaques par force brute et sécuriser la config.

**Tâches**
- [x] `throttle` sur la route de login
- [x] Verrouillage par couple `login` + IP via `RateLimiter` nommé `login` (`RouteServiceProvider`)
- [x] Message d'erreur dédié « Trop de tentatives de connexion. Veuillez réessayer dans une minute. »
- [x] `APP_DEBUG=false`, `APP_ENV=production` dans `.env.example` (modèle de déploiement)
- [x] `SESSION_SECURE_COOKIE=true` documenté (`.env.example`) — `false` en local (HTTP)
- [x] Identifiants par défaut remplacés par des mots de passe forts (seeder + comptes en base)
- [ ] `.env` de production distinct + `APP_KEY` régénéré → **à faire au déploiement** (régénérer `APP_KEY` invalide les sessions et données chiffrées)

**Fichiers concernés**
- `routes/web.php`, `app/Providers/RouteServiceProvider.php`, `.env`, `.env.example`, `database/seeders/adminSeeder.php`

**Validation**
- [x] Au-delà de 5 tentatives/min (même `login` + IP) → accès bloqué + message dédié (redirection avec erreur, plutôt que 429 brut)
- [ ] En prod, aucune stack trace exposée → **dépend du `.env` de déploiement**
- [x] Identifiants par défaut changés (`Admin#Cars2026`, `Client#Cars2026`, `Livreur#Cars2026` — à changer en production)

**Effort estimé** : 0,5–1 jour

---

### Phase 3 (P1) — Sessions, validation, nettoyage ✅ TERMINÉ

**Objectif** : fiabiliser la gestion de session et nettoyer le code.

**Tâches**
- [x] Passer `SESSION_DRIVER=database` + migration `sessions` (`php artisan session:table` puis `migrate`)
- [x] Purge : assurée par la **loterie** de session Laravel (`startSession` → `gc`), plus fiable qu'une commande `session:prune` qui n'existe pas dans Laravel 10
- [x] `SESSION_LIFETIME` réduit de 120 → **60 min**
- [x] Validation : `max:255` sur `login` (auth + créations compte client/admin/livreur)
- [x] Suppression du code mort `AdminController::__construct()`
- [x] Forcer HTTPS en production (`AppServiceProvider` : `URL::forceScheme('https')` si `environment('production')`)
- [x] Journaliser les échecs de connexion : `Log::warning('Échec de connexion', [login, ip, user_agent])` (horodatage natif — **mot de passe jamais journalisé**)

**Fichiers concernés**
- `.env`, `.env.example`, `database/migrations/*_create_sessions_table.php`, `app/Http/Controllers/Admin/AdminController.php`, `app/Providers/AppServiceProvider.php`

**Validation**
- [x] Sessions persistées en base (table `sessions` alimentée)
- [x] `login` > 255 caractères rejeté (plus de 500)
- [x] Échecs de connexion tracés : `local.WARNING: Échec de connexion {"login":...,"ip":...,"user_agent":...}`

**Effort estimé** : 0,5 jour

---

### Phase 4 (P2) — Durcissement avancé & suivi 🔶 EN COURS

**Objectif** : aller plus loin sur la défense en profondeur.

**Tâches**
- [x] `SESSION_ENCRYPT=true` (correction : `config/session.php` codait `'encrypt' => false` en dur → passé à `env('SESSION_ENCRYPT', false)`)
- [x] En-têtes de sécurité HTTP : `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`, CSP, et **HSTS** (HTTPS uniquement) — middleware `App\Http\Middleware\SecurityHeaders` ajouté au groupe `web`
- [x] `laravel/sanctum` retiré (inutilisé) : `composer remove laravel/sanctum`, suppression de `config/sanctum.php`, nettoyage de `App\Models\User` (`HasApiTokens`), `routes/api.php` et ligne commentée du Kernel. Reste (non bloquant) : la migration/table `personal_access_tokens`, héritée de Sanctum
- [ ] Double authentification (2FA) pour les comptes `admin` → **nécessite un choix d'approche** (TOTP via application type Google Authenticator, ou OTP par e-mail) et l'ajout d'une dépendance + colonnes dédiées
- [ ] Révision périodique des droits (rôles, comptes actifs) → **procédure opérationnelle**
- [ ] Sauvegardes chiffrées + procédure de restauration testée → **infrastructure / exploitation** (hors périmètre code applicatif)

**Fichiers concernés**
- `config/session.php`, `.env`, `.env.example`, `app/Http/Middleware/SecurityHeaders.php`, `app/Http/Kernel.php`

**Validation**
- [x] En-têtes de sécurité présents sur les réponses (`X-Frame-Options`, CSP, etc.)
- [x] Contenu de session chiffré en base (payload opaque, plus de `_token` en clair)
- [ ] TLS / HSTS vérifiés en environnement HTTPS → **dépend du déploiement**
- [ ] Procédure de reprise documentée et testée

**Effort estimé** : variable

---

## 4. Check-list globale

- [x] Phase 0 — Audit & cadrage
- [x] Phase 1 — Autorisation centralisée (Gates/Policies) + anti-IDOR
- [x] Phase 2 — Anti-brute-force + config production
- [x] Phase 3 — Sessions, validation, nettoyage
- [ ] Phase 4 — Durcissement avancé & suivi

---

## Annexe A — Exemples d'implémentation

### A.1 Policy (Phase 1)

```php
// app/Policies/GestionMachinePolicy.php
namespace App\Policies;

use App\Models\Admin;
use App\Models\Gestion_machine;

class GestionMachinePolicy
{
    public function viewAny(Admin $admin): bool
    {
        return in_array($admin->role, ['admin', 'client', 'livreur'], true);
    }

    public function update(Admin $admin, Gestion_machine $machine): bool
    {
        return $admin->role === 'admin';
    }

    public function view(Admin $admin, Gestion_machine $machine): bool
    {
        return $admin->role === 'admin'
            || ($admin->role === 'client' && $machine->id_client === $admin->id);
    }
}
```

```php
// Dans le contrôleur
public function update(Request $request, $id)
{
    $machine = Gestion_machine::findOrFail($id);
    $this->authorize('update', $machine); // 403 automatique
    // ...
}
```

### A.2 Middleware de rôle (Phase 1)

```php
// Route::middleware(['admin', 'role:admin'])->group(...)
public function handle(Request $request, Closure $next, string $role): Response
{
    $admin = Auth::guard('admin')->user();
    if (! $admin || $admin->role !== $role) {
        abort(403);
    }
    return $next($request);
}
```

### A.3 Throttle sur le login (Phase 2)

```php
// routes/web.php
Route::post('/admin/login-functionality', [AdminController::class, 'login_functionality'])
    ->middleware('throttle:5,1')
    ->name('login.functionality');
```

### A.4 Verrouillage par login + IP (Phase 2, option)

```php
use Illuminate\Support\Facades\RateLimiter;

$key = Str::lower($request->login).'|'.$request->ip();
if (RateLimiter::tooManyAttempts($key, 5)) {
    $seconds = RateLimiter::availableIn($key);
    return back()->withErrors(['login' => "Trop de tentatives. Réessayez dans {$seconds}s."]);
}
RateLimiter::hit($key, 60);
```

---

## Annexe B — Références fichiers

| Fichier | Rôle |
|---|---|
| `config/auth.php:43-46,71-74` | Guards & providers (`admin`, `admins`) |
| `app/Http/Controllers/Admin/AdminController.php:42` | `attempt()` login |
| `app/Http/Controllers/Admin/AdminController.php:28-32` | Redirection si déjà connecté |
| `app/Http/Controllers/Admin/AdminController.php:17-22` | Code mort (constructeur) |
| `app/Http/Middleware/Admin.php:19` | Contrôle d'accès guard admin |
| `app/Http/Middleware/RevalidateBackHistory.php` | Anti-cache retour arrière |
| `routes/web.php:35-41` | Routes login + groupe protégé |
| `app/Http/Controllers/CommandeMachineController.php:22-31` | Tests de rôle dispersés |
| `resources/views/layouts/back/header.blade.php:25,75,96` | Tests de rôle en vue |
| `app/Http/Controllers/GestionMachineController.php:282-291` | IDOR potentiel |
| `config/session.php` | Cookie & session |
| `database/seeders/adminSeeder.php` | Identifiants par défaut |
