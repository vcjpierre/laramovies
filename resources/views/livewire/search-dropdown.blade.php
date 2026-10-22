<div class="relative w-full sm:w-auto" x-data="{ isOpen: true }" @click.away="isOpen = false">
    <div class="relative">
        <svg class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
            <circle cx="11" cy="11" r="7"></circle>
            <path d="m20 20-3.6-3.6" stroke-linecap="round"></path>
        </svg>

        <input
            wire:model.live.debounce.500ms="search"
            type="text"
            placeholder="Search films and shows"
            aria-label="Search films and shows"
            class="w-full rounded-full border border-line/80 bg-surface/70 py-2 pr-10 pl-9 text-sm text-white transition duration-200 placeholder:text-muted-2 hover:border-line focus:border-accent/60 focus:bg-surface focus:outline-none sm:w-64"
            x-ref="search"
            @keydown.window="
                if (event.keyCode === 191) {
                    event.preventDefault();
                    $refs.search.focus();
                }
            "
            @focus="isOpen = true"
            @keydown="isOpen = true"
            @keydown.escape.window="isOpen = false"
            @keydown.shift.tab="isOpen = false"
        >

        <kbd class="pointer-events-none absolute top-1/2 right-2.5 hidden -translate-y-1/2 rounded border border-line bg-ink-2 px-1.5 py-0.5 font-sans text-[10px] font-medium text-muted-2 sm:block" aria-hidden="true">/</kbd>

        <div wire:loading class="spinner absolute top-1/2 right-9 -translate-y-1/2"></div>
    </div>

    @if (strlen($search) >= 2)
        <div
            x-show="isOpen"
            x-transition.opacity.duration.150ms
            class="absolute inset-x-0 top-full z-50 mt-2 overflow-hidden rounded-card border border-line/80 bg-surface-2/95 shadow-lift backdrop-blur-xl"
        >
            @if ($searchResults->count() > 0)
                <ul class="max-h-96 divide-y divide-line/60 overflow-y-auto">
                    @foreach ($searchResults as $result)
                        <li>
                            <a
                                href="{{ route('movies.show', $result['id']) }}"
                                class="flex items-center gap-3 px-3 py-2.5 transition-colors duration-150 hover:bg-white/5"
                                @if ($loop->last) @keydown.tab="isOpen = false" @endif
                            >
                                @if ($result['poster_path'])
                                    <img src="https://image.tmdb.org/t/p/w92/{{ $result['poster_path'] }}" alt=""
                                         width="32" height="48"
                                         class="h-12 w-8 shrink-0 rounded-sm object-cover ring-1 ring-white/10">
                                @else
                                    <div class="h-12 w-8 shrink-0 rounded-sm bg-surface ring-1 ring-white/10" aria-hidden="true"></div>
                                @endif

                                <span class="truncate text-sm text-white/90">{{ $result['title'] }}</span>

                                <svg class="ml-auto size-3.5 shrink-0 text-muted-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-4 py-6 text-center">
                    <p class="text-sm text-muted">No matches for <span class="text-white">"{{ $search }}"</span></p>
                    <p class="mt-1 text-xs text-muted-2">Try a different title.</p>
                </div>
            @endif
        </div>
    @endif
</div>
