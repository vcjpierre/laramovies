<article class="group relative">
    <a href="{{ route('movies.show', $movie['id']) }}" class="block">
        <div class="relative aspect-[2/3] overflow-hidden rounded-card bg-surface ring-1 ring-white/6 transition duration-300 ease-out group-hover:-translate-y-1.5 group-hover:shadow-glow group-hover:ring-accent/30">
            <img src="{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }} poster" loading="lazy"
                 class="size-full object-cover transition duration-500 ease-out group-hover:scale-[1.04]">

            @if (! empty($movie['overview']))
                <div class="absolute inset-0 flex items-end bg-linear-to-t from-ink via-ink/70 to-transparent p-3 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <p class="line-clamp-3 text-[11px] leading-snug text-white/80">{{ $movie['overview'] }}</p>
                </div>
            @endif
        </div>
    </a>

    <div class="mt-3">
        <h3 class="font-display text-[17px] leading-tight text-white/95">
            <a href="{{ route('movies.show', $movie['id']) }}"
               class="transition-colors duration-200 hover:text-accent">{{ $movie['title'] }}</a>
        </h3>

        <div class="mt-1.5 flex items-center gap-2 text-[11px] text-muted-2">
            <span class="inline-flex items-center gap-1.5 font-medium tabular-nums text-accent">
                <span class="size-1 rounded-full bg-accent" aria-hidden="true"></span>{{ $movie['vote_average'] }}
            </span>
            <span class="h-2.5 w-px bg-line" aria-hidden="true"></span>
            <span class="tabular-nums">{{ $movie['release_date'] }}</span>
        </div>

        <p class="mt-1 line-clamp-1 text-[11px] text-muted-2">{{ $movie['genres'] }}</p>
    </div>
</article>
