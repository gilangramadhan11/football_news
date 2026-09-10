<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <title>

        {{ $seoTitle ?? 'Football News - Berita Sepak Bola Terbaru' }}

    </title>
    <meta
        name="description"
        content="{{ $seoDescription ?? 'Football News menyajikan berita sepak bola terbaru dari Liga Inggris, Liga Champions, Serie A, La Liga hingga Tim Nasional.' }}">
    <meta
        name="keywords"
        content="football, sepak bola, berita bola, premier league, liga inggris, champions league">
    <meta
        name="author"
        content="Football News">
    <meta
        name="theme-color"
        content="#2563eb">
    <meta property="og:type" content="article">
    <meta property="og:title"
        content="{{ $seoTitle ?? 'Football News' }}">

    <meta property="og:description"
        content="{{ $seoDescription ?? 'Football News menyajikan berita sepak bola terbaru.' }}">

    <meta property="og:url"
        content="{{ url()->current() }}">

    <meta property="og:site_name"
        content="Football News">

    <meta property="og:image"
        content="{{ $seoImage ?? asset('images/default-news.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title"
        content="{{ $seoTitle ?? 'Football News' }}">

    <meta name="twitter:description"
        content="{{ $seoDescription ?? 'Football News menyajikan berita sepak bola terbaru.' }}">

    <meta name="twitter:image"
        content="{{ $seoImage ?? asset('images/default-news.jpg') }}">
    <link rel="canonical" href="{{ url()->current() }}">
</head>

<body class="bg-gray-100">

