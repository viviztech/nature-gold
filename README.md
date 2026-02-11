# Nature Gold - Premium Cold-Pressed Oils Ecommerce Platform

A full-featured ecommerce platform built for **Nature Gold**, a Tamil Nadu-based brand selling premium cold-pressed oils, spices, and natural food products. Built with modern Laravel 12, featuring a bilingual storefront (English + Tamil), dealer portal, WhatsApp notifications, and comprehensive admin panel.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Architecture](#architecture)
- [Screenshots](#screenshots)
- [Requirements](#requirements)
- [Installation](#installation)
- [Environment Configuration](#environment-configuration)
- [Database Seeding](#database-seeding)
- [Running the Application](#running-the-application)
- [Admin Panel](#admin-panel)
- [Dealer Portal](#dealer-portal)
- [Payment Gateways](#payment-gateways)
- [Notifications](#notifications)
- [Localization](#localization)
- [SEO](#seo)
- [PWA Support](#pwa-support)
- [Project Structure](#project-structure)
- [Deployment](#deployment)
- [License](#license)

---

## Features

### Storefront
- **Product Catalog** with category filtering, search, price range, and sorting
- **Product Variants** (multiple sizes/weights: 200ml, 500ml, 1L, 5L)
- **Shopping Cart** with real-time updates (Livewire-powered)
- **Checkout Flow** with address management and multiple payment options
- **User Accounts** with order history, wishlist, saved addresses, and profile management
- **Coupon System** with percentage/fixed discounts and usage limits
- **Product Reviews** with admin moderation
- **Blog Section** for content marketing (recipes, health tips)
- **Contact Form** with inquiry management

### Dealer Portal
- **Dealer Registration** with business details and territory selection
- **Admin Approval Workflow** for new dealer applications
- **Bulk Ordering** with dealer-specific pricing
- **Dealer Dashboard** with order tracking and invoice downloads
- **Territory-Based Assignment** mapped to 38 Tamil Nadu districts

### Admin Panel (Filament v5)
- **13 CRUD Resources**: Products, Categories, Orders, Users, Dealers, Coupons, Banners, Pages, Reviews, Blog Posts, Shipping Zones, Contact Inquiries, Newsletters
- **Dashboard Widgets**: Revenue chart, orders by status, latest orders, stats overview
- **Settings Page**: Store info, payment config, shipping defaults
- **Bilingual Content Management**: English and Tamil fields for all content

### Payments
- **Razorpay** - UPI, cards, netbanking, wallets
- **PhonePe** - UPI-focused payment gateway
- **Cash on Delivery** - with optional COD charges
- **Webhook Verification** with signature validation
- **GST-Compliant Invoice** PDF generation (DomPDF)

### Notifications
- **WhatsApp Business Cloud API** - Order confirmations, shipping updates, dealer approvals
- **Email Notifications** - Order lifecycle emails via Laravel Mail
- **SMS OTP Verification** - Phone number verification (MSG91/Twilio)
- **Abandoned Cart Reminders** - Scheduled job for cart recovery

### Bilingual Support
- Full **English + Tamil** localization
- URL-based locale routing (`/ta/shop`, `/ta/product/...`)
- All product content, categories, and pages stored in both languages
- Tamil font optimization (Noto Sans Tamil)

### SEO & Performance
- Dynamic meta tags, Open Graph, and structured data (JSON-LD)
- XML Sitemap generation with products, blog, and local landing pages
- **38 Tamil Nadu district landing pages** for local SEO
- Product-type + district combination pages (e.g., `/groundnut-oil/chennai`)
- Homepage query caching (banners, categories, products)
- Lazy loading for images, DNS prefetching
- PWA with offline support

### Security
- CSRF protection on all forms (webhook endpoints excluded)
- Rate limiting on login, registration, contact, and OTP routes
- OWASP security headers (X-Frame-Options, X-Content-Type-Options, etc.)
- Input validation on all user-facing endpoints
- Mass assignment protection with explicit `$fillable` on all models
- Razorpay webhook signature verification with `hash_equals()`

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Framework** | Laravel 12 (PHP 8.2+) |
| **Admin Panel** | Filament PHP v5.2 (Livewire v4) |
| **Frontend** | Tailwind CSS 4 (CSS-first config) + Alpine.js |
| **Interactivity** | Livewire v4 (9 components) |
| **Database** | SQLite (dev) / MySQL 8 (production) |
| **Build Tool** | Vite 7 |
| **Payments** | Razorpay + PhonePe + COD |
| **PDF** | barryvdh/laravel-dompdf |
| **Sitemap** | spatie/laravel-sitemap |
| **Fonts** | Inter, Poppins, Noto Sans Tamil |

---

## Architecture

```
nature-gold/
├── app/
│   ├── Enums/              # 6 enums (OrderStatus, PaymentMethod, UserRole, etc.)
│   ├── Filament/
│   │   ├── Resources/      # 13 admin CRUD resources
│   │   ├── Widgets/        # 4 dashboard widgets
│   │   └── Pages/          # Settings page
│   ├── Http/
│   │   ├── Controllers/    # 11 controllers (Storefront, Shop, Auth, Dealer, etc.)
│   │   └── Middleware/     # 3 middleware (SetLocale, SecurityHeaders, EnsureDealer)
│   ├── Livewire/           # 9 components (Cart, Checkout, Search, etc.)
│   ├── Models/             # 24 Eloquent models
│   └── Services/
│       ├── Notification/   # WhatsApp, SMS, Notification services
│       └── Payment/        # Razorpay, PhonePe, COD gateways
├── database/
│   ├── migrations/         # 23 migration files
│   └── seeders/            # DatabaseSeeder + PageContentSeeder
├── resources/
│   ├── views/              # Blade templates (storefront + dealer)
│   ├── css/app.css         # Tailwind v4 with Nature Gold theme
│   ├── js/app.js           # Frontend JavaScript
│   └── lang/               # en/ and ta/ translation files
├── routes/
│   └── web.php             # All storefront, auth, dealer, payment, SEO routes
├── public/
│   ├── manifest.json       # PWA manifest
│   ├── sw.js               # Service worker
│   ├── offline.html        # Offline fallback page
│   └── icons/              # PWA app icons (72-512px)
└── config/
    └── services.php        # Payment, WhatsApp, SMS, Analytics config
```

---

## Requirements

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **npm** >= 9.x
- **SQLite** (development) or **MySQL 8** (production)

---

## Installation

### Quick Setup

```bash
# Clone the repository
git clone https://github.com/viviztech/nature-gold.git
cd nature-gold

# Run the automated setup
composer setup
```

The `composer setup` command will:
1. Install PHP dependencies
2. Copy `.env.example` to `.env`
3. Generate application key
4. Run database migrations
5. Install npm dependencies

### Manual Setup

```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed

# Seed comprehensive page content (Privacy Policy, Terms, etc.)
php artisan db:seed --class=PageContentSeeder

# Install frontend dependencies
npm install

# Create storage symlink
php artisan storage:link

# Build frontend assets
npm run build
```

---

## Environment Configuration

Copy `.env.example` to `.env` and configure the following:

### Required Settings

```env
APP_NAME="Nature Gold"
APP_URL=http://localhost:8000
```

### Payment Gateways

```env
# Razorpay (Primary)
RAZORPAY_KEY_ID=rzp_test_xxxxx
RAZORPAY_KEY_SECRET=your_secret
RAZORPAY_WEBHOOK_SECRET=your_webhook_secret

# PhonePe (Secondary)
PHONEPE_MERCHANT_ID=your_merchant_id
PHONEPE_SALT_KEY=your_salt_key
PHONEPE_SALT_INDEX=1
PHONEPE_ENV=sandbox   # Change to 'production' for live
```

### WhatsApp Business API

```env
WHATSAPP_ACCESS_TOKEN=your_access_token
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
WHATSAPP_BUSINESS_ACCOUNT_ID=your_business_account_id
WHATSAPP_VERIFY_TOKEN=your_verify_token
```

### SMS Provider

```env
SMS_PROVIDER=log   # Options: log, msg91, twilio
```

### Analytics

```env
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
FACEBOOK_PIXEL_ID=123456789
```

### Production Database (MySQL)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nature_gold
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

## Database Seeding

```bash
# Seed all data (admin user, categories, products, banners, settings)
php artisan db:seed

# Seed page content separately (Privacy Policy, Terms, Refund, Shipping)
php artisan db:seed --class=PageContentSeeder
```

### Default Admin Credentials

| Field | Value |
|-------|-------|
| Email | `admin@naturegold.in` |
| Password | `password` |

---

## Running the Application

### Development Mode

```bash
# Start all services concurrently (server, queue, logs, vite)
composer dev
```

Or start services individually:

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev

# Terminal 3: Queue worker (for notifications)
php artisan queue:work

# Terminal 4: Log viewer
php artisan pail
```

The application will be available at `http://localhost:8000`.

---

## Admin Panel

Access the admin panel at `/admin`.

### Resources (13)

| Resource | Description |
|----------|-------------|
| **Products** | Full product management with variants, images, bilingual content, SEO fields |
| **Categories** | Nested categories with images and bilingual names |
| **Orders** | Order management with status updates and payment tracking |
| **Users** | Customer list with role management |
| **Dealers** | Dealer applications, approval workflow, territory assignment |
| **Coupons** | Discount codes with usage tracking and date ranges |
| **Banners** | Homepage hero slider management |
| **Pages** | CMS pages (About, Privacy Policy, Terms, etc.) |
| **Blog Posts** | Blog content management with featured images |
| **Reviews** | Product review moderation |
| **Shipping Zones** | District-based shipping rates for Tamil Nadu |
| **Contact Inquiries** | View and manage customer inquiries |
| **Newsletters** | Email subscriber management |

### Dashboard Widgets (4)

- **Stats Overview** - Total revenue, orders, customers, products
- **Revenue Chart** - Monthly revenue visualization
- **Orders by Status** - Pie chart of order status distribution
- **Latest Orders** - Recent orders table with quick actions

---

## Dealer Portal

### Registration Flow

1. Dealer visits `/dealer/register` and submits business details
2. Admin reviews the application in the Filament panel
3. Upon approval, dealer receives WhatsApp/email notification
4. Dealer logs in and accesses their dashboard at `/dealer/dashboard`

### Dealer Features

| Page | Route | Description |
|------|-------|-------------|
| Dashboard | `/dealer/dashboard` | Overview with order stats |
| Catalog | `/dealer/catalog` | Browse products with dealer pricing |
| Place Order | `/dealer/place-order` | Bulk order form with special prices |
| Orders | `/dealer/orders` | Order history with status tracking |
| Invoice | `/dealer/orders/{id}/invoice` | Download GST-compliant PDF invoice |
| Profile | `/dealer/profile` | Update business information |

---

## Payment Gateways

### Razorpay (Primary)

- Supports UPI, credit/debit cards, netbanking, wallets
- Webhook endpoint: `POST /payment/razorpay/webhook`
- Callback endpoint: `POST /payment/razorpay/{order}/callback`
- Signature verification using `hash_equals()` to prevent timing attacks

### PhonePe (Secondary)

- UPI-focused payment gateway
- Webhook endpoint: `POST /payment/phonepe/webhook`
- Callback endpoint: `POST /payment/phonepe/{order}/callback`

### Cash on Delivery

- Available for all orders
- Optional COD charges configurable via admin settings

---

## Notifications

| Channel | Use Cases |
|---------|-----------|
| **WhatsApp** | Order confirmation, shipping updates, dealer approval, abandoned cart |
| **Email** | Order lifecycle, password reset, welcome email |
| **SMS** | OTP verification, order updates (fallback) |

### Scheduled Jobs

| Job | Schedule | Description |
|-----|----------|-------------|
| Abandoned Cart Reminder | Hourly | WhatsApp reminder for carts older than 24 hours |

---

## Localization

The application supports **English** and **Tamil** with full bilingual content.

### URL-Based Routing

| English | Tamil |
|---------|-------|
| `/` | `/ta` |
| `/shop` | `/ta/shop` |
| `/product/groundnut-oil` | `/ta/product/groundnut-oil` |
| `/blog` | `/ta/blog` |
| `/about` | `/ta/about` |
| `/contact` | `/ta/contact` |

### Translation Files

- `resources/lang/en/shop.php` - English translations
- `resources/lang/ta/shop.php` - Tamil translations

All database content (product names, descriptions, categories, pages) stores both `_en` and `_ta` fields with locale-aware accessors on models.

---

## SEO

### Structured Data (JSON-LD)

- **Organization** schema on homepage
- **Product** schema on product detail pages (price, availability, ratings)
- **LocalBusiness** schema on district landing pages
- **BreadcrumbList** for navigation

### Sitemap

Auto-generated XML sitemap at `/sitemap.xml` covering:
- All storefront pages (English + Tamil)
- Products and categories
- Blog posts
- 38 Tamil Nadu district landing pages
- Product-type + district combinations (e.g., `/cold-pressed-oil/chennai`)

### Local Landing Pages

SEO-optimized pages targeting all 38 Tamil Nadu districts:

| Route | Example |
|-------|---------|
| `/locations` | District grid page |
| `/locations/{district}` | `/locations/chennai` |
| `/{product-type}/{district}` | `/groundnut-oil/coimbatore` |

Supported product types: `cold-pressed-oil`, `groundnut-oil`, `sesame-oil`, `coconut-oil`

---

## PWA Support

The application is a Progressive Web App with:

- **Web App Manifest** (`/manifest.json`) with Nature Gold branding
- **Service Worker** (`/sw.js`) with network-first strategy and offline fallback
- **Offline Page** (`/offline.html`) shown when the user loses connectivity
- **App Icons** in 8 sizes (72px to 512px)
- **Apple Touch Icon** support for iOS devices
- **App Shortcuts** for quick access to Shop and Cart

### Caching Strategy

| Resource Type | Strategy |
|---------------|----------|
| Navigation (HTML) | Network first, cache fallback, offline page fallback |
| Static Assets (CSS, JS, fonts) | Cache first, network fallback |
| Images | Cache first, network fallback |
| Admin/Livewire/API | Bypass service worker |

---

## Project Structure

### Models (24)

| Model | Description |
|-------|-------------|
| User | Customers, dealers, and admins |
| Product | Products with bilingual fields, SEO meta |
| ProductVariant | Size/weight variants with individual pricing |
| ProductImage | Multiple images per product with sort order |
| Category | Nested categories with parent-child relationships |
| Order | Customer and dealer orders |
| OrderItem | Individual items within an order |
| Cart / CartItem | Session or user-based shopping cart |
| Address | Multiple saved addresses per user |
| Dealer / DealerPricing | Dealer profiles and special pricing |
| Coupon / CouponUsage | Discount codes with usage tracking |
| Banner | Homepage hero slider banners |
| Page | CMS pages (About, Privacy, Terms, etc.) |
| BlogPost | Blog articles with featured images |
| Review | Product reviews with moderation |
| Wishlist | User product wishlists |
| ShippingZone | District-based shipping rates |
| Transaction | Payment transaction records |
| ContactInquiry | Contact form submissions |
| Newsletter | Email subscribers |
| Setting | Key-value store for site configuration |

### Livewire Components (9)

| Component | Description |
|-----------|-------------|
| CartPage | Full cart page with quantity updates and coupon application |
| CheckoutPage | Multi-step checkout with address and payment selection |
| AddToCartButton | Product card add-to-cart with variant selection |
| CartIcon | Header cart count badge (reactive) |
| CartCountBadge | Mobile nav cart count |
| SearchBar | Predictive search with product suggestions |
| LanguageSwitcher | English/Tamil locale toggle |
| NewsletterForm | Email subscription form |
| DealerBulkOrder | Dealer bulk order placement form |

### Enums (6)

| Enum | Values |
|------|--------|
| UserRole | `admin`, `customer`, `dealer` |
| OrderStatus | `pending`, `confirmed`, `processing`, `shipped`, `delivered`, `cancelled` |
| PaymentStatus | `pending`, `paid`, `failed`, `refunded` |
| PaymentMethod | `razorpay`, `phonepe`, `cod` |
| DealerStatus | `pending`, `approved`, `rejected`, `suspended` |
| TamilNaduDistrict | All 38 districts with English/Tamil names |

---

## Deployment

### Production Checklist

```bash
# Set environment
APP_ENV=production
APP_DEBUG=false

# Optimize for production
php artisan optimize
php artisan view:cache
php artisan event:cache
npm run build

# Run migrations
php artisan migrate --force

# Configure queue worker (Supervisor)
php artisan queue:work --daemon

# Set up cron for scheduled tasks
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

### Server Requirements

- **Web Server**: Nginx or Apache with PHP-FPM
- **PHP**: 8.2+ with extensions: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML
- **Database**: MySQL 8.0+ (recommended for production)
- **SSL**: Required for payment gateways and PWA
- **Queue**: Supervisor for background job processing
- **Storage**: Writable `storage/` and `bootstrap/cache/` directories

### Recommended Hosting

- DigitalOcean Droplet / AWS EC2 / Hostinger VPS
- Laravel Forge or Ploi for server management
- Cloudflare for CDN and DDoS protection

---

## Brand Theme

| Element | Value |
|---------|-------|
| Primary Gold | `#D4A017` |
| Gold Light | `#FFF9E6` |
| Gold Dark | `#A67C00` |
| Nature Green | `#2D6A2E` |
| Nature Light | `#4CAF50` |
| Nature Dark | `#1B5E20` |
| Cream | `#FFF8E7` |
| Warm White | `#FFFDF7` |
| Heading Font | Poppins |
| Body Font | Inter |
| Tamil Font | Noto Sans Tamil |

---

## License

This project is proprietary software developed for Nature Gold. All rights reserved.
