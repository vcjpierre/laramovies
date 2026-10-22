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

S7. Frontend dependencies are bumped where the bump is a drop-in replacement: `axios` moves from `^0.21` to `^1`, whose advisories (CVE-2021-3749, CVE-2023-45857) are unpatched in the 0.x line. `npm audit` reports no critical advisories afterwards. The Laravel Mix + Tailwind 1.x asset pipeline is deliberately left alone: moving it to Vite + Tailwind 4 is a CSS rewrite, not a dependency bump, and is out of scope. Because Laravel Mix 6.0.49 reads `webpack/lib/SizeFormatHelpers`, which webpack removed after 5.94.0, `webpack` is pinned to `5.94.0` through an npm `overrides` entry so the asset build keeps working on a patched webpack.

## Tasks

| ID | Specs | Route | Risk | Commit | Status |
|----|-------|-------|------|--------|--------|
| T1 | S1, S2 | inline | item 5 (dependencies) | `08c732a` | done |
| T2 | S3 | inline | none | `a69a2f2` | done |
| T3 | S4 | inline | none | `a69a2f2` | done |
| T4 | S3 | inline | none | `a69a2f2` | done |
| T5 | S5 | inline | none | `a69a2f2` | done |
| T6 | S6, S7 | inline | item 5 (delivery/environment) | `aba2dea` | done |
| T7 | S2, S5 | inline | none | `a69a2f2` | done |

## Log

L1. 2026-10-22 — User request, verbatim: "actualizar las dependencias de este proyecto a las versiones más recientes y estables, tomando en cuenta que hay actualmente una vulnerabilidad de PHP". The reported symptom was a Composer resolution failure on `livewire/livewire` (`1.x-dev` was not found for the `dev` stability requirement).

L2. 2026-10-22 — Baseline audit: 48 advisories across 14 packages. Root cause of the resolution failure: `"minimum-stability": "dev"` in `composer.json`, which forces Composer to accept `1.x-dev` for `livewire/livewire` instead of a stable tag. Secondary finding: `fruitcake/laravel-cors` v3.0.0 only declares `illuminate/support: ^6|^7|^8|^9`, so it cannot coexist with Laravel 13 and must be replaced by the framework's built-in `Illuminate\Http\Middleware\HandleCors`.

L3. 2026-10-22 — Version decision requested from the user and answered: **Laravel 13 + PHP 8.3** (over Laravel 12 + PHP 8.2). PHP 8.3.33 is already installed at `C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64`.

L4. 2026-10-22 — Laravel 8 has no patched branch: the remaining advisories (temporary signed URL path confusion, CRLF injection in the default email validation rule, file validation bypass) are only fixed in 11+. Laravel 13.38.0 / 12.70.1 are the newest stable releases; Laravel 13 requires `php: ^8.3`, Laravel 12 requires `php: ^8.2`.

L5. 2026-10-22 — Chosen target versions: `laravel/framework ^13.17`, `livewire/livewire ^4.4` (4.4.8, `illuminate ^10|^11|^12|^13`), `guzzlehttp/guzzle ^8.3` (8.3.0, pulls `guzzlehttp/psr7 ^3.2` which carries the host-confusion and CRLF fixes), `spatie/laravel-view-models ^1.6` (1.6.2, `illuminate ^8|^9|^10|^11|^12|^13`), `phpunit/phpunit ^12.5`, `nunomaduro/collision ^8.6`, `fakerphp/faker ^1.24`, `laravel/tinker ^3.0`.

L6. 2026-10-22 — Migration path chosen: full Laravel 11+ skeleton restructure rather than staying on the Laravel 8 layout. Reason: the legacy `config/app.php` `providers` array is only a compatibility shim in Laravel 13 (`RegisterProviders` falls back to `ServiceProvider::defaultProviders()` only when the key is absent), so keeping the Laravel 8 provider list would silently drop providers added in Laravel 9-13.

