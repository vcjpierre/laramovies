# tailwind-4-redesign

Objective: move the asset pipeline from Laravel Mix + Tailwind 1 to Vite + Tailwind 4 and rebuild the interface to a premium standard.
Branch: `feat/tailwind-4-redesign` from `feat/laravel-13-upgrade` (base `f3f3f3b`).
Delivery strategy: ask-on-risk. Test runner: `php artisan test` (PHP 8.5.12 by full path).

## Specs

- **S1** User request, verbatim: "puedes actualizar tailwindcss y mejorar los estilos, puedes usar alguna skill de diseño"
- **S2** `tailwindcss` must be on the latest stable major (4.x) instead of 1.9.6, with no dependency on Laravel Mix or webpack.
- **S3** The asset pipeline must still deliver the CSS the app serves from a fresh clone with no Node step, exactly as the committed `public/css/main.css` did before.
- **S4** Existing behavior must not regress: the six routes render, the Livewire search dropdown still searches and navigates, the poster and trailer modals still open and close, and the test suite passes unchanged.
- **S5** The redesign follows the `redesign-existing-projects` design skill already loaded.
- **S6** Design audit items that apply and were fixed: browser-default typography, cool-gray overload, single accent color, missing hover/active/focus states, missing max-width container, generic section headings, missing meta description and social tags, missing skip link and active nav state, a dead `href="#"` avatar link, no footer, and no custom 404.
- **S7** Verification: `npm run build` succeeds, `npm audit` drops the Mix/webpack advisories, every route returns 200 with no console errors, and the suite still reports 9 passing.
- **S8** Commits only. No push, PR, or merge.

## Tasks

| ID | Specs | Route | Status | Commit |
| -- | ----- | ----- | ------ | ------ |
| T1 | S2, S3 | inline | done | `2c1a673` |
| T2 | S5, S6 | inline | done | `2c1a673` |
| T3 | S5, S6 | inline | done | `2c1a673` |
| T4 | S5, S6 | inline | done | `2c1a673` |
| T5 | S5, S6 | inline | done | `2c1a673` |
| T6 | S6 | inline | done | `2c1a673` |
| T7 | S7 | inline | done | `2c1a673` |

## Log

L1. 2026-10-22 - User request, verbatim: "puedes actualizar tailwindcss y mejorar los estilos, puedes usar alguna skill de diseño".

L2. 2026-10-22 - Exploration. Stack: Laravel 13, `resources/css/main.css` with the three `@tailwind` directives, `webpack.mix.js` using `postCss` + `purgeCss`, Tailwind 1.9.6, `tailwind.config.js` with a `width.96` extension and the `tailwindcss-spinner` plugin. Eleven Blade views. Dark theme on `bg-gray-900`, orange-500 accent, `container mx-auto` layouts, a 5-column poster grid, a nav that did not stick, no footer, no per-page titles.

L3. 2026-10-22 - Tailwind 4 cannot run under Laravel Mix 6: it ships as a Vite/PostCSS plugin with Lightning CSS and a CSS-first `@theme` configuration, so the pipeline moves to Vite. This also removes the 55 remaining npm advisories, which all lived in `laravel-mix`, `webpack`, and `webpack-dev-server`. The Dockerfile already detects `vite.config.js` and switches `ASSET_CMD` to `build`, so no container change was needed.

L4. 2026-10-22 - `resources/js/app.js` only pulled in `bootstrap.js`, which wired axios and lodash for code nothing used; all interactivity is Livewire or Alpine. The JS bundle was dropped, together with axios, lodash, sass, vue-template-compiler, resolve-url-loader, cross-env and laravel-mix-purgecss. Installed: tailwindcss 4.3.3, @tailwindcss/vite 4.3.3, laravel-vite-plugin 3.2.0, vite 8.3.5.

L5. 2026-10-22 - `.gitignore` does not exclude `public/build`, so the Vite output stays committed. This keeps spec S3: a fresh clone serves styled pages with no Node step, and the suite keeps rendering views without a manifest error.

L6. 2026-10-22 - Design direction, from the skill audit and the existing content: an editorial film-catalogue look. `Instrument Serif` for display type, `Outfit` for UI, one desaturated amber accent (`#e2a13d`) replacing orange-500, surfaces stepped by luminance in a cool near-black rather than by borders, amber-tinted shadows, a fixed grain overlay, and staggered card entries. `tailwindcss-spinner` was replaced by a `.spinner` component in `main.css`, since the plugin no longer exists.

L7. 2026-10-22 - The suite pins the exact section labels (`Popular Movies`, `Now Playing`, `Popular Shows`, `Top Rated Shows`, `Popular Actors`), so the headings kept those strings instead of the shorter labels the redesign suggested. The tests were not edited.

L8. 2026-10-22 - `$tvshow['created_by']` is a plain array, not a collection like `cast` and `images`; the first render failed with `Call to a member function count() on array`. Fixed with `count(...)`.

L9. 2026-10-22 - First screenshot pass found four defects, all fixed: the view models multiplied `vote_average` by ten without rounding, so cards read `84.68%` (now `round(...)`, `84%`); the hero scrim was so dark the backdrop was invisible, and after lightening it the overview lost contrast over the bright side of the image (now a left-to-right scrim plus a bottom fade); the `Featured Crew` kicker was a `<p>` inside a `<dl>`, which is invalid HTML (now a `<div>` wrapper around a `<dl>`); and the TV show page placed the crew block above the trailer button while the movie page did the opposite (TV now matches movies).

L10. 2026-10-22 - Mobile pass: the header stacked into three rows and would have eaten 200px as a sticky bar, so it is `static` below `md` and sticky from `md` up. Show-page posters are centred below `md`. No horizontal overflow at 390px (`scrollWidth` 390 on `/` and `/movies/550`).

L11. 2026-10-22 - Interaction verification with puppeteer-core against the running server, at 1367x600: the image modal shows a 1280px-wide still, its close button sits at `top: 24` both inside the viewport and hit-testable, and it closes; the trailer modal mounts its iframe and closes; the Livewire search returns 7 results for "fight" with `Fight Club` first; zero console errors. This is the same modal pair that was fixed in the previous feature, re-checked because the markup changed.

L12. 2026-10-22 - Verification: `npm run build` emits `public/build/assets/main-*.css` (34.6 kB, 7.3 kB gzip); `npm audit` reports 0 vulnerabilities of any severity, down from 55 (8 critical); `php artisan test` reports 9 passed, 42 assertions, unchanged.

L13. 2026-10-22 - Commit `2c1a673` holds the whole migration. The ~400 authored line heuristic was deliberately exceeded and not split: deleting the Mix pipeline while the views still referenced `/css/main.css`, or restyling the markup before Tailwind 4 emitted its utilities, would each leave an intermediate commit that renders a broken site. The pipeline swap and the markup that depends on it are one atomic change. A separate docs commit follows.
