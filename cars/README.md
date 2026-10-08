<p align="center"><h1 align="center">🚗 SelectCars - Vehicle Parts & Equipment Management Platform</h1></p>

<p align="center">
  <strong>A full-stack web application for managing automotive parts, machines, and orders</strong>
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#technologies">Technologies</a> •
  <a href="#installation">Installation</a> •
  <a href="#usage">Usage</a> •
  <a href="#database">Database</a>
</p>

---

## About SelectCars

**SelectCars** is a B2B/B2C e-commerce platform designed for an automotive parts and machinery company. Built as a **PFE (Projet de Fin d'Etudes)** project, it provides a complete solution for managing:

- **Automotive parts** (pièces) organized by brand, model, and category
- **Industrial machines and equipment**
- **Order management** with delivery tracking
- **Client management** with company details
- **After-sales support** (SAV - Service Après-Vente)

## Features

### Public-Facing (Front Office)
- Homepage with animated banner slider and search form
- Search by brand, model, and price range (with AJAX dynamic model loading)
- Product/parts browsing and detail pages
- Brand listing pages
- Contact form with email notifications
- FAQ page

### Admin Back Office
- Dashboard with statistics
- Full CRUD for products/pieces with image uploads
- Brand (marque) and model management
- Stock tracking with movement calculations
- Order management with delivery assignment
- Invoice/Invoice preview generation
- Client management with company details
- User account management (admin, client, livreur)
- SAV (support) ticket system
- Banner and FAQ content management
- Calendar view for order scheduling

### User Roles & Access Control

| Role | Access Level |
|------|--------------|
| **Admin** | Full access to everything |
| **Client** | View catalog, own orders, create support tickets |
| **Livreur** | View assigned orders, mark as delivered |

## Technologies

**Backend:**
- PHP 8.1+
- Laravel 10.x
- MySQL database
- Laravel Sanctum (API token authentication)
- Yajra Laravel Datatables

**Frontend:**
- Blade templating engine
- Bootstrap 5 (AdminLTE theme)
- Swiper Slider, AOS (Animate on Scroll)
- NoUiSlider, Nice Select
- Vite + Laravel Mix
- SCSS/SASS
- jQuery

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & npm
- MySQL

### Steps

1. Clone the repository
```bash
git clone <repository-url>
cd cars
```

2. Install PHP dependencies
```bash
composer install
```

3. Install JavaScript dependencies
```bash
npm install
```

4. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure database in `.env` file

6. Run migrations and seeders
```bash
php artisan migrate --seed
```

7. Build assets
```bash
npm run build
```

8. Start the development server
```bash
php artisan serve
```

## Usage

### Default Login Credentials

| Role | Email/Username | Password |
|------|----------------|----------|
| Admin | admin | password |
| Client | user | password |
| Livreur | livreur | password |

### Routes

- `/` - Homepage
- `/login` - Admin login
- `/admin/dashboard` - Admin dashboard
- `/produits` - Product listing
- `/contact` - Contact form
- `/faq` - FAQ page

## Database Structure

| Table | Purpose |
|-------|---------|
| `admins` | User accounts (admin, client, livreur roles) |
| `gestion_machines` | Product/parts catalog |
| `marque_machines` | Machine/parts brands |
| `model_machines` | Machine/parts models |
| `stock_machines` | Stock tracking |
| `commande__ms` | Orders |
| `detail_commande_ms` | Order line items |
| `clients` | Client companies |
| `supports` | Support tickets (SAV) |
| `contacts` | Contact form submissions |
| `banners` | Homepage banners |
| `faqs` | Frequently asked questions |
| `settings` | Application settings |

## License

This project is a PFE (Projet de Fin d'Etudes) project.
