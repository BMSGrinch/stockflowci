# StockFlow CI

> Prototype de gestionnaire de stock pour PME ivoiriennes

StockFlow CI est une application web de gestion de stock permettant aux entreprises de piloter leurs flux commerciaux — ventes, stock, fournisseurs — visualiser en temps réel les indicateurs clés de son activité à travers un tableau de bord interactif.

---

## Fonctionnalités

- **Gestion des produits** — catalogue complet avec référence, catégorie, prix d'achat/vente, seuil d'alerte de stock et statut actif/inactif
- **Interface de caisse** — création de ventes avec sélection dynamique des produits, calcul automatique du total et choix du moyen de paiement (espèces, mobile money, carte)
- **Journal des ventes** — historique complet avec filtre par moyen de paiement
- **Mouvements de stock** — log immuable de toutes les opérations (entrée, vente, ajustement, perte)
- **Gestion des fournisseurs** — annuaire avec liste des produits associés
- **Tableau de bord** — stats en temps réel (produits actifs, alertes stock, ventes du jour, CA du mois) + graphiques Chart.js (ventes des 7 derniers jours, répartition par moyen de paiement)
- **Authentification** — système sécurisé via Laravel Breeze avec gestion des sessions

---

## Stack technique

| Couche | Technologie |
|--------|-------------|
| Backend | Laravel 12 |
| Frontend | Blade + Tailwind CSS |
| Graphiques | Chart.js |
| Base de données | MySQL |
| Auth | Laravel Breeze |

---

## Choix techniques

**Eager Loading** — Toutes les relations sont chargées en amont avec `with()` et `load()` pour éviter les requêtes SQL en cascade sur les listes paginées.

**Transactions DB** — La création d'une vente est encapsulée dans une transaction `DB::transaction()` : si une étape échoue (stock insuffisant, montant incohérent), toutes les opérations sont annulées pour garantir la cohérence des données.

**Mouvements de stock immuables** — Les mouvements de stock ne peuvent pas être modifiés ou supprimés. Toute correction passe par un nouveau mouvement de type `adjustment`, comme dans un vrai journal comptable.

**Seeders** — La base de données peut être entièrement reconstruite avec des données réalistes en une seule commande `php artisan migrate:fresh --seed`.(J'avais la flemme d'écrire des données réelles 🤣)

---

## Installation locale

```bash
# 1. Cloner le projet
git clone https://github.com/ton-username/stockflow-ci.git
cd stockflow-ci

# 2. Installer les dépendances
composer install
npm install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
DB_DATABASE=stackflowci
DB_USERNAME=root
DB_PASSWORD=

# 5. Créer la base de données et la remplir
php artisan migrate:fresh --seed

# 6. Lancer le serveur
php artisan serve
npm run dev
```

Accéder à l'app sur `http://localhost:8000`

**Comptes de test :**

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@stockflow.ci | password123 |
| Manager | manager@stockflow.ci | password123 |
| Seller | seller@stockflow.ci | password123 |

---

## Fonctionnalités prévues en V2

- Export PDF des bons de vente
- Gestion des rôles avec middleware custom (admin / manager / seller)
- Graphiques avancés (tendances, panier moyen)
- Mode sombre complet

---

## Auteur

Développé par **Kash** — [GitHub](https://github.com/BMSGrinch)

> *Construit avec Laravel & Tailwind CSS*

## Retour et avis 

N'hésitez pas à me faire un retour en me contactant par mail julienouattara225@gmail.com pour avoir plus d'informations sur mon travail.
BMSVIE




<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
