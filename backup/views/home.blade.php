@extends('layouts.frontend')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ========================= --}}
    {{-- KONTEN UTAMA --}}
    {{-- ========================= --}}
    <div class="lg:col-span-2">

        {{-- Featured --}}
        @if($featured->count())

        <div class="swiper heroSwiper rounded-2xl overflow-hidden shadow-xl">

            <div class="swiper-wrapper">

                @foreach($featured as $featuredArticle)

                <div class="swiper-slide">

                    <div class="relative">

                        <img
                            src="{{ asset('storage/'.$featuredArticle->thumbnail) }}"
                            class="w-full h-[500px] object-cover">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/90 via-black-30 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 p-8 text-white">
                            <div class="flex items-center gap-2">
                                @if($loop->first)
                                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs mr-2">

                                       🔥 BREAKING

                                    </span>
                                @endif
                                <span class="bg-blue-600 px-3 py-1 rounded-full text-sm ">
                                    
                                    {{ $featuredArticle->category->name }}
                                    
                                </span>
                            </div>
                            <div class="flex items-center gap-4 mt-3 text-gray-200 text-sm">

                                <span>
                                    <i class='bx bx-calendar'></i>
                                    {{ $featuredArticle->published_at?->format('d M Y') }}
                                </span>

                                <span>
                                    <i class='bx bx-show'></i>
                                    {{ $featuredArticle->views }}
                                </span>

                            </div>
                            <h1 class="text-4xl font-bold mt-1">

                                {{ $featuredArticle->title }}

                            </h1>

                            <p class="mt-4 max-w-2xl">

                                {{ Str::limit(strip_tags($featuredArticle->content),180) }}

                            </p>

                            <a
                                href="{{ route('article.show',$featuredArticle->slug) }}"
                                class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 px-6 py-1 rounded-lg">

                                Baca Selengkapnya →

                            </a>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

            <div class="swiper-pagination"></div>

            <div class="swiper-button-next"></div>

            <div class="swiper-button-prev"></div>

        </div>

        @endif

        {{-- Search --}}
        @if(request('search'))

            <div class="mb-6">

                <h2 class="text-2xl font-bold">

                    Hasil pencarian:
                    "{{ request('search') }}"

                </h2>

            </div>

        @endif
        @php
            $mainArticle = $articles->first();
            $sideArticles = $articles->skip(1)->take(3);
            $gridArticles = $articles->skip(4);
        @endphp
        <h2 class="text-3xl font-bold mb-8">
            Berita Terbaru
        </h2>

        <div class="grid lg:grid-cols-3 gap-6 mb-10">

            {{-- Artikel Besar --}}
            <div class="lg:col-span-2">

                @if($mainArticle)

                <div class="bg-white rounded-xl overflow-hidden shadow">

                    @if($mainArticle->thumbnail)
                        <img
                            src="{{ asset('storage/'.$mainArticle->thumbnail) }}"
                            class="w-full h-[420px] object-cover">
                    @endif

                    <div class="p-6">

                        <span class="text-blue-600 font-semibold">

                            {{ $mainArticle->category->name }}

                        </span>

                        <h2 class="text-3xl font-bold mt-3">

                            <a href="{{ route('article.show',$mainArticle->slug) }}">

                                {{ $mainArticle->title }}

                            </a>

                        </h2>

                        <p class="text-gray-500 mt-4">

                            {{ Str::limit(strip_tags($mainArticle->content),150) }}

                        </p>

                    </div>

                </div>

                @endif

            </div>

            {{-- Artikel Kecil --}}
            <div class="space-y-5">

                @foreach($sideArticles as $article)

                <div class="flex gap-4 bg-white rounded-xl shadow p-3">

                    @if($article->thumbnail)
                        <img
                            src="{{ asset('storage/'.$article->thumbnail) }}"
                            class="w-28 h-24 rounded-lg object-cover">
                    @endif

                    <div>

                        <span class="text-xs text-blue-600">

                            {{ $article->category->name }}

                        </span>

                        <h3 class="font-bold mt-1">

                            <a href="{{ route('article.show',$article->slug) }}">

                                {{ Str::limit($article->title,60) }}

                            </a>

                        </h3>

                    </div>

                </div>

                @endforeach

            </div>

        </div>
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">

            @foreach($gridArticles as $article)

            <div class="bg-white rounded-xl shadow overflow-hidden">

                @if($article->thumbnail)

                    <img
                        src="{{ asset('storage/'.$article->thumbnail) }}"
                        class="w-full h-52 object-cover">

                @endif

                <div class="p-5">

                    <span class="text-sm text-blue-600">

                        {{ $article->category->name }}

                    </span>

                    <h3 class="text-xl font-bold mt-2">

                        <a href="{{ route('article.show',$article->slug) }}">

                            {{ $article->title }}

                        </a>

                    </h3>

                    <p class="text-gray-500 mt-3">

                        {{ Str::limit(strip_tags($article->content),80) }}

                    </p>

                </div>

            </div>

            @endforeach

        </div>

        <div class="mt-10">

            {{ $articles->links() }}

        </div>

    </div>

    {{-- ========================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================= --}}
    <aside class="space-y-6">
        @include('partials.sidebar')
    </aside>

</div>

@endsection