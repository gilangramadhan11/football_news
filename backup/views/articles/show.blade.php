@extends('layouts.frontend')

@section('title', $article->title)

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ========================= --}}
    {{-- KONTEN --}}
    {{-- ========================= --}}
    <div class="lg:col-span-2">

        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-5">
            <a href="{{ route('home') }}" class="hover:text-blue-600">
                Home
            </a>

            <span class="mx-2">/</span>

            <span>{{ $article->category->name }}</span>
        </nav>

        {{-- Judul --}}
        <h1 class="text-5xl font-black leading-tight mt-4">

            {{ $article->title }}

        </h1>

        {{-- Meta --}}
        <div class="flex flex-wrap items-center gap-3 mt-5">

            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm">

                {{ $article->category->name }}

            </span>

            <span class="text-gray-500">

                📅

                {{ $article->published_at?->translatedFormat('d F Y') }}

            </span>

            <span class="text-gray-500">

                •

            </span>

            <span class="text-gray-500">

                ⏱

                {{ ceil(str_word_count(strip_tags($article->content))/200) }}

                menit membaca

            </span>

        </div>

        {{-- Thumbnail --}}
        @if($article->thumbnail)

        <img
            src="{{ asset('storage/'.$article->thumbnail) }}"
            class="mt-8 rounded-2xl w-full shadow-xl hover:scale-[1.01] transition duration-300">

        @endif

        {{-- Isi --}}
        <div class="bg-white rounded-2xl shadow p-8 mt-8">

            <article
                class="
                    prose prose-lg lg:prose-xl max-w-none
                    prose-headings:font-bold
                    prose-headings:text-slate-900
                    prose-p:text-slate-700
                    prose-a:text-blue-600
                    prose-img:rounded-xl
                "
            >
                {!! $article->content !!}
            </article>

        </div>
        <div class="mt-8 border-t pt-6">
        
                <button
                    type="button"
                    id="likeBtn"
                    data-url="{{ route('article.like', $article) }}"
                    @disabled($liked)
                    class="flex items-center gap-2 px-5 py-3 rounded-lg transition
                        {{ $liked
                            ? 'bg-gray-400 cursor-not-allowed'
                            : 'bg-red-500 hover:bg-red-600 text-white' }}">

                    <i class='bx bxs-heart'></i>

                    <span id="likeCount">{{ $article->likes }}</span>

                    {{ $liked ? 'Disukai' : 'Likes' }}
                </button>

        </div>

        <div class="mt-10 border-t pt-6">

            <h3 class="font-semibold text-lg mb-4">
                Bagikan Artikel
            </h3>

            @php
                $url = urlencode(request()->fullUrl());
                $title = urlencode($article->title);
            @endphp

            <div class="flex flex-wrap gap-3">

                <a
                    href="https://wa.me/?text={{ $title }}%20{{ $url }}"
                    target="_blank"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">

                    <i class='bx bxl-whatsapp text-xl'></i>

                    WhatsApp

                </a>

                <a
                    href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                    target="_blank"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">

                    <i class='bx bxl-facebook-circle text-xl'></i>

                    Facebook

                </a>

                <a
                    href="https://twitter.com/intent/tweet?text={{ $title }}&url={{ $url }}"
                    target="_blank"
                    class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2">

                    <i class='bx bxl-twitter text-xl'></i>

                    X

                </a>

                <a
                    href="https://t.me/share/url?url={{ $url }}&text={{ $title }}"
                    target="_blank"
                    class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">

                    <i class='bx bxl-telegram text-xl'></i>

                    Telegram

                </a>

                <button
                    id="copyLink"
                    class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2">

                    <i class='bx bx-copy text-xl'></i>

                    Copy Link

                </button>

            </div>

        </div>

        {{-- Artikel terkait --}}
        @if($relatedArticles->count())

        <div class="mt-12">

            <h2 class="text-3xl font-bold mb-6">

                Artikel Terkait

            </h2>

            <div class="grid md:grid-cols-3 gap-6">

                @foreach($relatedArticles as $related)

                <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-xl transition">

                    @if($related->thumbnail)

                        <img
                            src="{{ asset('storage/'.$related->thumbnail) }}"
                            class="w-full h-36 object-cover">

                    @endif

                    <div class="p-4">

                        <div class="text-xs text-blue-600 mb-2">

                            {{ $related->category->name }}

                        </div>

                        <a
                            href="{{ route('article.show',$related->slug) }}"
                            class="font-bold hover:text-blue-600">

                            {{ Str::limit($related->title,55) }}

                        </a>

                        <div class="text-xs text-gray-400 mt-3">

                            {{ $related->published_at?->diffForHumans() }}

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

        @endif

    </div>

    {{-- ========================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================= --}}
    <aside class="space-y-6">

        @include('partials.sidebar')

    </aside>

</div>
@push('scripts')
<script>
const likeBtn = document.getElementById('likeBtn');

console.log("Like JS Loaded", likeBtn);

if (likeBtn) {

    likeBtn.addEventListener('click', async function (e) {

        e.preventDefault();

        console.log("Button diklik");

        const response = await fetch(this.dataset.url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        console.log(response);

        const data = await response.json();

        console.log(data);

        document.getElementById('likeCount').innerText = data.likes;
        likeBtn.classList.remove(
            'bg-red-500',
            'hover:bg-red-600'
        );

        likeBtn.classList.add(
            'bg-gray-400',
            'cursor-not-allowed'
        );

        likeBtn.disabled = true;

        // Ganti teks
        likeBtn.innerHTML = `
            <i class='bx bxs-heart'></i>
            <span id="likeCount">${data.likes}</span>
            Disukai
        `;
    });

}
</script>
<script>

const copyBtn = document.getElementById('copyLink');

if(copyBtn){

    copyBtn.addEventListener('click', async ()=>{

        await navigator.clipboard.writeText(window.location.href);

        copyBtn.innerHTML = `
            <i class='bx bx-check text-xl'></i>
            Copied
        `;

        setTimeout(()=>{

            copyBtn.innerHTML = `
                <i class='bx bx-copy text-xl'></i>
                Copy Link
            `;

        },2000);

    });

}

</script>
@endpush
@endsection