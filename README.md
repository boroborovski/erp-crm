# ERP / CRM System

A modern, self-hosted CRM and ERP platform built for teams who need full control over their data. Manage contacts, companies, opportunities, quotes, invoices, projects, and inventory — all in one place.

Built on **Laravel 12 · Filament 5 · Livewire 4 · PHP 8.4 · PostgreSQL 17 · Redis**.

---

## Features

**CRM**
- Companies, People, Opportunities with custom fields
- Activity timeline on every record
- Notes and Tasks with Kanban board
- Inbound/outbound email integration (IMAP + SMTP)
- Custom reports with CSV export
- Bilingual interface (English + Bulgarian)

**ERP** *(per-workspace opt-in)*
- Products & Services catalog with categories and units
- Stock tracking — movements, low-stock alerts, auto-reduction on accepted quotes
- Quotes & Proposals with PDF export
- Invoices & Payments with overdue detection
- Projects with milestones, tasks, and Kanban board

**Platform**
- Multi-workspace (team) support with isolated data
- Social login — Google and GitHub OAuth
- System admin panel (separate from CRM)
- Fully brandable — custom logo and hero image via environment variables
- Self-hosted — your server, your data

---

## Quick Start (Docker)

```bash
# Clone the repo
git clone https://github.com/boroborovski/erp-crm.git
cd erp-crm

# Generate secrets and start
bash start.sh
```

Open **http://localhost/app** — default credentials are printed in the terminal.

---

## Production Deployment

```bash
# 1. Configure environment
cp .env.production.example .env
# Edit .env — fill in all <CHANGE_ME> values

# 2. Deploy
bash deploy.sh
```

`deploy.sh` builds the image, starts all services (app, nginx, postgres, redis, horizon, scheduler), runs migrations, and polls until healthy.

See `.env.production.example` for the full variable reference including mail, IMAP, OAuth, S3, branding, and monitoring.

### SSL

The nginx config at `docker/nginx/default.conf` includes a commented-out HTTPS block. Use Certbot:

```bash
certbot certonly --standalone -d yourapp.com
```

Then uncomment the SSL server block in `docker/nginx/default.conf` and redeploy.

---

## Environment Variables — Key Groups

| Group | Variables |
|---|---|
| App | `APP_NAME`, `APP_URL`, `APP_KEY`, `APP_LOCALE` |
| Database | `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` |
| Cache / Queue | `REDIS_HOST`, `REDIS_PASSWORD` |
| Mail | `MAIL_MAILER`, `MAIL_HOST`, `MAIL_FROM_ADDRESS` |
| IMAP | `IMAP_HOST`, `IMAP_USERNAME`, `IMAP_PASSWORD` |
| First boot | `ADMIN_EMAIL`, `ADMIN_PASSWORD`, `SYSADMIN_EMAIL`, `SYSADMIN_PASSWORD` |
| Branding | `LANDING_LOGO_CUSTOM_PATH`, `LANDING_HERO_BANNER_IMAGE` |
| OAuth | `GITHUB_CLIENT_ID/SECRET`, `GOOGLE_CLIENT_ID/SECRET/REDIRECT_URI` |
| Storage | `FILESYSTEM_DISK`, `AWS_*` |
| Monitoring | `SENTRY_LARAVEL_DSN`, `FATHOM_ANALYTICS_SITE_ID` |

---

## Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 |
| Admin UI | Filament 5 + Livewire 4 |
| Language | PHP 8.4 |
| Database | PostgreSQL 17 |
| Cache / Queue | Redis 7 |
| Queue worker | Laravel Horizon |
| Container | Docker (serversideup/php:8.4-fpm-nginx) |
| Proxy | Nginx |

---

## Docker Services

| Service | Role |
|---|---|
| `app` | PHP-FPM + built-in nginx on :8080 |
| `nginx` | Reverse proxy, SSL termination, ports 80/443 |
| `postgres` | Database |
| `redis` | Cache, sessions, queues |
| `horizon` | Queue worker |
| `scheduler` | Laravel task scheduler |

---

## Requirements (non-Docker)

- PHP 8.4+ with extensions: `pgsql`, `redis`, `intl`, `gd`, `imagick`, `bcmath`
- PostgreSQL 17+
- Redis 7+
- Composer 2
- Node.js 22+
