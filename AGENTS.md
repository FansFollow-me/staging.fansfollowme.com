# AGENTS.md — FFM Sponzy Project Instructions

## Project Overview
FansFollow.me (FFM) is a creator platform for fitness, bodybuilding, and martial arts creators. Built on **Sponzy v7.9.2** (a commercial PHP/Laravel script), hosted on **Laravel Cloud**, with **Cloudflare R2** for file storage.

**This is NOT a greenfield project.** Sponzy is a purchased script with its own conventions. Respect them.

---

## Architecture

### Stack
- **Framework:** Laravel 12.46 / PHP 8.5
- **Database:** MySQL 8.4 (tables use `stg_` prefix)
- **Frontend:** Blade templates + Bootstrap 5 + vanilla JS (no React/Vue)
- **Storage:** Cloudflare R2 (S3-compatible)
- **Hosting:** Laravel Cloud (auto-deploy on push to main)
- **Video/Audio:** Agora SDK
- **Analytics:** GA4, Microsoft Clarity, Usebasin

### Directory Structure
```
app/
├── Http/Controllers/    # All controllers (80+ files)
├── Models/              # Eloquent models (66 files)
├── Services/            # External service integrations
├── Jobs/                # Queue jobs (video encoding, moderation)
├── Events/              # Laravel events
├── Listeners/           # Event listeners
├── Notifications/       # Email/push notifications
└── Helper.php           # Global helper class

resources/views/
├── index/               # Public pages (home, explore, creators, etc.)
├── users/               # Authenticated user pages (dashboard, settings, etc.)
├── admin/               # Admin panel pages (100+ files)
├── includes/            # Shared partials (navbar, footer, modals)
├── layouts/             # Master layouts (app.blade.php, appnew.blade.php)
├── reels/               # Reels views
├── shop/                # Shop views
└── emails/              # Email templates

routes/
├── web.php              # ALL routes (public, auth, admin)
├── api.php              # API routes (minimal)
└── console.php          # Artisan commands
```

### Key Patterns

#### Table Prefix: `stg_`
ALL database tables use the `stg_` prefix. When creating Eloquent models, ALWAYS set:
```php
protected $table = 'stg_tablename';
```
**Exception:** Some tables like `admin_settings`, `video_calls`, `audio_calls`, `vaults` do NOT have the prefix. Check the schema before assuming.

#### Model Convention
```php
class ExampleModel extends Model
{
    protected $table = 'stg_examples';  // ALWAYS set this
    protected $guarded = [];            // Sponzy uses guarded=[], not fillable
    public $timestamps = false;         // Most Sponzy tables don't use timestamps
}
```

#### Controller Convention
```php
class ExampleController extends Controller
{
    protected $settings;  // Admin settings singleton

    public function __construct()
    {
        $this->settings = config('settings');  // Always available
    }
}
```

#### View Convention
```blade
@extends('layouts.app')  {{-- or layouts.appnew for newer pages --}}

@section('title')Page Title @endsection

@section('content')
    {{-- Page content here --}}
@endsection
```

#### Route Convention
```php
// Public routes (no auth)
Route::get('page', [Controller::class, 'method']);

// Authenticated routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [UserController::class, 'dashboard']);
});

// Admin routes (role middleware)
Route::group(['middleware' => ['role', 'nocache']], function () {
    Route::prefix('panel/admin')->group(function () {
        Route::get('/', [AdminController::class, 'admin']);
    });
});
```

---

## Critical Rules

