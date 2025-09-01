<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ Str::limit($berita->judul, 70) }} - {{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Tailwind + Flowbite CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = { theme: { extend: { colors: { primary: '#F53003' } } } }
        </script>
        <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
    </head>
    <body class="bg-gray-50 dark:bg-[#0b0b0b] text-[#1b1b18] dark:text-[#EDEDEC]">

        {{-- Navbar (same as welcome) --}}
        <nav class="bg-white border-b dark:bg-gray-900 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center space-x-2">
                            <span class="text-xl font-semibold">{{ config('app.name') }}</span>
                        </a>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-md text-sm bg-primary text-white">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm border">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-sm bg-primary text-white">Register</a>
                            @endif
                        @endauth
                    </div>
                    <div class="md:hidden">
                        <button data-collapse-toggle="mobile-menu" type="button" class="inline-flex items-center p-2 text-sm rounded-lg" aria-controls="mobile-menu" aria-expanded="false">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5h14M3 10h14M3 15h14" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-md text-base">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <article class="lg:col-span-2 bg-white dark:bg-gray-800 border rounded-lg overflow-hidden shadow-sm">
                    @if($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-64 object-cover" />
                    @endif
                    <div class="p-6">
                        <h1 class="text-2xl font-semibold mb-2">{{ $berita->judul }}</h1>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $berita->created_at->format('d M Y') }} · {{ $berita->penulis->nama ?? 'Admin' }}</div>
                        <div class="prose max-w-none dark:prose-invert">{!! $berita->isi !!}</div>
                    </div>
                </article>

                <aside class="lg:col-span-1">
                    <div class="space-y-4">
                        <div class="p-4 bg-white dark:bg-gray-800 border rounded-lg">
                            <h3 class="font-medium mb-2">Berita Lainnya</h3>
                            <ul class="space-y-3">
                                @foreach($related as $r)
                                    <li class="flex items-start gap-3">
                                        <a href="{{ route('public.beritas.show', $r) }}" class="flex-shrink-0 w-16 h-12 overflow-hidden rounded-sm bg-gray-100 dark:bg-gray-700">
                                            @if($r->gambar)
                                                <img src="{{ asset('storage/' . $r->gambar) }}" alt="{{ $r->judul }}" class="w-full h-full object-cover" />
                                            @else
                                                <img src="{{ asset('favicon.ico') }}" class="w-full h-full object-contain p-2" alt="placeholder" />
                                            @endif
                                        </a>
                                        <div>
                                            <a href="{{ route('public.beritas.show', $r) }}" class="font-medium text-sm">{{ Str::limit($r->judul, 70) }}</a>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $r->created_at->format('d M Y') }}</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>

            {{-- Footer --}}
            <footer class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
                © {{ date('Y') }} {{ config('app.name') }} — Semua hak dilindungi.
            </footer>
        </main>
    </body>
</html>
