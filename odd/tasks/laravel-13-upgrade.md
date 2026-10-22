# Laravel 13 + Livewire 4 dependency upgrade

Objective: move `laramovies` from Laravel 8.83 / Livewire 1.3 to Laravel 13 / Livewire 4 on PHP 8.3, clearing every Composer advisory and restoring a supported-version baseline.
Branch: `feat/laravel-13-upgrade`
Delivery strategy: `single-pr` (no push; delivery stays a user decision)
Test runner: `php artisan test` (PHPUnit 12)

## Specs

S1. The Composer manifest targets Laravel 13, Livewire 4, Guzzle 8 and PHP 8.3, and resolves to stable releases only. `minimum-stability` is `stable` and `prefer-stable` is `true`. The abandoned packages `fideloper/proxy`, `fruitcake/laravel-cors`, `fzaninotto/faker` and `facade/ignition` are removed; `fakerphp/faker` replaces `fzaninotto/faker`; `spatie/laravel-view-models` stays at `^1.6` (the last release supporting `illuminate ^13`).

S2. `composer audit` reports zero advisories.

S3. The application boots on the Laravel 11+ application structure: `bootstrap/app.php` uses `Application::configure()`, application service providers live in `bootstrap/providers.php`, the legacy `app/Http/Kernel.php`, `app/Console/Kernel.php`, `app/Exceptions/Handler.php` and `app/Providers/RouteServiceProvider.php` are removed, the `User` model lives in `app/Models/User.php`, seeders live in `database/seeders/`, and `config/app.php` no longer carries a `providers` array so the framework's own default provider list is used. The `User` model and its factory are updated to the current `HasFactory` / `casts()` method style.

S4. The Livewire search dropdown keeps working after the Livewire 1 to Livewire 4 jump. The component class lives in `app/Livewire/SearchDropdown.php` under the `App\Livewire` namespace (Livewire 4's `class_namespace` / `class_path` default), the layout uses `@livewireStyles` / `@livewireScripts` and a self-closing `<livewire:search-dropdown />` tag, the search input uses `wire:model.live.debounce.500ms` so typing still hits the server, and the Alpine 2 CDN script is removed in favour of the Alpine 3 build bundled with Livewire 4 (`x-show.transition.opacity` becomes `x-transition.opacity`).

S5. The existing feature suite passes unchanged against the upgraded stack: `tests/Feature/ViewMoviesTest.php` (3 tests) and `tests/Feature/ViewActorsTest.php` (3 tests). `phpunit.xml` is migrated to the PHPUnit 12 schema.

S6. The container build targets PHP 8.3: `Dockerfile` uses `ARG PHP_VERSION=8.3` and no longer patches `app/Http/Middleware/TrustProxies.php` with `sed`, because that middleware no longer declares a `$proxies` property.

S7. Frontend dependencies are bumped where the bump is a drop-in replacement: `axios` moves from `^0.21` to `^1`, whose advisories (CVE-2021-3749, CVE-2023-45857) are unpatched in the 0.x line. The Laravel Mix + Tailwind 1.x asset pipeline is deliberately left alone: moving it to Vite + Tailwind 4 is a CSS rewrite, not a dependency bump, and is out of scope.

## Tasks

| ID | Specs | Route | Risk | Commit | Status |
|----|-------|-------|------|--------|--------|
| T1 | S1, S2 | inline | item 5 (dependencies) | pending | pending |
| T2 | S3 | inline | none | pending | pending |
| T3 | S4 | inline | none | pending | pending |
| T4 | S3 | inline | none | pending | pending |
| T5 | S5 | inline | none | pending | pending |
| T6 | S6, S7 | inline | item 5 (delivery/environment) | pending | pending |
| T7 | S2, S5 | inline | none | pending | pending |

## Log

L1. 2026-10-22 — User request, verbatim: "actualizar las dependencias de este proyecto a las versiones más recientes y estables, tomando en cuenta que hay actualmente una vulnerabilidad de PHP". The reported symptom was a Composer resolution failure on `livewire/livewire` (`1.x-dev` was not found for the `dev` stability requirement).

L2. 2026-10-22 — Baseline audit: 48 advisories across 14 packages. Root cause of the resolution failure: `"minimum-stability": "dev"` in `composer.json`, which forces Composer to accept `1.x-dev` for `livewire/livewire` instead of a stable tag. Secondary finding: `fruitcake/laravel-cors` v3.0.0 only declares `illuminate/support: ^6|^7|^8|^9`, so it cannot coexist with Laravel 13 and must be replaced by the framework's built-in `Illuminate\Http\Middleware\HandleCors`.

L3. 2026-10-22 — Version decision requested from the user and answered: **Laravel 13 + PHP 8.3** (over Laravel 12 + PHP 8.2). PHP 8.3.33 is already installed at `C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64`.

L4. 2026-10-22 — Laravel 8 has no patched branch: the remaining advisories (temporary signed URL path confusion, CRLF injection in the default email validation rule, file validation bypass) are only fixed in 11+. Laravel 13.38.0 / 12.70.1 are the newest stable releases; Laravel 13 requires `php: ^8.3`, Laravel 12 requires `php: ^8.2`.

L5. 2026-10-22 — Chosen target versions: `laravel/framework ^13.17`, `livewire/livewire ^4.4` (4.4.8, `illuminate ^10|^11|^12|^13`), `guzzlehttp/guzzle ^8.3` (8.3.0, pulls `guzzlehttp/psr7 ^3.2` which carries the host-confusion and CRLF fixes), `spatie/laravel-view-models ^1.6` (1.6.2, `illuminate ^8|^9|^10|^11|^12|^13`), `phpunit/phpunit ^12.5`, `nunomaduro/collision ^8.6`, `fakerphp/faker ^1.24`, `laravel/tinker ^3.0`.

L6. 2026-10-22 — Migration path chosen: full Laravel 11+ skeleton restructure rather than staying on the Laravel 8 layout. Reason: the legacy `config/app.php` `providers` array is only a compatibility shim in Laravel 13 (`RegisterProviders` falls back to `ServiceProvider::defaultProviders()` only when the key is absent), so keeping the Laravel 8 provider list would silently drop providers added in Laravel 9-13.