L7. 2026-10-22 — Differential check against the base commit `0426552` in a scratch worktree (`mktemp -d` equivalent under the system temp dir, removed afterwards). Baseline result: 1 failing test, `ViewTvTest::the_tv_index_page_shows_the_correct_info`, with `Undefined array key "genres"`. Cause is a pre-existing bug in the test, not in the application: the test fakes `https://api.themoviedb.org/3/genre/movie/list` while `TvController@index` requests `https://api.themoviedb.org/3/genre/tv/list`, so the genres request was never stubbed. Fixed in the test (`genre/movie/list` -> `genre/tv/list`); the same fake key in `ViewMoviesTest` is correct and was left alone. Post-upgrade result: 9 tests, 9 passing.

L8. 2026-10-22 — `npm audit fix` broke the asset build: it moved `webpack` to 5.112.0, which removed `webpack/lib/SizeFormatHelpers`, the file Laravel Mix 6.0.49 requires. `webpack` is pinned to 5.94.0 with an npm `overrides` entry, which is the newest release that still ships that file and is not affected by GHSA-4vj7-3p9v-mh7p. `npm audit` afterwards: 55 advisories (18 low, 23 moderate, 14 high), 0 critical, down from 8 critical before. The remaining advisories sit in the Laravel Mix / webpack-dev-server toolchain, which never ships to the browser; clearing them requires the Mix to Vite migration that S7 excludes.

L9. 2026-10-22 — `TRUSTED_PROXIES` replaces the build-time `sed` patch of `app/Http/Middleware/TrustProxies.php`. Verified equivalent: `trustProxies(at: null)` trusts no proxy (same as the old `protected $proxies = null`) and the framework's default header set is `HEADER_X_FORWARDED_FOR | HOST | PORT | PROTO | PREFIX | AWS_ELB`, which is what `Request::HEADER_X_FORWARDED_ALL` resolves to. `at: '*'` reproduces the old patched value. The value is set in the Dockerfile (`ENV TRUSTED_PROXIES="*"`) and in `fly.toml`'s `[env]`.

L10. 2026-10-22 — PHP 8.5 deprecation: `PDO::MYSQL_ATTR_SSL_CA` is deprecated as of 8.5 in favour of `Pdo\Mysql::ATTR_SSL_CA`. Both resolve to the same integer (1008) and the class only exists from PHP 8.4 on, while the manifest still declares `php: ^8.3`, so `config/database.php` picks the constant with a `defined('Pdo\Mysql::ATTR_SSL_CA')` guard. It was the only PHP 8.5 deprecation in the whole application: the suite reports 9 passed / 0 deprecated on 8.5.12 and 9 passed / 0 deprecated on 8.3.33. Raising the manifest floor to `^8.4` would allow the guard to be dropped, but that narrows the supported PHP range and is a separate decision.

L11. 2026-10-22 - User report after the upgrade, verbatim: "cuando doy click en una pelicular ej http://127.0.0.1:8000/movies/1058424 se abre el modal del poster de ella pero no carga la imagen y tampoco puedo cerrar el modal". Reproduced with a headless Chrome driven through puppeteer-core against the local server. Two findings. (a) Real defect: the modal loaded the TMDB original size (2048x1152, 554 KB), which made the card 642px tall; the overlay centres its content with items-center, so in a 600px viewport the card started at y=-21px and the close button, which sits at the top of the card, was above the viewport and could not be clicked. That is the "no puedo cerrar" symptom. (b) The click expression spanned two lines without a semicolon, which relies on automatic semicolon insertion inside Alpine's generated function; it worked in the probe, but it is the only mechanism that can set isOpen while leaving image empty, which is exactly the broken image in the report (an empty src makes the browser request the page URL and fail to decode it). Fixes: original -> w1280 (212 KB), card capped at 90vh, image capped at 70vh, close button row made sticky top-0, and the click expression collapsed into one statement with an explicit semicolon. Applied to both movies/show.blade.php and 	v/show.blade.php, which carry the same modal. Rebuilt public/css/main.css because sticky and z-10 were newly used. Verified at 1367x600 and 1367x450: image loads (1280x720), close button inside the viewport at y=47 and y=31, both the button and Escape set display: none, zero console errors; suite 9 passed / 42 assertions.
