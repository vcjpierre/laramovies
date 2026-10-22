@extends('layouts.main')

@section('title', $tvshow['name'] . ' — Movie App')
@section('description', $tvshow['overview'])
@section('og_image', $tvshow['poster_path'])

@section('content')
    @php
        $firstImage = $tvshow['images']->first();
        $backdrop = is_array($firstImage) ? ($firstImage['file_path'] ?? null) : null;
    @endphp

    <section class="relative isolate z-0 overflow-hidden border-b border-line/60">
        @if ($backdrop)
            <img src="https://image.tmdb.org/t/p/w1280{{ $backdrop }}" alt=""
                 class="pointer-events-none absolute inset-0 -z-10 size-full object-cover opacity-60">
        @endif
        <div class="hero-scrim pointer-events-none absolute inset-0 -z-10" aria-hidden="true"></div>

        <div class="mx-auto max-w-[1440px] px-5 pt-10 pb-16 lg:px-8 lg:pt-16">
            <div class="grid gap-10 md:grid-cols-[minmax(0,15rem)_minmax(0,1fr)] md:gap-14 lg:grid-cols-[minmax(0,17rem)_minmax(0,1fr)]">
                <div class="mx-auto max-w-[15rem] md:mx-0 md:max-w-none">
                    <img src="{{ $tvshow['poster_path'] }}" alt="{{ $tvshow['name'] }} poster"
                         class="aspect-[2/3] w-full rounded-card object-cover shadow-lift ring-1 ring-white/10">
                </div>

                <div class="min-w-0">
                    <p class="kicker">Series</p>

                    <h1 class="mt-3 font-display text-5xl leading-[0.95] tracking-tight text-white sm:text-6xl lg:text-7xl">
                        {{ $tvshow['name'] }}
                    </h1>

                    <div class="mt-6 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-muted">
                        <span class="inline-flex items-center gap-2 font-medium tabular-nums text-accent">
                            <span class="size-1.5 rounded-full bg-accent" aria-hidden="true"></span>
                            {{ $tvshow['vote_average'] }}
                        </span>
                        <span class="h-3 w-px bg-line" aria-hidden="true"></span>
                        <span class="tabular-nums">{{ $tvshow['first_air_date'] }}</span>
                        <span class="h-3 w-px bg-line" aria-hidden="true"></span>
                        <span>{{ $tvshow['genres'] }}</span>
                    </div>

                    @if (! empty($tvshow['overview']))
                        <p class="mt-7 max-w-prose text-[15px] leading-relaxed text-muted">
                            {{ $tvshow['overview'] }}
                        </p>
                    @endif

                    <div x-data="{ isOpen: false }">
                        @if (count($tvshow['videos']['results']) > 0)
                            <div class="mt-9 flex flex-wrap items-center gap-4">
                                <button
                                    type="button"
                                    @click="isOpen = true"
                                    class="inline-flex items-center gap-2.5 rounded-full bg-accent px-6 py-3 text-sm font-semibold text-ink transition duration-200 ease-out hover:bg-accent-2 active:scale-[0.98]"
                                >
                                    <svg class="size-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M8 5.14v13.72a1 1 0 001.54.84l10.29-6.86a1 1 0 000-1.68L9.54 4.3A1 1 0 008 5.14z"/>
                                    </svg>
                                    Play Trailer
                                </button>

                                <a href="{{ route('tv.index') }}"
                                   class="rounded-full px-4 py-3 text-sm text-muted transition-colors duration-200 hover:text-white">
                                    Back to TV shows
                                </a>
                            </div>

                            <template x-if="isOpen">
                                <div class="animate-fade fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-ink/90 p-4 backdrop-blur-sm">
                                    <div class="w-full max-w-5xl overflow-hidden rounded-card bg-surface shadow-lift ring-1 ring-white/10">
                                        <div class="sticky top-0 z-10 flex justify-end bg-surface px-3 py-2">
                                            <button
                                                type="button"
                                                @click="isOpen = false"
                                                @keydown.escape.window="isOpen = false"
                                                aria-label="Close trailer"
                                                class="flex size-9 items-center justify-center rounded-full text-2xl leading-none text-muted transition duration-200 hover:bg-surface-2 hover:text-white"
                                            >&times;</button>
                                        </div>

                                        <div class="aspect-video w-full">
                                            <iframe
                                                class="size-full border-0"
                                                src="https://www.youtube.com/embed/{{ $tvshow['videos']['results'][0]['key'] }}"
                                                allow="autoplay; encrypted-media"
                                                allowfullscreen
                                                title="{{ $tvshow['name'] }} trailer"
                                            ></iframe>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        @endif
                    </div>

                    @if (count($tvshow['created_by']) > 0)
                        <div class="mt-10 max-w-lg border-t border-line/60 pt-6">
                            <p class="kicker mb-4">Featured Crew</p>
                            <dl class="grid gap-5 sm:grid-cols-2">
                                @foreach ($tvshow['created_by'] as $crew)
                                    <div>
                                        <dt class="text-xs text-muted-2">Creator</dt>
                                        <dd class="mt-1 text-sm font-medium text-white/90">{{ $crew['name'] }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section aria-labelledby="cast" class="mx-auto max-w-[1440px] px-5 py-16 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4 border-b border-line/60 pb-5">
            <h2 id="cast" class="font-display text-3xl leading-none text-white sm:text-4xl">Cast</h2>
            <span class="kicker">{{ $tvshow['cast']->count() }} billed</span>
        </div>

        <div class="stagger mt-9 grid grid-cols-2 gap-x-5 gap-y-8 sm:grid-cols-3 lg:grid-cols-5">
            @foreach ($tvshow['cast'] as $cast)
                <div class="group">
                    <a href="{{ route('actors.show', $cast['id']) }}" class="block">
                        <div class="aspect-[2/3] overflow-hidden rounded-card bg-surface ring-1 ring-white/6 transition duration-300 ease-out group-hover:-translate-y-1 group-hover:ring-accent/30">
                            <img src="{{ $cast['profile_path'] }}" alt="{{ $cast['name'] }}" loading="lazy"
                                 class="size-full object-cover transition duration-500 ease-out group-hover:scale-[1.04]">
                        </div>
                    </a>

                    <a href="{{ route('actors.show', $cast['id']) }}"
                       class="mt-2.5 block truncate text-sm font-medium text-white/90 transition-colors duration-200 hover:text-accent">{{ $cast['name'] }}</a>
                    <p class="truncate text-xs text-muted-2">{{ $cast['character'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <div class="tv-images" x-data="{ isOpen: false, image: '' }">
        <section aria-labelledby="images" class="mx-auto max-w-[1440px] px-5 pb-16 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-line/60 pb-5">
                <h2 id="images" class="font-display text-3xl leading-none text-white sm:text-4xl">Images</h2>
                <span class="kicker">{{ $tvshow['images']->count() }} stills</span>
            </div>

            <div class="stagger mt-9 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($tvshow['images'] as $image)
                    <a
                        @click.prevent="isOpen = true; image = '{{ 'https://image.tmdb.org/t/p/w1280/'.$image['file_path'] }}'"
                        href="#"
                        class="group block overflow-hidden rounded-card bg-surface ring-1 ring-white/6 transition duration-300 ease-out hover:ring-accent/30"
                        aria-label="View still at full size"
                    >
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ 'https://image.tmdb.org/t/p/w500/'.$image['file_path'] }}"
                                 alt="Still from {{ $tvshow['name'] }}" loading="lazy"
                                 class="size-full object-cover opacity-90 transition duration-500 ease-out group-hover:scale-[1.03] group-hover:opacity-100">
                        </div>
                    </a>
                @endforeach
            </div>

            <div
                x-show="isOpen"
                class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-ink/92 p-4 backdrop-blur-sm"
            >
                <div class="w-full max-w-6xl overflow-hidden rounded-card bg-surface shadow-lift ring-1 ring-white/10"
                     style="max-height: 90vh;">
                    <div class="sticky top-0 z-10 flex justify-end bg-surface px-3 py-2">
                        <button
                            type="button"
                            @click="isOpen = false"
                            @keydown.escape.window="isOpen = false"
                            aria-label="Close image"
                            class="flex size-9 items-center justify-center rounded-full text-2xl leading-none text-muted transition duration-200 hover:bg-surface-2 hover:text-white"
                        >&times;</button>
                    </div>

                    <div class="px-4 pb-6 sm:px-8">
                        <img :src="image" alt="Enlarged still"
                             class="mx-auto block rounded-sm"
                             style="max-height: 70vh; width: auto; max-width: 100%;">
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