### DO NOT
1. **DO NOT** create new tables without the `stg_` prefix (unless it's a system table like `admin_settings`)
2. **DO NOT** use React, Vue, or any SPA framework — this is Blade + vanilla JS
3. **DO NOT** modify the Sponzy core files without documenting why
4. **DO NOT** add Composer packages without checking if Sponzy already has the functionality
5. **DO NOT** use `$fillable` — Sponzy uses `$guarded = []`
6. **DO NOT** assume table names — always check `database/schema.sql` or the model
7. **DO NOT** create new CSS files — use `public/css/ffm-brand.css` for FFM customizations
8. **DO NOT** modify `public/css/core.min.css` or `public/css/bootstrap.min.css` — these are Sponzy vendor files
9. **DO NOT** hardcode URLs — use `url()`, `route()`, or `asset()` helpers
10. **DO NOT** skip the `stg_` prefix on joins — this caused the Reels 500 bug

### ALWAYS
1. **ALWAYS** check if a feature already exists in Sponzy before building it
2. **ALWAYS** use `ffm-brand.css` for FFM-specific styling (53KB of overrides already exist)
3. **ALWAYS** test with all 3 user roles: fan (testfan), creator (testcreator), admin (Admin)
4. **ALWAYS** run `tests/qa-auth-test.sh` after changes
5. **ALWAYS** commit to `main` branch (auto-deploys to staging)
6. **ALWAYS** check `database/schema.sql` for table structure before writing queries
7. **ALWAYS** use the dark theme (`data-bs-theme="dark"`) — FFM is dark by default
8. **ALWAYS** use Inter font family — FFM brand font
9. **ALWAYS** check `config('settings.*')` for feature flags before showing UI elements
10. **ALWAYS** preserve existing Sponzy functionality when adding FFM branding

---

## Design Tokens (Use These)

```css
/* FFM Brand Colors */
--ffm-bg: #0B0F1A;           /* Main background */
--ffm-card: #111827;         /* Card/panel background */
--ffm-border: #1f2937;       /* Borders */
--ffm-orange: #f97316;       /* Primary CTA / brand color */
--ffm-text: #e5e7eb;         /* Primary text */
--ffm-muted: #9ca3af;        /* Secondary text */

/* Typography */
font-family: 'Inter', system-ui, sans-serif;

/* Layout */
navbar-height: 72px;
```

---

## File Editing Rules

### CSS Changes
- **ONLY** edit `public/css/ffm-brand.css` for FFM customizations
- Use `!important` sparingly but acceptably to override Sponzy defaults
- Group overrides by page/feature with clear comments

### Blade Template Changes
- Public pages: `resources/views/index/*.blade.php`
- User pages: `resources/views/users/*.blade.php`
- Admin pages: `resources/views/admin/*.blade.php`
- Shared partials: `resources/views/includes/*.blade.php`
- **NEVER** edit `layouts/app.blade.php` without extreme caution — it's the master layout

### PHP Changes
- Controllers: `app/Http/Controllers/`
- Models: `app/Models/` (always set `$table`)
- Routes: `routes/web.php` (all routes are here)

### Database Changes
- Schema reference: `database/schema.sql`
- Migrations: `database/migrations/`
- Deploy fixes: `deploy.sh` (idempotent schema fixes run on every deploy)

---

## Testing

### Test Accounts
| Account | Username | Password | Role |
|---------|----------|----------|------|
| Admin | Admin | TestPass123! | Admin (full access) |
| Fan | testfan | TestPass123! | Normal user |
| Creator | testcreator | TestPass123! | Creator (verified) |

### QA Scripts
```bash
# Public page smoke test (no auth)
bash tests/qa-browser-test.sh

# Authenticated user flow test (logs in as all 3 roles)
bash tests/qa-auth-test.sh
```

### After Every Change
1. Run `bash tests/qa-auth-test.sh`
2. Check for new 500 errors
3. Verify screenshots in `tests/screenshots/auth/`
4. Commit and push (auto-deploys)
5. Verify on staging URL

---

## Deployment

### Auto-Deploy Pipeline
```
git push origin main
    → Laravel Cloud detects push
    → Runs: composer install && php fix-laravel-cloud.php && php artisan view:clear
    → Runs: bash deploy.sh (migrate, schema fixes, seed, cache clear)
    → Live at https://staging.fansfollowme.com
```

### Deploy Script (`deploy.sh`)
- Creates storage directories
- Runs migrations
- Fixes missing columns (idempotent)
- Creates missing tables (video_calls, audio_calls, vaults)
- Seeds test accounts
- Clears caches

### After Deploy
```bash
# Verify deployment
bash tests/qa-browser-test.sh

# Check specific page
curl -s -o /dev/null -w "%{http_code}" "https://staging.fansfollowme.com/PAGE"
```

---

## Feature Flags (Admin Settings)

Check `config('settings.*')` before showing features:
```php
@if(config('settings.allow_reels'))    {{-- Reels feature --}}
@if(config('settings.allow_vault'))    {{-- Vault feature --}}
@if(config('settings.gifts'))          {{-- Gifts feature --}}
@if(config('settings.video_call_status'))  {{-- Video calls --}}
@if(config('settings.audio_call_status'))  {{-- Audio calls --}}
```

---

## Common Pitfalls

1. **Table prefix:** The #1 bug source. Always use `stg_` prefix in models and joins.
2. **CSRF tokens:** Login form uses AJAX with `X-Requested-With: XMLHttpRequest` header.
3. **Age verification:** Middleware redirects to `/age/verification` if `user->age_verification !== 1`.
4. **Admin routes:** Under `/panel/admin/`, NOT `/admin/`.
5. **User routes:** Under `/settings/`, `/my/`, etc. — NOT `/user/`.
6. **View cache:** Run `php artisan view:clear` after Blade changes (handled by deploy).
7. **Config cache:** Run `php artisan config:clear` after settings changes (handled by deploy).

---

## What Martin Needs

Martin is the product owner. He:
- Creates tasks in Highrise
- Provides design feedback
- Signs off on designs BEFORE code changes
- Does NOT write code

**Rule:** Do NOT touch the site or build anything until Martin provides design sign-off.

---

## Current Status

See `STATUS.md` for live status and `tests/FFM-FEATURE-AUDIT.md` for feature inventory.

**Blueprint page:** https://staging.fansfollowme.com/blueprint (share with Martin)
