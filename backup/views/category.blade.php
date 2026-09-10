@extends('layouts.frontend')

@section('title', $category->name)

@section('content')
<nav class="text-sm text-gray-500 mb-5">

    <a href="{{ route('home') }}" class="hover:text-blue-600">

        Home

    </a>

    <span class="mx-2">/</span>

    <span>{{ $category->name }}</span>

</nav>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- Konten --}}
    <div class="lg:col-span-2">

        <div class="mb-8">

            <h1 class="text-4xl font-bold">

                {{ $category->name }}

            </h1>

            <p class="text-gray-500 mt-2">

                {{ $articles->total() }} artikel ditemukan.

            </p>

        </div>

        <div class="grid md:grid-cols-2 gap-8">

            @forelse($articles as $article)

                <div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden">

                    @if($article->thumbnail)

                        <img
                            src="{{ asset('storage/'.$article->thumbnail) }}"
                            class="w-full h-56 object-cover">

                    @endif

                    <div class="p-5">

                        <span class="text-blue-600 text-sm">

                            {{ $article->category->name }}

                        </span>

                        <h2 class="font-bold text-xl mt-2">

                            <a href="{{ route('article.show',$article->slug) }}">

                                {{ $article->title }}

                            </a>

                        </h2>

                        <p class="text-gray-500 mt-3">

                            {{ Str::limit(strip_tags($article->content),90) }}

                        </p>

                    </div>

                </div>

            @empty

                <div class="col-span-2 bg-white rounded-xl shadow p-10 text-center">

                    Belum ada artikel pada kategori ini.

                </div>

            @endforelse

        </div>

        <div class="mt-8">

            {{ $articles->links() }}

        </div>

    </div>

    {{-- Sidebar --}}
    <aside class="space-y-6">

        @include('partials.sidebar')

    </aside>

</div>

@endsection