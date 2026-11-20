# 🛒 UberBite(Coin) — Plateforme de Petites Annonces

Application web de petites annonces locales développée avec **Laravel 13**, **Tailwind CSS** et **Alpine.js**.  
Les utilisateurs peuvent parcourir les annonces par catégorie, rechercher et filtrer par prix, publier/modifier/supprimer leurs propres annonces et gérer leur espace personnel (« Mon compte », statistiques vendeur et messagerie).

---

## ✨ Fonctionnalités principales

- **Accueil & Catalogue :** Affichage des 8 dernières annonces mises en cache, liste paginée des annonces avec filtres (recherche par mot-clé, catégorie, prix maximum).
- **Gestion d'annonces (CRUD) :** Création, modification et suppression d'annonces réservées à leur auteur.
- **Authentification complète (Laravel Breeze) :** Inscription, connexion, vérification d'e-mail, réinitialisation et modification du mot de passe.
- **Espace « Mon compte » (Dashboard) :**
  - Statistiques d'activité vendeur.
  - Messagerie interactive vendeur ↔ acheteur (Alpine.js).
  - Gestion des informations personnelles, sécurité du mot de passe et suppression du compte.

---

## 🛠️ Prérequis

Vous pouvez installer le projet soit **avec Docker (Laravel Sail)**, soit **directement en local** :

### Option A — Avec Docker (recommandé)
- [Git](https://git-scm.com/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (lancé et actif)

### Option B — En local (sans Docker)
- [Git](https://git-scm.com/)
- **PHP >= 8.3** (avec les extensions `pdo_mysql` ou `pdo_sqlite`, `mbstring`, `xml`, `ctype`, `json`, `bcmath`)
- [Composer](https://getcomposer.org/) (v2+)
- [Node.js](https://nodejs.org/) (v18+ ou v20+) & **npm**
- **MySQL 8+** (ou **SQLite**)

---

## 🚀 Installation pas à pas depuis GitHub

### 1. Cloner le dépôt GitHub

```bash
git clone https://github.com/mathis-aly/ProjetGroupLaravel.git
cd ProjetGroupLaravel
```

### 2. Créer le fichier d'environnement `.env`

```bash
cp .env.example .env
```

---

## 🐳 Démarrage avec Docker (Laravel Sail) — Recommandé

Si vous utilisez Docker, `compose.yaml` configure automatiquement **PHP**, **MySQL 8.4** et **Mailpit**.

### 1. Installer les dépendances PHP via un conteneur temporaire
*(Si Composer est déjà installé sur votre machine, vous pouvez simplement faire `composer install`)*

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

### 2. Configurer `.env` pour Sail (MySQL)

Vérifiez que votre fichier `.env` contient bien la configuration MySQL de Sail :

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

### 3. Démarrer les conteneurs Docker

```bash
./vendor/bin/sail up -d
```

### 4. Générer la clé d'application et lancer les migrations + données de test

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

### 5. Installer et compiler les assets Front-End (Tailwind CSS & Alpine.js)

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```
*(Ou `./vendor/bin/sail npm run build` pour compiler les fichiers de production).*

### 6. Accéder à l'application
- **Application web :** [http://localhost](http://localhost)
- **Interface Mailpit (e-mails de test) :** [http://localhost:8025](http://localhost:8025)

---

## 💻 Démarrage en local (sans Docker)

### 1. Installer les dépendances PHP et JavaScript

```bash
composer install
npm install
```

### 2. Générer la clé de chiffrement Laravel

```bash
php artisan key:generate
```

### 3. Configurer la base de données dans `.env`

- **Avec SQLite (le plus simple en local, configuration par défaut de `.env.example`) :**
  ```bash
  touch database/database.sqlite
  ```
- **Ou avec MySQL local :** modifiez `.env` avec vos identifiants locaux (`DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`, `DB_DATABASE=...`, `DB_USERNAME=...`, `DB_PASSWORD=...`).

### 4. Exécuter les migrations et remplir la base avec les données de démonstration

```bash
php artisan migrate --seed
```

### 5. Lancer les serveurs de développement (Laravel + Vite)

Dans un premier terminal :
```bash
php artisan serve
```

Dans un second terminal :
```bash
npm run dev
```

*(Astuce : vous pouvez aussi lancer les deux en même temps avec `composer run dev`)*.

### 6. Accéder à l'application
- **Application web :** [http://localhost:8000](http://localhost:8000)

---

## 👤 Compte de test généré par le Seeder

Après avoir exécuté `php artisan migrate --seed` (ou `./vendor/bin/sail artisan migrate --seed`), la base de données contient **8 catégories**, **100 annonces** et un compte utilisateur prêt à l'emploi :

| Champ | Valeur |
| :--- | :--- |
| **Adresse e-mail** | `test@example.com` |
| **Mot de passe** | `password` |

---

## 🧰 Commandes utiles au quotidien

| Action | Avec Laravel Sail (Docker) | En local |
| :--- | :--- | :--- |
| Démarrer le projet | `./vendor/bin/sail up -d` | `php artisan serve` |
| Arrêter les conteneurs | `./vendor/bin/sail down` | `Ctrl + C` |
| Réinitialiser la BDD avec les seeds | `./vendor/bin/sail artisan migrate:fresh --seed` | `php artisan migrate:fresh --seed` |
| Vider le cache applicatif | `./vendor/bin/sail artisan cache:clear` | `php artisan cache:clear` |
| Lancer les tests automatisés | `./vendor/bin/sail artisan test` | `php artisan test` |
