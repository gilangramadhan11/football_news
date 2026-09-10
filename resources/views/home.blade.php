@extends('layouts.frontend')

@section('content')
    <div class="col-span-full">
        @if($featured->count())
        <div class="relative swiper heroSwiper overflow-hidden shadow-2xl shadow-black/40">
            <div class="swiper-wrapper">
                @foreach($featured as $featuredArticle)
                <div class="swiper-slide">
                    <div class="relative h-[500px] md:h-[650px] lg:h-[1000px]">
                        <img
                            src="{{ asset('storage/'.$featuredArticle->thumbnail) }}"
                            alt="{{ $featuredArticle->title }}"
                            class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/50 via-transparent to-transparent"></div>

                            <div class="absolute bottom-0 left-0 right-0 p-8 md:p-10 lg:p-14 text-white z-10">

                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($loop->first)
                                    <span class="flex items-center gap-1.5 bg-gradient-to-r from-red-600 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg shadow-red-900/40">
                                        <i class='bx bxs-hot text-sm'></i>
                                        Hot News
                                    </span>
                                    @endif

                                    <span class="bg-lime-500/15 backdrop-blur-sm border border-lime-400/30 text-lime-300 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $featuredArticle->category->name }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-4 mt-4 text-slate-300 text-sm">
                                    <span class="flex items-center gap-1.5">
                                        <i class='bx bx-calendar text-lime-400'></i>
                                        {{ $featuredArticle->published_at?->format('d M Y') }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <i class='bx bx-show text-lime-400'></i>
                                        {{ number_format($featuredArticle->views) }} views
                                    </span>
                                </div>

                                <h1 class="text-3xl md:text-3xl lg:text-4xl font-bold mt-3 leading-tight">
                                    {{ $featuredArticle->title }}
                                </h1>

                                <h3 class="mt-4 max-w-7xl text-slate-300 text-xl md:text-xl leading-relaxed">
                                    {{ Str::limit(strip_tags($featuredArticle->content), 240) }}
                                </h3>
                                <div class="flex items-center justify-between mt-6 flex-wrap gap-4">
                                    <a href="{{ route('article.show', $featuredArticle->slug) }}"
                                    class="group inline-flex items-center gap-2 mt-6 bg-lime-500 hover:bg-lime-400 text-slate-900 font-semibold px-6 py-2.5 rounded-full transition-all duration-300 shadow-[0_0_20px_rgba(163,230,53,0.3)] hover:shadow-[0_0_25px_rgba(163,230,53,0.5)]">
                                        Baca Selengkapnya
                                        <i class='bx bx-right-arrow-alt text-lg group-hover:translate-x-1 transition-transform'></i>
                                    </a>
                                    {{-- Arrow prev/next digabung di sini --}}
                                    <div class="flex items-center gap-2">
                                        <div class="swiper-button-prev-custom w-11 h-11 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white hover:bg-lime-500 hover:text-slate-900 hover:border-lime-400 transition-all duration-300 cursor-pointer">
                                            <i class='bx bx-chevron-left text-2xl'></i>
                                        </div>
                                        <div class="swiper-button-next-custom w-11 h-11 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white hover:bg-lime-500 hover:text-slate-900 hover:border-lime-400 transition-all duration-300 cursor-pointer">
                                            <i class='bx bx-chevron-right text-2xl'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- Pagination custom --}}
                <div class="swiper-pagination-custom absolute bottom-6 right-8 md:right-14 z-20 flex gap-2 justify-center"></div>
                @endif
            </div>
        </div>
    </div>
    <section class="bg-white mx-auto px-6 py-10 lg:px-20">
        <div class="flex items-center justify-between mb-9">
            <h2 class="text-4xl font-bold text-slate-700">
                Latest News
            </h2>
            <a href="{{ route('articles.index') }}"
            class="flex items-center gap-1 text-sm text-slate-500 hover:text-slate-900 transition">
                View more
                <i class="bx bx-chevron-right text-lg"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <article class="group">
                    <a href="{{ route('article.show', $recentArticles[0]->slug) }}"
                    class="block overflow-hidden rounded-2xl">
                        <img
                            src="{{ Storage::url($recentArticles[0]->thumbnail) }}"
                            alt="{{ $recentArticles[0]->title }}"
                            class="w-full h-[420px] object-cover
                                group-hover:scale-105 transition duration-500"
                        >
                    </a>
                    <div class="pt-5">
                        <span class="text-sm font-semibold text-lime-600">
                            {{ $recentArticles[0]->category->name }}
                        </span>
                        <h3 class="mt-2 text-3xl font-bold leading-tight text-slate-600">
                            <a href="{{ route('articles.show', $recentArticles[0]->slug) }}"
                            class="hover:text-slate-600 transition">
                                {{ $recentArticles[0]->title }}
                            </a>
                        </h3>
                        <p class="mt-3 text-slate-500 leading-relaxed">
                            {{ Str::words(strip_tags($recentArticles[0]->content), 30, '...') }}
                        </p>
                        <div class="flex items-center gap-3 mt-5 text-sm text-slate-500">
                            <span class="flex items-center gap-1.5">
                                <i class="bx bx-user"></i>
                                {{ $recentArticles[0]->user->name }}
                            </span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="flex items-center gap-1.5">
                                <i class="bx bx-time-five"></i>
                                {{ max(1, ceil(str_word_count(strip_tags($recentArticles[0]->content)) / 200)) }}
                                min read
                            </span>
                        </div>
                    </div>
                </article>
            </div>
            <div class="flex flex-col gap-7">
                @foreach($recentArticles->skip(1)->take(3) as $article)
                    <article class="group flex gap-4">
                        <a href="{{ route('article.show', $article->slug) }}"
                        class="w-64 h-42 shrink-0 overflow-hidden rounded-xl">
                            <img
                                src="{{ Storage::url($article->thumbnail) }}"
                                alt="{{ $article->title }}"
                                class="w-full h-full object-cover
                                    group-hover:scale-105 transition duration-500"
                            >
                        </a>
                        <div class="flex flex-col min-w-0">
                            <div class="flex items-center gap-3 text-sm text-slate-500">
                                <div
                                    class="w-10 h-10 rounded-full bg-slate-700 text-lime-400
                                        flex items-center justify-center
                                        font-semibold text-sm shrink-0"
                                >
                                    {{ collect(explode(' ', trim($article->user->name)))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn($name) => strtoupper(substr($name, 0, 1)))
                                        ->implode('') }}
                                </div>
                                <span class="flex items-center gap-1.5">
                                    <i class="bx bx-user"></i>
                                    {{ $article->user->name }}
                                </span>
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="flex items-center gap-1.5">
                                    {{ $article->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="mt-3 text-slate-900 leading-relaxed font-semibold">
                                {{ Str::words(strip_tags($article->content), 15, '...') }}
                            </p>
                            <div class="mt-auto pt-2">
                                <span class="flex items-center gap-1 text-xs text-slate-500">
                                    <i class="bx bx-time-five"></i>
                                    {{ max(1, ceil(str_word_count(strip_tags($article->content)) / 200)) }}
                                    min read
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    <section class="bg-gray-50 mx-auto px-6 py-10 lg:px-20">
        <div class="flex items-center justify-between mb-9">
            <h2 class="text-4xl font-bold text-slate-700">
                Football match score
            </h2>
            <a href="{{ route('categories.index') }}"
            class="flex items-center gap-1 text-sm text-slate-500 hover:text-slate-900 transition">
                View more
                <i class="bx bx-chevron-right text-lg"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-3">
            @foreach($weekFixtures as $date => $leagues)
                @foreach($leagues as $leagueName => $matches)
                    @foreach($matches as $match)
                        <div class="max-w-md bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                                
                        {{-- Header liga --}}
                        <div class="flex items-center justify-between bg-gray-900 px-5 py-3">
                            <div class="flex items-center gap-2">
                                <img src="{{ $matches[0]['league']['logo'] }}" alt="{{ $matches[0]['league']['name'] }}" class="w-5 h-5 object-contain">
                                <span class="text-white text-xs font-bold">{{ $matches[0]['league']['name'] }}</span>
                            </div>
                            <span class="text-gray-400 text-[11px] font-medium">
                                {{ \Carbon\Carbon::parse($matches[0]['fixture']['date'])->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        
                        {{-- Status badge --}}
                        <div class="flex justify-center pt-4">
                            <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide">
                                <i class='bx bxs-check-circle text-emerald-500'></i>
                                Full Time
                            </span>
                        </div>
                        
                        {{-- Skor utama --}}
                        <div class="flex items-center justify-between px-6 py-6">
                            
                            {{-- Home team --}}
                            <div class="flex flex-col items-center gap-2 flex-1">
                                <img src="{{ $match['teams']['home']['logo'] }}" alt="{{ $match['teams']['home']['name'] }}"
                                class="w-14 h-14 object-contain">
                                <span class="text-sm font-bold text-gray-900 text-center leading-tight">
                                    {{ $match['teams']['home']['name'] }}
                                </span>
                            </div>
                            
                            {{-- Skor --}}
                            <div class="flex items-center gap-3 px-4 shrink-0">
                                <span class="text-4xl font-extrabold {{ $match['teams']['home']['winner'] ? 'text-slate-900' : 'text-gray-300' }}">
                                    {{ $match ['goals']['home'] }}
                                </span>
                                <span class="text-2xl font-light text-gray-200">:</span>
                                <span class="text-4xl font-extrabold {{ $match['teams']['away']['winner'] ? 'text-slate-900' : 'text-gray-300' }}">
                                    {{ $match['goals']['away'] }}
                                </span>
                                </div>

                                {{-- Away team --}}
                                <div class="flex flex-col items-center gap-2 flex-1">
                                    <img src="{{ $match['teams']['away']['logo'] }}" alt="{{ $match['teams']['away']['name'] }}"
                                        class="w-14 h-14 object-contain">
                                    <span class="text-sm font-bold text-gray-900 text-center leading-tight">
                                        {{ $match['teams']['away']['name'] }}
                                    </span>
                                </div>

                            </div>

                            {{-- Info tambahan: venue --}}
                            <div class="flex items-center justify-center gap-1.5 pb-4 text-gray-400 text-xs">
                                <i class='bx bx-map'></i>
                                {{ $match['fixture']['venue']['name'] ?? '-' }}
                            </div>

                            {{-- Footer CTA --}}
                            <a href="#" class="flex items-center justify-center gap-1.5 bg-gray-50 hover:bg-indigo-50 text-gray-600 hover:text-indigo-600 py-3 text-sm font-semibold border-t border-gray-100 transition-colors group">
                                Lihat Detail Pertandingan
                                <i class='bx bx-right-arrow-alt text-lg group-hover:translate-x-1 transition-transform'></i>
                            </a>
                        </div>
                    @endforeach
                @endforeach
            @endforeach
        </div>
    </section>
    <section class="bg-white mx-auto px-6 py-10 lg:px-20">
        <div class="flex items-center justify-between mb-9">
            <h2 class="text-4xl font-bold text-slate-700">
                Populer
            </h2>
            <a href="{{ route('articles.index') }}"
            class="flex items-center gap-1 text-sm text-slate-500 hover:text-slate-900 transition">
                View more
                <i class="bx bx-chevron-right text-lg"></i>
            </a>
        </div>
            
            @if($popularArticles)
            <a href="{{ route('article.show', $popularArticles->slug) }}"
            class="group relative block rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-[420px] md:h-[480px] lg:h-[650px] mb-6">
                <img src="{{ asset('storage/'.$popularArticles->thumbnail) }}" alt="{{ $popularArticles->title }}"
                    class="w-full h-[1000px] object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
                    <h3 class="text-gray-100 text-2xl md:text-4xl font-semibold leading-tight transition-colors">
                        {{ $popularArticles->title }}
                    </h3>

                    <p class="hidden md:block text-slate-300 text-xl mt-5 line-clamp-2">
                        {{ Str::words(strip_tags($popularArticles->content), 45, '...') }}
                    </p>

                    <div class="flex items-center gap-3 text-sm text-slate-500 mt-5">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-700 text-lime-400
                                flex items-center justify-center
                                font-semibold text-sm shrink-0"
                        >
                            {{ collect(explode(' ', trim($popularArticles->user->name)))
                                ->filter()
                                ->take(2)
                                ->map(fn($name) => strtoupper(substr($name, 0, 1)))
                                ->implode('') }}
                        </div>
                        <span class="flex items-center gap-1.5 text-2xl text-gray-200">
                            {{ $popularArticles->user->name }}
                        </span>
                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                        <span class="flex items-center gap-1.5 text-gray-200">
                            {{ $popularArticles->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </a>
            @endif
            {{-- 4 Artikel ranked, format list (bukan card) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-3">
                @foreach($trending->skip(1)->take(4) as $index => $news)
                <a href="{{ route('article.show', $news->slug) }}"
                    class="group relative block overflow-hidden transition-all duration-300 mb-6">
                    <div>
                        <img   
                            src="{{ asset('storage/'.$news->thumbnail) }}" alt="{{ $news->title }}"
                            class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-700 rounded-2xl">
                    </div>
                    <div class="mt-1.5">
                        <h3 class="text-xl font-bold text-gray-900 transition-colors line-clamp-2 min-h-[56px]">
                            {{ $news->title }}
                        </h3>
                        <p class="hidden md:block text-gray-600 text-lg mt-3 line-clamp-2">
                            {{ Str::words(strip_tags($news->content), 10, '...') }}
                        </p>
                        <div class="flex items-center gap-3 text-sm text-slate-500 mt-5 line-clamp-2 min-h-[56px]">
                            <div
                                class="w-10 h-10 rounded-full bg-slate-700 text-lime-400
                                    flex items-center justify-center
                                    font-semibold text-sm shrink-0"
                            >
                                {{ collect(explode(' ', trim($news->user->name)))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn($name) => strtoupper(substr($name, 0, 1)))
                                    ->implode('') }}
                            </div>
                            <span class="flex items-center gap-1.5 text-2xl text-gray-800">
                                {{ $news->user->name }}
                            </span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="flex items-center gap-1.5 text-gray-800">
                                {{ $news->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>    
                </a>
                @endforeach
            </div>

            {{-- Tombol "Lihat Semua" versi mobile --}}
            <div class="flex md:hidden justify-center mt-8">
                <a href="{{ route('articles.index', ['sort' => 'popular']) }}"
                class="flex items-center gap-1.5 bg-indigo-600 text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-indigo-700 transition">
                    Lihat Semua Trending
                    <i class='bx bx-right-arrow-alt text-lg'></i>
                </a>
            </div>
    </section>
    <section class="bg-white mx-auto px-6 py-10 lg:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-4xl font-bold text-slate-700">
                            La Liga Standings
                        </h2>
                    </div>

                    <a href="#" class="flex items-center gap-1 text-sm text-slate-500 hover:text-slate-900 transition">
                        View more
                        <i class='bx bx-right-arrow-alt text-lg group-hover:translate-x-1 transition-transform'></i>
                    </a>
                </div>

                @if(empty($standings))
                {{-- Fallback kalau API gagal/limit habis --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center">
                    <i class='bx bx-error-circle text-4xl text-gray-300'></i>
                    <p class="text-gray-500 text-sm mt-2">Data klasemen sedang tidak tersedia.</p>
                </div>
                @else

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-900 text-white">
                                <th class="p-4 text-center font-semibold w-12">#</th>
                                <th class="p-4 text-left font-semibold">Klub</th>
                                <th class="p-4 text-center font-semibold">M</th>
                                <th class="p-4 text-center font-semibold">M</th>
                                <th class="p-4 text-center font-semibold">S</th>
                                <th class="p-4 text-center font-semibold">K</th>
                                <th class="p-4 text-center font-semibold hidden md:table-cell">SG</th>
                                <th class="p-4 text-center font-semibold text-lime-400">Poin</th>
                                <th class="p-4 text-center font-semibold hidden lg:table-cell">5 Laga</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach($standings as $team)
                            @php
                                $rank = $team['rank'];
                                // Zona warna: 1-4 UCL (indigo), 5 UEL (sky), degradasi 18-20 (merah)
                                $zoneColor = match(true) {
                                    $rank <= 4 => 'bg-indigo-500',
                                    $rank === 5 => 'bg-sky-500',
                                    $rank >= 18 => 'bg-red-500',
                                    default => 'bg-transparent',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-center relative">
                                    <span class="absolute left-0 top-0 h-full w-1 {{ $zoneColor }}"></span>
                                    <span class="font-bold text-gray-700">{{ $rank }}</span>
                                </td>

                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $team['team']['logo'] }}" alt="{{ $team['team']['name'] }}" class="w-6 h-6 object-contain">
                                        <span class="font-semibold text-gray-900">{{ $team['team']['name'] }}</span>
                                    </div>
                                </td>

                                <td class="p-4 text-center text-gray-600">{{ $team['all']['played'] }}</td>
                                <td class="p-4 text-center text-gray-600">{{ $team['all']['win'] }}</td>
                                <td class="p-4 text-center text-gray-600">{{ $team['all']['draw'] }}</td>
                                <td class="p-4 text-center text-gray-600">{{ $team['all']['lose'] }}</td>
                                <td class="p-4 text-center text-gray-600 hidden md:table-cell">{{ $team['goalsDiff'] }}</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-lime-100 text-lime-700 font-extrabold">
                                        {{ $team['points'] }}
                                    </span>
                                </td>
                                <td class="p-4 hidden lg:table-cell">
                                    <div class="flex items-center justify-center gap-1">
                                        @foreach(str_split($team['form'] ?? '') as $result)
                                            <span class="w-5 h-5 flex items-center justify-center rounded text-[10px] font-bold text-white
                                                {{ $result === 'W' ? 'bg-emerald-500' : ($result === 'D' ? 'bg-gray-400' : 'bg-red-500') }}">
                                                {{ $result }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Legend zona --}}
                    <div class="flex flex-wrap items-center gap-4 px-5 py-4 bg-gray-50 border-t border-gray-100 text-xs text-gray-500">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span> Liga Champions</span>
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> Liga Europa</span>
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Degradasi</span>
                    </div>
                </div>
                @endif

            </div>
            <div class="flex flex-col gap-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-4xl font-bold text-slate-700">
                            La Liga Leaders
                        </h2>
                    </div>

                    <a href="#" class="flex items-center gap-1 text-sm text-slate-500 hover:text-slate-900 transition">
                        View more
                        <i class='bx bx-right-arrow-alt text-lg group-hover:translate-x-1 transition-transform'></i>
                    </a>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-900 text-white">
                                <th class="p-4 text-center font-semibold w-14">#</th>
                                <th class="p-4 text-left font-semibold">Pemain</th>
                                <th class="p-4 text-left font-semibold hidden md:table-cell">Klub</th>
                                <th class="p-4 text-center font-semibold">Main</th>
                                <th class="p-4 text-center font-semibold hidden sm:table-cell">Assist</th>
                                <th class="p-4 text-center font-semibold text-lime-400">Gol</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach($topScorers as $player)
                            @php
                                $rankStyle = match($player['rank']) {
                                    1 => ['bg' => 'bg-yellow-400', 'text' => 'text-gray-900', 'icon' => 'bxs-star', 'iconColor' => 'text-gray-900'],
                                    2 => ['bg' => 'bg-gray-300', 'text' => 'text-gray-900', 'icon' => 'bxs-star', 'iconColor' => 'text-gray-900'],
                                    3 => ['bg' => 'bg-yellow-700', 'text' => 'text-white', 'icon' => 'bxs-star', 'iconColor' => 'text-gray-900'],
                                    default => ['bg' => 'bg-transparent', 'text' => 'text-gray-700', 'icon' => null, 'iconColor' => null],
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition">

                                {{-- Ranking --}}
                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center justify-center w-9 h-9 rounded-full {{ $rankStyle['bg'] }} {{ $rankStyle['text'] }} font-extrabold text-sm relative">
                                        @if($rankStyle['icon'])
                                            <i class='bx {{ $rankStyle['icon'] }} absolute -top-2 {{ $rankStyle['iconColor'] }} text-sm'></i>
                                        @endif
                                        {{ $player['rank'] }}
                                    </div>
                                </td>

                                {{-- Pemain --}}
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $player['player']['photo'] }}" alt="{{ $player['player']['name'] }}"
                                            class="w- h-10 rounded-full object-cover bg-gray-100 border border-gray-200 shrink-0">
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-900 truncate">{{ $player['player']['name'] }}</p>
                                            <p class="text-xs text-gray-400 md:hidden">{{ $player['statistics'][0]['team']['name'] }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Klub (desktop) --}}
                                <td class="p-4 hidden md:table-cell">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $player['statistics'][0]['team']['logo'] }}" alt="{{ $player['statistics'][0]['team']['name'] }}" class="w-5 h-5 object-contain">
                                        <span class="text-gray-600 text-sm">{{ $player['statistics'][0]['team']['name'] }}</span>
                                    </div>
                                </td>

                                <td class="p-4 text-center text-gray-500">{{ $player['statistics'][0]['games']['appearences'] }}</td>
                                <td class="p-4 text-center text-gray-500 hidden sm:table-cell">{{ $player['statistics'][0]['goals']['assists'] }}</td>

                                {{-- Gol --}}
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[36px] h-9 px-2 rounded-lg bg-lime-100 text-lime-700 font-extrabold">
                                        {{ $player['statistics'][0]['goals']['total'] }}
                                    </span>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-4xl font-bold text-slate-700">
                            La Liga Top Assists
                        </h2>
                    </div>

                    <a href="#" class="flex items-center gap-1 text-sm text-slate-500 hover:text-slate-900 transition">
                        View more
                        <i class='bx bx-right-arrow-alt text-lg group-hover:translate-x-1 transition-transform'></i>
                    </a>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-900 text-white">
                                <th class="p-4 text-center font-semibold w-14">#</th>
                                <th class="p-4 text-left font-semibold">Pemain</th>
                                <th class="p-4 text-left font-semibold hidden md:table-cell">Klub</th>
                                <th class="p-4 text-center font-semibold">Main</th>
                                <th class="p-4 text-center font-semibold hidden sm:table-cell">Pass</th>
                                <th class="p-4 text-center font-semibold text-lime-400">Assists</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach($topAssists as $player)
                            @php
                                $rankStyle = match($player['rank']) {
                                    1 => ['bg' => 'bg-yellow-400', 'text' => 'text-gray-900', 'icon' => 'bxs-star', 'iconColor' => 'text-gray-900'],
                                    2 => ['bg' => 'bg-gray-300', 'text' => 'text-gray-900', 'icon' => 'bxs-star', 'iconColor' => 'text-gray-900'],
                                    3 => ['bg' => 'bg-yellow-700', 'text' => 'text-white', 'icon' => 'bxs-star', 'iconColor' => 'text-gray-900'],
                                    default => ['bg' => 'bg-transparent', 'text' => 'text-gray-700', 'icon' => null, 'iconColor' => null],
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition">

                                {{-- Ranking --}}
                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center justify-center w-9 h-9 rounded-full {{ $rankStyle['bg'] }} {{ $rankStyle['text'] }} font-extrabold text-sm relative">
                                        @if($rankStyle['icon'])
                                            <i class='bx {{ $rankStyle['icon'] }} absolute -top-2 {{ $rankStyle['iconColor'] }} text-sm'></i>
                                        @endif
                                        {{ $player['rank'] }}
                                    </div>
                                </td>

                                {{-- Pemain --}}
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $player['player']['photo'] }}" alt="{{ $player['player']['name'] }}"
                                            class="w- h-10 rounded-full object-cover bg-gray-100 border border-gray-200 shrink-0">
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-900 truncate">{{ $player['player']['name'] }}</p>
                                            <p class="text-xs text-gray-400 md:hidden">{{ $player['statistics'][0]['team']['name'] }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Klub (desktop) --}}
                                <td class="p-4 hidden md:table-cell">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $player['statistics'][0]['team']['logo'] }}" alt="{{ $player['statistics'][0]['team']['name'] }}" class="w-5 h-5 object-contain">
                                        <span class="text-gray-600 text-sm">{{ $player['statistics'][0]['team']['name'] }}</span>
                                    </div>
                                </td>

                                <td class="p-4 text-center text-gray-500">{{ $player['statistics'][0]['games']['appearences'] }}</td>
                                <td class="p-4 text-center text-gray-500 hidden sm:table-cell">{{ $player['statistics'][0]['passes']['total'] }}</td>

                                {{-- Assists --}}
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[36px] h-9 px-2 rounded-lg bg-lime-100 text-lime-700 font-extrabold">
                                        {{ $player['statistics'][0]['goals']['assists'] }}
                                    </span>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                {{-- Tombol mobile --}}
                <div class="flex md:hidden justify-center mt-6">
                    <a href="#" class="flex items-center gap-1.5 bg-indigo-600 text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-indigo-700 transition">
                        Lihat Semua Top Scorer
                        <i class='bx bx-right-arrow-alt text-lg'></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection