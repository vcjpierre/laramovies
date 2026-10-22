@extends('layouts.main')

@section('title', $actor['name'] . ' — Movie App')
@section('description', 'Biography, known-for titles and full credits for ' . $actor['name'] . '.')
@section('og_image', $actor['profile_path'])

@section('content')
    <div class="mx-auto max-w-[1440px] px-5 lg:px-8">
        <div class="grid grid-cols-1 gap-10 pt-12 lg:grid-cols-[minmax(0,18rem)_minmax(0,1fr)] lg:gap-16 lg:pt-16">

            <aside class="lg:sticky lg:top-28 lg:self-start">
                <div class="overflow-hidden rounded-card bg-surface ring-1 ring-white/6">
                    <img src="{{ $actor['profile_path'] }}" alt="Portrait of {{ $actor['name'] }}"
                         class="aspect-[2/3] w-full object-cover">
                </div>

                <ul class="mt-5 flex items-center gap-2">
                    @if ($social['facebook'])
                        <li>
                            <a href="{{ $social['facebook'] }}" title="Facebook"
                               class="flex size-9 items-center justify-center rounded-full bg-surface text-muted ring-1 ring-white/6 transition duration-200 hover:bg-surface-2 hover:text-accent hover:ring-accent/40">
                                <span class="sr-only">Facebook</span>
                                <svg class="size-4" viewBox="0 0 448 512" fill="currentColor" aria-hidden="true"><path d="M448 56.7v398.5c0 13.7-11.1 24.7-24.7 24.7H309.1V306.5h58.2l8.7-67.6h-67v-43.2c0-19.6 5.4-32.9 33.5-32.9h35.8v-60.5c-6.2-.8-27.4-2.7-52.2-2.7-51.6 0-87 31.5-87 89.4v49.9h-58.4v67.6h58.4V480H24.7C11.1 480 0 468.9 0 455.3V56.7C0 43.1 11.1 32 24.7 32h398.5c13.7 0 24.8 11.1 24.8 24.7z"/></svg>
                            </a>
                        </li>
                    @endif

                    @if ($social['instagram'])
                        <li>
                            <a href="{{ $social['instagram'] }}" title="Instagram"
                               class="flex size-9 items-center justify-center rounded-full bg-surface text-muted ring-1 ring-white/6 transition duration-200 hover:bg-surface-2 hover:text-accent hover:ring-accent/40">
                                <span class="sr-only">Instagram</span>
                                <svg class="size-4" viewBox="0 0 448 512" fill="currentColor" aria-hidden="true"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                            </a>
                        </li>
                    @endif

                    @if ($social['twitter'])
                        <li>
                            <a href="{{ $social['twitter'] }}" title="Twitter"
                               class="flex size-9 items-center justify-center rounded-full bg-surface text-muted ring-1 ring-white/6 transition duration-200 hover:bg-surface-2 hover:text-accent hover:ring-accent/40">
                                <span class="sr-only">Twitter</span>
                                <svg class="size-4" viewBox="0 0 512 512" fill="currentColor" aria-hidden="true"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
                            </a>
                        </li>
                    @endif

                    @if ($actor['homepage'])
                        <li>
                            <a href="{{ $actor['homepage'] }}" title="Website"
                               class="flex size-9 items-center justify-center rounded-full bg-surface text-muted ring-1 ring-white/6 transition duration-200 hover:bg-surface-2 hover:text-accent hover:ring-accent/40">
                                <span class="sr-only">Website</span>
                                <svg class="size-4" viewBox="0 0 496 512" fill="currentColor" aria-hidden="true"><path d="M248 8C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm82.29 357.6c-3.9 3.88-7.99 7.95-11.31 11.28-2.99 3-5.1 6.7-6.17 10.71-1.51 5.66-2.73 11.38-4.77 16.87l-17.39 46.85c-13.76 3-28 4.69-42.65 4.69v-27.38c1.69-12.62-7.64-36.26-22.63-51.25-6-6-9.37-14.14-9.37-22.63v-32.01c0-11.64-6.27-22.34-16.46-27.97-14.37-7.95-34.81-19.06-48.81-26.11-11.48-5.78-22.1-13.14-31.65-21.75l-.8-.72a114.792 114.792 0 01-18.06-20.74c-9.38-13.77-24.66-36.42-34.59-51.14 20.47-45.5 57.36-82.04 103.2-101.89l24.01 12.01C203.48 89.74 216 82.01 216 70.11v-11.3c7.99-1.29 16.12-2.11 24.39-2.42l28.3 28.3c6.25 6.25 6.25 16.38 0 22.63L264 112l-10.34 10.34c-3.12 3.12-3.12 8.19 0 11.31l4.69 4.69c3.12 3.12 3.12 8.19 0 11.31l-8 8a8.008 8.008 0 01-5.66 2.34h-8.99c-2.08 0-4.08.81-5.58 2.27l-9.92 9.65a8.008 8.008 0 00-1.58 9.31l15.59 31.19c2.66 5.32-1.21 11.58-7.15 11.58h-5.64c-1.93 0-3.79-.7-5.24-1.96l-9.28-8.06a16.017 16.017 0 00-15.55-3.1l-31.17 10.39a11.95 11.95 0 00-8.17 11.34c0 4.53 2.56 8.66 6.61 10.69l11.08 5.54c9.41 4.71 19.79 7.16 30.31 7.16s22.59 27.29 32 32h66.75c8.49 0 16.62 3.37 22.63 9.37l13.69 13.69a30.503 30.503 0 018.93 21.57 46.536 46.536 0 01-13.72 32.98zM417 274.25c-5.79-1.45-10.84-5-14.15-9.97l-17.98-26.97a23.97 23.97 0 010-26.62l19.59-29.38c2.32-3.47 5.5-6.29 9.24-8.15l12.98-6.49C440.2 193.59 448 223.87 448 256c0 8.67-.74 17.16-1.82 25.54L417 274.25z"/></svg>
                            </a>
                        </li>
                    @endif
                </ul>
            </aside>

            <div class="min-w-0">
                <p class="kicker">Actor</p>
                <h1 class="mt-3 font-display text-5xl leading-none tracking-tight text-white sm:text-6xl">{{ $actor['name'] }}</h1>

                @if ($actor['birthday'] || $actor['place_of_birth'])
                    <dl class="mt-8 flex flex-wrap gap-x-10 gap-y-4 border-y border-line/60 py-5">
                        @if ($actor['birthday'])
                            <div>
                                <dt class="kicker">Born</dt>
                                <dd class="mt-1.5 text-sm text-white/90">
                                    {{ $actor['birthday'] }}@if ($actor['age']) <span class="text-muted-2">({{ $actor['age'] }} years old)</span>@endif
                                </dd>
                            </div>
                        @endif

                        @if ($actor['place_of_birth'])
                            <div>
                                <dt class="kicker">From</dt>
                                <dd class="mt-1.5 text-sm text-white/90">{{ $actor['place_of_birth'] }}</dd>
                            </div>
                        @endif
                    </dl>
                @endif

                <p class="mt-8 max-w-prose text-sm leading-relaxed text-muted">{{ $actor['biography'] }}</p>

                <section aria-labelledby="known-for" class="mt-16">
                    <h2 id="known-for" class="font-display text-2xl text-white">Known For</h2>
                    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-3 lg:grid-cols-5">
                        @foreach ($knownForMovies as $movie)
                            <div class="group">
                                <a href="{{ $movie['linkToPage'] }}" class="block">
                                    <div class="aspect-[2/3] overflow-hidden rounded-card bg-surface ring-1 ring-white/6 transition duration-300 ease-out group-hover:-translate-y-1 group-hover:ring-accent/30">
                                        <img src="{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }} poster" loading="lazy"
                                             class="size-full object-cover transition duration-500 ease-out group-hover:scale-[1.04]">
                                    </div>
                                </a>
                                <a href="{{ $movie['linkToPage'] }}"
                                   class="mt-2 block line-clamp-2 text-xs leading-snug text-muted transition-colors duration-200 hover:text-white">{{ $movie['title'] }}</a>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>

        <section aria-labelledby="credits" class="mt-24 border-t border-line/60 pt-12">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <h2 id="credits" class="font-display text-3xl leading-none text-white sm:text-4xl">Credits</h2>
                <span class="kicker">{{ $credits->count() }} titles</span>
            </div>

            <ul class="mt-8 divide-y divide-line/50">
                @foreach ($credits as $credit)
                    <li class="flex flex-wrap items-baseline gap-x-4 gap-y-1 py-3 text-sm">
                        <span class="w-14 shrink-0 tabular-nums text-muted-2">{{ $credit['release_year'] }}</span>
                        <a href="{{ $credit['linkToPage'] }}"
                           class="font-medium text-white/90 transition-colors duration-200 hover:text-accent">{{ $credit['title'] }}</a>
                        @if (! empty($credit['character']))
                            <span class="text-muted-2">as {{ $credit['character'] }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection
