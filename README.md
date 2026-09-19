# FFM Backend (bespoke Laravel)

Clean rebuild of the FansFollow product surface for `fansfollowme.com`.
Design source: Bolt mockup. Feature checklist: Sponzy blueprint. Production `FansFollow.me` is untouched.

## What is here (Phase 0–1 scaffold)

- Laravel 12 app skeleton (`composer.json`, `bootstrap/app.php`, routes)
- Real auth (no demo `handleDemoLogin`)
- Roles: fan / creator / admin with middleware
- Profiles, follows schema
- **QR join** `/j/{code}` + creator `/my/qr`
- Wallet + live_rooms migrations (ready for Phase 3–4)
- Seeded test accounts matching the mockup passwords

## Requirements

- PHP 8.3+ with extensions: pdo_mysql, mbstring, openssl, curl, fileinfo, zip
- Composer 2
- MySQL 8 (or switch `.env` to sqlite for local smoke)

This machine did not have PHP at scaffold time. Install PHP on your dev box, then:

```powershell
cd ffm-backend
composer install
copy .env.example .env
php artisan key:generate
# set DB_* in .env
php artisan migrate --seed
php artisan serve
```

Open `http://127.0.0.1:8000`

### Test logins (seeded)

| Username | Password | Role |
|---|---|---|
| `Admin` | `TestPass123!` | admin |
| `testfan` | `TestPass123!` | fan |
| `testcreator` | `TestPass123!` | creator |

QR demo: `http://127.0.0.1:8000/j/testcreator`

## Next phases

See `../FFM-BUILD-SPEC.md`

2. Posts + media (R2)
3. Stripe, wallet ledger, subs, tips, PPV, shop
4. Live 4K provider (Agora/Mux)
5. QR analytics polish, messaging, full admin
6. Point `fansfollowme.com` DNS at this app (replace Netlify)

## Rules

- Do not deploy to live `FansFollow.me`
- Do not copy Sponzy PHP
- Design CSS stays in `public/css` from the mockup; app overrides in `ffm-app.css`
