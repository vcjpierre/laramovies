@extends('layouts.main')

@section('title', 'Actors — Movie App')
@section('description', 'Popular actors and the films and shows they are known for.')

@section('content')
    <div class="mx-auto max-w-[1440px] px-5 lg:px-8">
        <header class="pt-14 pb-12 sm:pt-20">
            <p class="kicker">People</p>
            <h1 class="mt-3 font-display text-5xl leading-none tracking-tight text-white sm:text-6xl md:text-7xl">Actors</h1>
            <p class="mt-5 max-w-prose text-sm leading-relaxed text-muted">
                Popular performers, with the work they are best known for.
            </p>
        </header>

        <section aria-labelledby="popular-actors">
            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-line/60 pb-5">
                <h2 id="popular-actors" class="font-display text-3xl leading-none text-white sm:text-4xl">Popular Actors</h2>
                <span class="kicker">Loads as you scroll</span>
            </div>

            <div class="stagger mt-9 grid grid-cols-2 gap-x-5 gap-y-10 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($popularActors as $actor)
                    <article class="actor group">
                        <a href="{{ route('actors.show', $actor['id']) }}" class="block">
                            <div class="relative aspect-[2/3] overflow-hidden rounded-card bg-surface ring-1 ring-white/6 transition duration-300 ease-out group-hover:-translate-y-1.5 group-hover:shadow-glow group-hover:ring-accent/30">
                                <img src="{{ $actor['profile_path'] }}" alt="{{ $actor['name'] }}" loading="lazy"
                                     class="size-full object-cover transition duration-500 ease-out group-hover:scale-[1.04]">
                            </div>
                        </a>

                        <h3 class="mt-3 truncate font-display text-[17px] leading-tight text-white/95">
                            <a href="{{ route('actors.show', $actor['id']) }}"
                               class="transition-colors duration-200 hover:text-accent">{{ $actor['name'] }}</a>
                        </h3>

                        <p class="mt-1 line-clamp-2 text-[11px] leading-snug text-muted-2">{{ $actor['known_for'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <div class="page-load-status py-12">
            <div class="flex justify-center">
                <div class="infinite-scroll-request spinner"></div>
            </div>
            <p class="infinite-scroll-last text-center text-xs text-muted-2">No more actors to load.</p>
            <p class="infinite-scroll-error text-center text-xs text-muted-2">Could not load more actors. Reload the page to try again.</p>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script>
    <script>
        var elem = document.querySelector('.grid');
        var infScroll = new InfiniteScroll(elem, {
            path: '/actors/page/@{{#}}',
            append: '.actor',
            status: '.page-load-status',
        });
    </script>
@endsection
