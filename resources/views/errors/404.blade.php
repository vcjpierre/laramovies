@extends('layouts.main')

@section('title', 'Page not found — Movie App')
@section('description', 'The page you were looking for does not exist.')

@section('content')
    <div class="mx-auto flex max-w-[1440px] flex-col items-start px-5 pt-20 pb-24 lg:px-8">
        <p class="kicker">404</p>
        <h1 class="mt-3 max-w-3xl font-display text-5xl leading-[0.95] tracking-tight text-white sm:text-6xl lg:text-7xl">
            This reel is missing
        </h1>
        <p class="mt-6 max-w-prose text-sm leading-relaxed text-muted">
            The page you asked for is not in the catalogue. It may have been moved, or the link was mistyped.
        </p>

        <div class="mt-10 flex flex-wrap items-center gap-4">
            <a href="{{ route('movies.index') }}"
               class="inline-flex items-center gap-2 rounded-full bg-accent px-6 py-3 text-sm font-semibold text-ink transition duration-200 ease-out hover:bg-accent-2 active:scale-[0.98]">
                Browse movies
            </a>
            <a href="{{ route('tv.index') }}"
               class="rounded-full px-4 py-3 text-sm text-muted transition-colors duration-200 hover:text-white">
                Browse TV shows
            </a>
        </div>
    </div>
@endsection
