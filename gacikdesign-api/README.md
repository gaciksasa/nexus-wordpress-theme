# GacikDesign License API

Multi-theme licensing platform for GacikDesign premium WordPress themes sold on ThemeForest.

**Domain:** `api.gacikdesign.com`

## Overview

A centralized license server that handles purchase code verification, domain-based activation, demo content delivery, bundled plugin distribution, and theme auto-updates for all GacikDesign themes.

Adding a new theme requires only:
1. One row in the `products` database table
2. One folder in `storage/`

No code changes needed.

## Tech Stack

- **PHP 8.1+** with [Slim Framework 4](https://www.slimframework.com/)
- **MySQL 8** (8 tables)
- **Composer** for dependency management
- **nginx + php-fpm + Let's Encrypt SSL** (recommended production stack)
- **Envato API** integration for purchase code verification

## Requirements

- PHP >= 8.1
- MySQL >= 8.0
- Composer
- cURL extension enabled
- An [Envato Personal Token](https://build.envato.com/create-token/) with "View sales" permission

## Installation

### 1. Clone and install dependencies

```bash
cd /var/www/gacikdesign-api
composer install
```

### 2. Configure environment

```bash
cp .env.example .env
```

Edit `.env` with your values:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=gacikdesign_api
DB_USER=your_db_user
DB_PASS=your_db_password

ENVATO_PERSONAL_TOKEN=your_envato_personal_token
APP_SECRET=your_64_char_random_hex_string

APP_ENV=production
APP_DEBUG=false
```

Generate `APP_SECRET`:
```bash
php -r "echo bin2hex(random_bytes(32));"
```

### 3. Create the database

```sql
CREATE DATABASE gacikdesign_api CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Run migrations

```bash
php database/migrate.php
```

This creates 8 tables: `products`, `licenses`, `activations`, `demos`, `bundled_plugins`, `download_logs`, `api_keys`, `rate_limits`, plus a `migrations` tracking table.

### 5. Seed initial data

```bash
php database/seeds/seed_initial.php
```

This creates:
- An admin API key (printed to stdout -- **save it immediately**, it cannot be recovered)
- A "Nexus" product entry (update `envato_item_id` after ThemeForest submission)

### 6. Configure web server

#### nginx (recommended)

```nginx
server {
    listen 443 ssl http2;
    server_name api.gacikdesign.com;

    root /var/www/gacikdesign-api/public;
    index index.php;

    ssl_certificate     /etc/letsencrypt/live/api.gacikdesign.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/api.gacikdesign.com/privkey.pem;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Block direct access to storage
    location /storage/ {
        deny all;
    }
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name api.gacikdesign.com;
    return 301 https://$host$request_uri;
}
```

#### Apache

The `public/.htaccess` file handles URL rewriting. Ensure `mod_rewrite` is enabled.

### 7. Local development

```bash
composer start
# Starts PHP built-in server at http://localhost:8080
```

## Project Structure

```
gacikdesign-api/
├── composer.json
├── .env / .env.example
├── public/
│   ├── index.php                   # Slim application entry point
│   └── .htaccess                   # Apache rewrite rules
├── config/
│   ├── container.php               # DI container definitions
│   ├── database.php                # PDO connection factory
│   └── routes.php                  # All API route definitions
├── src/
│   ├── Controllers/
│   │   ├── LicenseController.php   # activate, deactivate, verify
│   │   ├── UpdateController.php    # check-update, download-update
│   │   ├── DemoController.php      # list demos, download demo
│   │   ├── PluginController.php    # list plugins, download plugin
│   │   └── AdminController.php     # product/license management, stats
│   ├── Middleware/
│   │   ├── RateLimitMiddleware.php  # Per-IP request throttling
│   │   ├── SignatureMiddleware.php  # HMAC-SHA256 verification
│   │   └── AdminAuthMiddleware.php # API key bearer auth
│   ├── Services/
│   │   ├── EnvatoApiService.php    # Envato purchase code verification
│   │   ├── LicenseService.php      # Core business logic
│   │   ├── DomainNormalizer.php    # Domain normalization & local detection
│   │   └── SignatureService.php    # HMAC generation & verification
│   └── Exceptions/
│       ├── LicenseException.php    # License errors with HTTP status codes
│       └── RateLimitException.php  # Rate limit errors
├── database/
│   ├── migrate.php                 # Migration runner
│   ├── migrations/                 # Sequential SQL migration files
│   └── seeds/
│       └── seed_initial.php        # Create admin key + first product
└── storage/
    ├── nexus/                      # Per-product storage
    │   ├── demos/                  # Demo content ZIP files
    │   ├── plugins/                # Bundled plugin ZIPs
    │   └── updates/                # Theme update ZIPs
    └── logs/
        └── app.log                 # Application log (Monolog)
```

## API Endpoints

All theme-facing endpoints are product-scoped: `/api/v1/{product}/...`

### License Management

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| `POST` | `/api/v1/{product}/activate` | Register purchase code + domain | HMAC (purchase code) |
| `POST` | `/api/v1/{product}/deactivate` | Remove domain activation | HMAC (site token) |
| `POST` | `/api/v1/{product}/verify` | Check if activation is still valid | HMAC (site token) |

#### Activate Request

```json
POST /api/v1/nexus/activate
Headers:
  X-Gacik-Signature: <hmac_sha256>
  X-Gacik-Timestamp: <unix_timestamp>

Body:
{
  "purchase_code": "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx",
  "domain": "https://example.com",
  "wp_version": "6.7",
  "theme_version": "1.0.0",
  "php_version": "8.3.14"
}
```

#### Activate Response (Success)

```json
{
  "status": "activated",
  "site_token": "a1b2c3d4...64_char_hex_string",
  "license_type": "regular",
  "supported_until": "2027-03-14T00:00:00Z",
  "is_reactivation": false
}
```

#### Activate Response (Limit Reached)

```json
HTTP 403
{
  "error": "license_error",
  "message": "Activation limit reached. Maximum 1 production domain(s) allowed.",
  "active_domains": ["existingsite.com"],
  "max_domains": 1
}
```

### Theme Updates

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| `GET` | `/api/v1/{product}/check-update?current_version=X.Y.Z` | Check for new version | HMAC (site token) |
| `GET` | `/api/v1/{product}/download-update` | Download theme ZIP | HMAC (site token) |

#### Check Update Response

```json
{
  "latest_version": "1.2.0",
  "has_update": true,
  "download_url": "/api/v1/nexus/download-update"
}
```

### Demo Content

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| `GET` | `/api/v1/{product}/demos` | List available demos | HMAC (site token) |
| `GET` | `/api/v1/{product}/download-demo/{slug}` | Download demo ZIP | HMAC (site token) |

#### Demo List Response

```json
{
  "demos": [
    {
      "slug": "01-business",
      "name": "Business",
      "screenshot_url": "https://api.gacikdesign.com/screenshots/nexus/01-business.jpg",
      "preview_url": "https://demos.gacikdesign.com/nexus/business/",
      "sort_order": 1
    }
  ]
}
```

### Bundled Plugins

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| `GET` | `/api/v1/{product}/plugins` | List bundled plugins | HMAC (site token) |
| `GET` | `/api/v1/{product}/download-plugin/{slug}` | Download plugin ZIP | HMAC (site token) |

### Admin Endpoints

All admin endpoints require a bearer API key.

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/v1/admin/products` | List all products |
| `POST` | `/api/v1/admin/products` | Create/update a product |
| `GET` | `/api/v1/admin/licenses?product=nexus&page=1` | List licenses (paginated, filterable) |
| `POST` | `/api/v1/admin/licenses/{code}/block` | Block a purchase code |
| `POST` | `/api/v1/admin/licenses/{code}/unblock` | Unblock a purchase code |
| `GET` | `/api/v1/admin/stats` | Dashboard statistics |

#### Admin Auth Header

```
Authorization: Bearer <your_api_key>
```

#### Stats Response

```json
{
  "total_licenses": 142,
  "active_activations": 98,
  "blocked_licenses": 3,
  "downloads_30d": 267,
  "products": [
    {
      "slug": "nexus",
      "name": "Nexus - Multipurpose WordPress Theme",
      "licenses": 142,
      "active_domains": 98
    }
  ]
}
```

## Database Schema

### `products`
Registry of all themes/plugins sold. Each product has its own `envato_item_id` and configurable activation limits.

### `licenses`
One row per Envato purchase code. Stores buyer info, license type, support expiry, and the raw Envato API response. Can be blocked by admin.

### `activations`
Maps domains to licenses. Each activation gets a unique `site_token` for HMAC signing. Tracks whether the domain is local/staging (doesn't count against limits).

### `demos`
Per-product demo content registry with slug, name, screenshot URL, and file path in storage.

### `bundled_plugins`
Per-product bundled plugin registry with slug, version, and file path.

### `download_logs`
Audit trail of all demo, plugin, and update downloads with timestamps and file sizes.

### `api_keys`
Admin API keys stored as bcrypt hashes with JSON permissions.

### `rate_limits`
Per-IP request throttling with configurable limits per endpoint.

## Security

### HMAC-SHA256 Signatures

All theme-to-server requests are signed:

1. **Activate endpoint**: signed with the purchase code as key (no site token exists yet)
2. **All other endpoints**: signed with `site_token` (returned on activation)

Signature format:
```
HMAC-SHA256(timestamp + "|" + request_body, signing_key)
```

Headers sent by theme:
- `X-Gacik-Signature`: the HMAC hex digest
- `X-Gacik-Timestamp`: Unix timestamp (rejected if > 5 minutes old)
- `X-Gacik-Token`: the site token (not sent for /activate)

### Rate Limiting

Per-IP limits (configurable via `.env`):

| Endpoint | Default Limit |
|----------|---------------|
| activate | 10/hour |
| deactivate | 10/hour |
| verify | 60/hour |
| download | 20/hour |
| default | 30/hour |

### Envato API Re-verification

- Purchase codes are verified against the Envato API on first activation
- Re-verified every 7 days during routine verify calls
- If Envato returns 404 (refunded/chargedback), the license is auto-blocked

### Domain Normalization

Domains are normalized before storage:
- Lowercased, protocol stripped, `www.` stripped, port stripped, path stripped

Local/staging domains (unlimited activations, don't count against limits):
- `localhost`, `127.0.0.1`, `10.x.x.x`, `192.168.x.x`
- `*.local`, `*.test`, `*.dev`, `*.localhost`
- `*.staging.*`, `staging.*`

### Additional Measures

- PDO prepared statements for all SQL queries
- UUID format validation before any database lookup
- Storage files served through PHP (not directly via nginx) to enforce auth
- HTTPS enforced at the web server level
- Purchase codes censored in admin API responses and logs

## Adding a New Theme

1. **Via admin API:**

```bash
curl -X POST https://api.gacikdesign.com/api/v1/admin/products \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "slug": "flavor",
    "name": "Flavor - Restaurant WordPress Theme",
    "envato_item_id": 12345678,
    "latest_version": "1.0.0",
    "max_domains_regular": 1,
    "max_domains_extended": 5
  }'
```

2. **Create storage folder:**

```bash
mkdir -p storage/flavor/{demos,plugins,updates}
```

3. **In the new theme**, duplicate the 5 licensing classes from Nexus, change the `PRODUCT_SLUG` constant from `'nexus'` to `'flavor'`.

## Logs

Application logs are written to `storage/logs/app.log` via Monolog. Key events logged:

- New license created (censored purchase code, product, license type)
- Activation/deactivation events (domain, license ID)
- Re-activation events
- Auto-block after failed Envato re-verification

## License

Proprietary. All rights reserved by GacikDesign.
