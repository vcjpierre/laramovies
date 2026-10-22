# tailwind-4-redesign

Objective: move the asset pipeline from Laravel Mix + Tailwind 1 to Vite + Tailwind 4 and rebuild the interface to a premium standard.
Branch: `feat/tailwind-4-redesign` from `feat/laravel-13-upgrade` (base `f3f3f3b`).
Delivery strategy: ask-on-risk. Test runner: `php artisan test` (PHP 8.5.12 by full path).

## Specs

- **S1** User request, verbatim: "puedes actualizar tailwindcss y mejorar los estilos, puedes usar alguna skill de diseño"
- **S2** `tailwindcss` must be on the latest stable major (4.x) instead of 1.9.6, with no dependency on Laravel Mix or webpack.
- **S3** The asset pipeline must still deliver the CSS the app serves from a fresh clone with no Node step, exactly as the committed `public/css/main.css` does today.
- **S4** Existing behavior must not regress: the six routes render, the Livewire search dropdown still searches and navigates, the poster and trailer modals still open and close, and the test suite passes unchanged.
- **S5** The redesign follows the `redesign-existing-projects` design skill already loaded.
- **S6** Design audit items that apply and must be fixed: browser-default typography, pure/cool-gray excessive saturation, single accent color, missing hover/active/focus states, missing max-width container, generic section headings, missing meta description and social tags, missing skip link and active nav state, dead `href="#"` links, and no custom 404.
- **S7** Verification: `npm run build` succeeds, `npm audit` drops the Mix/webpack advisories, every route returns 200 with no console errors, and the suite still reports 9 passing.
- **S8** Commits only. No push, PR, or merge.

## Tasks

| ID | Specs | Route | Status |
| -- | ----- | ----- | ------ |
| T1 | S2, S3, S4 | inline | done |
| T2 | S5, S6 | inline | done |
| T3 | S5, S6 | inline | done |
| T4 | S5, S6 | inline | done |
| T5 | S5, S6 | inline | done |
| T6 | S6 | inline | done |
| T7 | S7 | inline | done |

## Log

L1. 2026-10-22 - User request, verbatim: "puedes actualizar tailwindcss y mejorar los estilos, puedes usar alguna skill de diseño".

L2. 2026-10-22 - Exploration. Stack: Laravel 13, `resources/css/main.css` with the three `@tailwind` directives, `webpack.mix.js` using `postCss` + `purgeCss`, Tailwind 1.9.6, `tailwind.config.js` with a `width.96` extension and the `tailwindcss-spinner` plugin. Eleven Blade views. Dark theme on `bg-gray-900`, orange-500 accent, `container mx-auto` layouts, a 5-column poster grid, a sticky-less nav, no footer, no per-page titles.

L3. 2026-10-22 - Tailwind 4 cannot run under Laravel Mix 6: it ships as a Vite/PostCSS plugin with Lightning CSS and a CSS-first `@theme` configuration, so the pipeline moves to Vite. This also removes the 55 remaining npm advisories, which all lived in `laravel-mix`, `webpack`, and `webpack-dev-server`. The Dockerfile already detects `vite.config.js` and switches `ASSET_CMD` to `build`, so no container change is needed.

L4. 2026-10-22 - `resources/js/app.js` only pulled in `bootstrap.js`, which wired axios and lodash for code nothing uses; all interactivity is Livewire or Alpine. The JS bundle is dropped, together with axios, lodash, sass, vue-template-compiler, resolve-url-loader, cross-env and laravel-mix-purgecss.

L5. 2026-10-22 - `.gitignore` does not exclude `public/build`, so the Vite output stays committed. This keeps spec S3: a fresh clone serves styled pages with no Node step, and the suite keeps rendering views without a manifest error.

L6. 2026-10-22 - Design direction, from the skill audit and the existing content: an editorial film-catalogue look. `Instrument Serif` for display type, `Outfit` for UI, one desaturated amber accent (`#e2a13d`) replacing orange-500, surfaces stepped by luminance in a cool near-black rather than borders, amber-tinted shadows, a fixed grain overlay, and staggered card entry. All grays move to one cool family; the pure-white-on-reading-gray combinations are replaced by `text-white` on tinted ink.
