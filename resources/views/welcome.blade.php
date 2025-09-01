<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
     
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
    </head>
    <body class="bg-gray-50 dark:bg-[#0b0b0b] text-[#1b1b18] dark:text-[#EDEDEC]">

        {{-- Navbar (Flowbite) --}}
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

        {{-- Hero slider (Flowbite carousel) --}}
        <main class="max-w-7xl mx-auto px-4 py-8">
            <div id="hero-carousel" class="relative" data-carousel="slide">
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    @php
                        use App\Models\Berita;
                        $slides = Berita::with('penulis')->latest()->take(3)->get();
                    @endphp
                    @if($slides->isEmpty())
                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-800 dark:to-gray-700">
                            <div class="text-center">
                                <h3 class="text-2xl font-semibold">{{ config('app.name') }}</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Belum ada sorotan berita.</p>
                            </div>
                        </div>
                    @else
                        @foreach($slides as $idx => $s)
                            <div class="hidden duration-700 ease-in-out" data-carousel-item @if($loop->first) aria-current="true"@endif>
                                @if($s->gambar)
                                    <a href="{{ route('public.beritas.show', $s) }}">
                                        <img src="{{ asset('storage/' . $s->gambar) }}" class="absolute block w-full h-full object-cover" alt="{{ $s->judul }}" />
                                    </a>
                                @else
                                    <a href="{{ route('public.beritas.show', $s) }}" class="absolute inset-0 flex items-center justify-center bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700">
                                        <div class="text-center px-6">
                                            <h3 class="text-2xl font-semibold">{{ Str::limit($s->judul, 80) }}</h3>
                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($s->isi), 140) }}</p>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/70 dark:bg-gray-800/70">‹</span>
                </button>
                <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/70 dark:bg-gray-800/70">›</span>
                </button>
            </div>

            {{-- Berita section (cards) --}}
            <section class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Berita Terbaru</h2>
                    <a href="{{ route('public.beritas.index') }}" class="text-sm text-primary underline">Lihat semua</a>
                </div>

                @php
                    $recentBeritas = Berita::with('penulis')->latest()->paginate(6);
                @endphp

                @if($recentBeritas->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300">Belum ada berita.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($recentBeritas as $b)
                            <article class="bg-white dark:bg-gray-800 border rounded-lg overflow-hidden shadow-sm">
                                <div class="h-44 bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                    @if($b->gambar)
                                        <a href="{{ route('public.beritas.show', $b) }}">
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->judul }}" class="w-full h-full object-cover" />
                                        </a>
                                    @else
                                        <div class="p-6 text-center">
                                            <a href="{{ route('public.beritas.show', $b) }}"><img src="{{ asset('favicon.ico') }}" class="mx-auto w-12 h-12 opacity-40" alt="placeholder" /></a>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-medium text-lg mb-2"><a href="{{ route('public.beritas.show', $b) }}">{{ Str::limit($b->judul, 80) }}</a></h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ Str::limit(strip_tags($b->isi), 120) }}</p>
                                    <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">{{ $b->created_at->format('d M Y') }} · {{ $b->penulis->nama ?? 'Admin' }}</div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $recentBeritas->links() }}
                    </div>
                @endif
            </section>

            {{-- Footer --}}
            <footer class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
                © {{ date('Y') }} {{ config('app.name') }} — Semua hak dilindungi.
            </footer>
        </main>
    </body>
</html>
