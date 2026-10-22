@extends('layouts.main')

@section('title', 'Movies — Movie App')
@section('description', 'Popular and now-playing films with ratings, release dates and genres.')

@section('content')
    <div class="mx-auto max-w-[1440px] px-5 lg:px-8">
        <header class="pt-14 pb-12 sm:pt-20">
            <p class="kicker">Catalogue</p>
            <h1 class="mt-3 font-display text-5xl leading-none tracking-tight text-white sm:text-6xl md:text-7xl">Movies</h1>
            <p class="mt-5 max-w-prose text-sm leading-relaxed text-muted">
                Popular and now-playing releases, kept current from TMDB.
            </p>
        </header>

        <section aria-labelledby="popular-movies">
            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-line/60 pb-5">
                <div>
                    <h2 id="popular-movies" class="font-display text-3xl leading-none text-white sm:text-4xl">Popular Movies</h2>
                    <p class="mt-2 text-xs text-muted-2">{{ $popularMovies->count() }} films</p>
                </div>
                <span class="kicker">Updated weekly</span>
            </div>

            <div class="stagger mt-9 grid grid-cols-2 gap-x-5 gap-y-10 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($popularMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </section>

        <section aria-labelledby="now-playing" class="mt-24">
            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-line/60 pb-5">
                <div>
                    <h2 id="now-playing" class="font-display text-3xl leading-none text-white sm:text-4xl">Now Playing</h2>
                    <p class="mt-2 text-xs text-muted-2">{{ $nowPlayingMovies->count() }} films</p>
                </div>
                <span class="kicker">In theatres</span>
            </div>

            <div class="stagger mt-9 grid grid-cols-2 gap-x-5 gap-y-10 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($nowPlayingMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </section>
    </div>
@endsection
