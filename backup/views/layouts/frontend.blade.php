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

<nav class="bg-slate-900 text-white sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-5 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="font-bold text-2xl">
            ⚽ Football News
        </a>
        <form action="{{ route('home') }}" method="GET" class="flex items-center">
            <input type="text" name="search" placeholder="Cari artikel..." value="{{ request('search') }}"
                   class="px-4 py-2 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg">
                Cari
            </button>
        </form>
    </div>
</nav>
@if($breakingNews->count())

<div class="bg-red-600 text-white overflow-hidden">

    <div class="max-w-7xl mx-auto flex">

        <div class="bg-red-700 px-5 py-3 font-bold whitespace-nowrap">

            ⚡ BREAKING NEWS

        </div>

        <div class="flex-1 overflow-hidden">

            <div class="breaking-track flex whitespace-nowrap">

                @foreach($breakingNews as $news)

                    <a
                        href="{{ route('article.show',$news->slug) }}"
                        class="inline-block px-10 py-3 hover:underline text-sm md:text-base">

                        {{ $news->title }}

                    </a>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endif

<div class="max-w-7xl mx-auto py-8 px-5">

    @yield('content')

</div>

<footer class="bg-slate-900 text-white mt-16">

    <div class="max-w-7xl mx-auto py-6 text-center">

        © 2026 Football News

    </div>

</footer>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@stack('scripts')
</body>
</html>