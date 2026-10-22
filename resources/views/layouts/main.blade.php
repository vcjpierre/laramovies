<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0a0b0d">
    <meta name="description" content="@yield('description', 'Browse popular and now-playing films, TV shows and actors.')">
    <title>@yield('title', 'Movie App')</title>

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Movie App">
    <meta property="og:title" content="@yield('title', 'Movie App')">
    <meta property="og:description" content="@yield('description', 'Browse popular and now-playing films, TV shows and actors.')">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://image.tmdb.org">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Outfit:wght@300..700&display=swap" rel="stylesheet">

    @vite('resources/css/main.css')
    @livewireStyles
</head>
<body class="grain flex min-h-dvh flex-col bg-ink font-sans text-white antialiased">
    <a href="#main"
       class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[70] focus:rounded-md focus:bg-accent focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-ink">
        Skip to content
    </a>

    @php
        $navLinks = [
            ['label' => 'Movies', 'route' => 'movies.index', 'active' => request()->routeIs('movies.*')],
            ['label' => 'TV Shows', 'route' => 'tv.index', 'active' => request()->routeIs('tv.*')],
            ['label' => 'Actors', 'route' => 'actors.index', 'active' => request()->routeIs('actors.*')],
        ];
    @endphp

    <header class="z-40 md:sticky md:top-0 border-b border-line/70 bg-ink/85 backdrop-blur-xl">
        <div class="mx-auto flex max-w-[1440px] flex-wrap items-center gap-x-8 gap-y-3 px-5 py-4 lg:px-8">
            <a href="{{ route('movies.index') }}"
               aria-label="Movie App — home"
               class="shrink-0 text-white/90 transition-colors duration-200 hover:text-accent">
                <svg class="h-6 w-auto" viewBox="0 0 96 24" fill="currentColor" aria-hidden="true"><path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4zM35.568 7.047l2.557 7.219 2.543-7.22h2.693V17h-2.057v-2.72l.205-4.697L38.822 17h-1.408l-2.68-7.41.206 4.69V17h-2.051V7.047h2.68zm9.147 6.186c0-.733.141-1.387.424-1.962a3.108 3.108 0 011.216-1.333c.534-.314 1.151-.471 1.853-.471.998 0 1.812.305 2.44.916.634.61.987 1.44 1.06 2.488l.014.506c0 1.135-.317 2.046-.95 2.734-.634.684-1.484 1.026-2.55 1.026-1.067 0-1.919-.342-2.557-1.026-.633-.683-.95-1.613-.95-2.789v-.089zm1.975.144c0 .702.133 1.24.397 1.613.264.37.642.554 1.135.554.478 0 .852-.182 1.12-.547.27-.37.404-.957.404-1.764 0-.688-.134-1.221-.403-1.6-.27-.377-.647-.567-1.135-.567-.483 0-.857.19-1.121.568-.264.373-.397.954-.397 1.743zm8.908 1.21l1.374-4.983h2.064L56.541 17h-1.887L52.16 9.604h2.065l1.374 4.983zM61.996 17h-1.982V9.604h1.982V17zm-2.099-9.31c0-.297.098-.54.294-.732.2-.191.472-.287.814-.287.337 0 .606.096.806.287.201.191.301.435.301.731 0 .301-.102.547-.307.739-.2.191-.467.287-.8.287s-.602-.096-.807-.287a.975.975 0 01-.3-.739zm7.137 9.447c-1.085 0-1.969-.333-2.652-.998-.68-.666-1.019-1.552-1.019-2.66v-.19c0-.744.144-1.407.43-1.99a3.143 3.143 0 011.218-1.354c.528-.319 1.13-.478 1.804-.478 1.012 0 1.807.319 2.386.957.584.638.875 1.543.875 2.714v.806h-4.71c.064.483.255.87.574 1.162.324.292.732.438 1.224.438.761 0 1.356-.276 1.784-.827l.97 1.087a2.99 2.99 0 01-1.202.984 3.98 3.98 0 01-1.682.349zm-.225-6.07c-.392 0-.711.132-.957.396-.242.264-.397.643-.465 1.135h2.748v-.158c-.01-.437-.128-.774-.356-1.011-.228-.242-.551-.363-.97-.363zm10.144 3.882h-3.596L72.674 17h-2.18l3.704-9.953h1.9L79.825 17h-2.18l-.69-2.05zm-3.042-1.66H76.4l-1.25-3.726-1.238 3.725zm13.043.081c0 1.14-.26 2.053-.78 2.741-.514.684-1.211 1.026-2.091 1.026-.747 0-1.351-.26-1.811-.78v3.487h-1.976V9.604h1.832l.068.724c.479-.574 1.103-.861 1.873-.861.912 0 1.62.337 2.126 1.011.506.675.76 1.605.76 2.79v.102zm-1.975-.143c0-.689-.123-1.22-.37-1.593-.241-.374-.594-.56-1.06-.56-.619 0-1.045.236-1.278.71v3.028c.242.488.673.732 1.293.732.943 0 1.415-.773 1.415-2.317zm9.864.143c0 1.14-.26 2.053-.78 2.741-.514.684-1.212 1.026-2.091 1.026-.748 0-1.352-.26-1.812-.78v3.487h-1.975V9.604h1.832l.068.724c.479-.574 1.103-.861 1.873-.861.912 0 1.62.337 2.126 1.011.506.675.759 1.605.759 2.79v.102zm-1.976-.143c0-.689-.123-1.22-.369-1.593-.242-.374-.595-.56-1.06-.56-.62 0-1.045.236-1.278.71v3.028c.242.488.672.732 1.292.732.944 0 1.415-.773 1.415-2.317z"/></svg>
            </a>

            <nav aria-label="Primary" class="order-3 -mx-1 w-full overflow-x-auto md:order-none md:mx-0 md:w-auto">
                <ul class="flex items-center gap-1">
                    @foreach ($navLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               @if ($link['active']) aria-current="page" @endif
                               class="block rounded-full px-3 py-1.5 text-sm whitespace-nowrap transition-colors duration-200 {{ $link['active'] ? 'bg-white/8 text-white' : 'text-muted hover:bg-white/5 hover:text-white' }}">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="ml-auto flex items-center gap-3">
                <livewire:search-dropdown />

                <a href="{{ route('actors.index') }}"
                   aria-label="Browse actors"
                   class="shrink-0 rounded-full ring-1 ring-white/10 transition duration-200 hover:ring-accent/60">
                    <img src="{{ url('img/avatar.jpg') }}" alt="Your profile" width="32" height="32"
                         class="size-8 rounded-full object-cover opacity-90 transition duration-200 hover:opacity-100">
                </a>
            </div>
        </div>
    </header>

    <main id="main" class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-24 border-t border-line/70 bg-ink-2">
        <div class="mx-auto flex max-w-[1440px] flex-col gap-5 px-5 py-10 text-sm text-muted-2 md:flex-row md:items-center md:justify-between lg:px-8">
            <p class="max-w-xl leading-relaxed">
                Film and show data from
                <a href="https://www.themoviedb.org/" class="text-muted underline decoration-line underline-offset-4 transition-colors duration-200 hover:text-accent hover:decoration-accent/50">TMDB</a>.
                This product uses the TMDB API but is not endorsed or certified by TMDB.
            </p>
            <nav aria-label="Footer" class="flex items-center gap-6">
                <a href="{{ route('movies.index') }}" class="transition-colors duration-200 hover:text-white">Movies</a>
                <a href="{{ route('tv.index') }}" class="transition-colors duration-200 hover:text-white">TV Shows</a>
                <a href="{{ route('actors.index') }}" class="transition-colors duration-200 hover:text-white">Actors</a>
            </nav>
        </div>
    </footer>

    @livewireScripts
    @yield('scripts')
</body>
</html>