<nav x-data="{ mobileOpen: false, scrolled: false }" 
     @scroll.window="scrolled = (window.scrollY > 20)"
     :class="scrolled ? 'bg-slate-900/95 backdrop-blur-md shadow-lg shadow-black/20' : 'bg-slate-900/70 backdrop-blur-sm'"
     class="fixed top-0 left-0 right-0 z-50 border-b border-slate-800/50 transition-all duration-300">

    <div class="mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2.5 shrink-0">
                <div class="relative">
                    <i class='bx bx-football text-3xl text-lime-400 drop-shadow-[0_0_10px_rgba(163,230,53,0.6)]'></i>
                </div>
                <span class="text-xl font-extrabold text-white tracking-tight">
                    Football<span class="text-lime-400">News</span>
                </span>
            </a>

            {{-- Menu Tengah (Desktop) --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="/" class="relative px-4 py-2 text-sm font-medium text-white hover:text-lime-400 transition group">
                    Beranda
                    <span class="absolute left-4 right-4 -bottom-0.5 h-0.5 bg-lime-400 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="/berita" class="relative px-4 py-2 text-sm font-medium text-slate-300 hover:text-lime-400 transition group">
                    Berita
                    <span class="absolute left-4 right-4 -bottom-0.5 h-0.5 bg-lime-400 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="/liga" class="relative px-4 py-2 text-sm font-medium text-slate-300 hover:text-lime-400 transition group">
                    Liga
                    <span class="absolute left-4 right-4 -bottom-0.5 h-0.5 bg-lime-400 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="/transfer" class="relative px-4 py-2 text-sm font-medium text-slate-300 hover:text-lime-400 transition group">
                    Transfer
                    <span class="absolute left-4 right-4 -bottom-0.5 h-0.5 bg-lime-400 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="/jadwal" class="relative px-4 py-2 text-sm font-medium text-slate-300 hover:text-lime-400 transition group">
                    Jadwal
                    <span class="absolute left-4 right-4 -bottom-0.5 h-0.5 bg-lime-400 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
            </div>

            {{-- Kanan: Search + CTA (Desktop) --}}
            <div class="hidden lg:flex items-center gap-3">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                        class="w-9 h-9 flex items-center justify-center rounded-full text-slate-300 hover:bg-slate-800 hover:text-lime-400 transition">
                        <i class='bx bx-search text-xl'></i>
                    </button>
                    <div x-show="open" x-transition
                         x-cloak
                         class="absolute right-0 mt-2 w-72 bg-slate-800 rounded-xl border border-slate-700 shadow-xl p-2">
                        <div class="relative">
                            <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500'></i>
                            <input type="text" placeholder="Cari berita..."
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg pl-9 pr-3 py-2 text-sm text-white placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-lime-500/40 focus:border-lime-500/50">
                        </div>
                    </div>
                </div>

                <a href="{{ route('login') }}"
                   class="flex items-center gap-2 bg-lime-500 text-slate-900 px-5 py-2 rounded-full text-sm font-semibold hover:bg-lime-400 hover:shadow-[0_0_20px_rgba(163,230,53,0.4)] transition-all duration-300">
                    <i class='bx bx-log-in-circle text-lg'></i>
                    Login
                </a>
            </div>

            {{-- Hamburger (Mobile) --}}
            <button @click="mobileOpen = !mobileOpen"
                class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg text-white hover:bg-slate-800 transition">
                <i class='bx text-2xl' :class="mobileOpen ? 'bx-x' : 'bx-menu'"></i>
            </button>

        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-transition x-cloak
         class="lg:hidden bg-slate-900 border-t border-slate-800 px-6 py-4 space-y-1">

        <div class="relative mb-3">
            <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500'></i>
            <input type="text" placeholder="Cari berita..."
                class="w-full bg-slate-800 border border-slate-700 rounded-lg pl-9 pr-3 py-2.5 text-sm text-white placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-lime-500/40">
        </div>

        <a href="/" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white bg-slate-800/60 font-medium text-sm">
            <i class='bx bx-home-alt text-lime-400'></i> Beranda
        </a>
        <a href="/berita" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 text-sm">
            <i class='bx bx-news'></i> Berita
        </a>
        <a href="/liga" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 text-sm">
            <i class='bx bx-trophy'></i> Liga
        </a>
        <a href="/transfer" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 text-sm">
            <i class='bx bx-transfer'></i> Transfer
        </a>
        <a href="/jadwal" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 text-sm">
            <i class='bx bx-calendar'></i> Jadwal
        </a>

        <a href="{{ route('login') }}"
           class="flex items-center justify-center gap-2 bg-lime-500 text-slate-900 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-lime-400 transition mt-3">
            <i class='bx bx-log-in-circle text-lg'></i>
            Login
        </a>
    </div>
</nav>

{{-- Spacer supaya konten di bawah navbar (fixed) nggak ketiban --}}
<div class="h-16"></div>
    <!-- @if($breakingNews->count())
    <div class="relative bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 text-white overflow-hidden shadow-lg shadow-slate-900/30">

        <div class="mx-auto flex items-stretch">

            {{-- Label kiri --}}
            <div class="relative flex items-center gap-2 bg-slate-900 px-5 py-3 font-bold whitespace-nowrap shrink-0 z-10">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                </span>
                <i class='bx bxs-bolt text-lime-400 text-lg'></i>
                <span class="text-sm tracking-wide">BREAKING</span>

                {{-- Segitiga pemisah --}}
                <div class="absolute -right-3 top-0 h-full w-3 bg-slate-900" style="clip-path: polygon(0 0, 100% 50%, 0 100%);"></div>
            </div>

            {{-- Marquee area --}}
            <div class="flex-1 overflow-hidden relative">
                <div class="breaking-track flex whitespace-nowrap animate-marquee">
                    @foreach($breakingNews as $news)
                        <a href="{{ route('article.show', $news->slug) }}"
                        class="inline-flex items-center gap-2 px-8 py-3 text-sm md:text-base font-medium hover:text-lime-300 transition-colors">
                            <i class='bx bxs-circle text-[6px] text-lime-300'></i>
                            {{ $news->title }}
                        </a>
                    @endforeach

                    {{-- Duplikat isi supaya loop marquee mulus tanpa jeda kosong --}}
                    @foreach($breakingNews as $news)
                        <a href="{{ route('article.show', $news->slug) }}"
                        class="inline-flex items-center gap-2 px-8 py-3 text-sm md:text-base font-medium hover:text-lime-300 transition-colors"
                        aria-hidden="true">
                            <i class='bx bxs-circle text-[6px] text-lime-300'></i>
                            {{ $news->title }}
                        </a>
                    @endforeach
                </div>

                {{-- Fade edge kanan biar transisi ke luar layar halus --}}
                <div class="absolute right-0 top-0 h-full w-12 bg-gradient-to-l from-slate-600 to-transparent pointer-events-none"></div>
            </div>
        </div>
    </div>
    @endif -->
<div class="mx-auto">

    @yield('content')

</div>

<footer class="bg-slate-900 text-white mt-16">

    <div class="max-w-7xl mx-auto py-6 text-center">

        © 2026 Football News

    </div>

</footer>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@stack('scripts')
</body>
</html>