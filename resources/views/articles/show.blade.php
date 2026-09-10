@extends('layouts.frontend')

@section('title', $article->title)

@section('content')

<div class="grid grid-cols-1 bg-white lg:grid-cols-4 gap-8 items-stretch">
    <div class="mx-auto w-full px-4 pt-10 sm:max-w-xl sm:px-6 md:max-w-3xl lg:col-span-3 lg:max-w-7xl">
        <nav class="flex items-center flex-wrap gap-2 text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="flex items-center gap-1.5 hover:text-indigo-600 transition-colors">
                <i class='bx bx-home-alt text-base'></i>
                Home
            </a>
            <i class='bx bx-chevron-right text-gray-300'></i>
            <a href="{{ route('articles.index', ['category' => $article->category->id]) }}"
            class="hover:text-indigo-600 transition-colors">
                {{ $article->category->name }}
            </a>
            <i class='bx bx-chevron-right text-gray-300'></i>
            <span class="text-gray-400 truncate max-w-[200px] md:max-w-xs" title="{{ $article->title }}">
                {{ Str::limit($article->title, 40) }}
            </span>
        </nav>
        <h1 class="text-5xl text-slate-700 font-bold leading-tight mt-4">
            {{ $article->title }}
        </h1>
        <div class="flex flex-wrap items-center gap-3 mt-5">
            <div class="flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full text-sm">
                <div class="text-sm text-slate-700 font-semibold">
                    {{ $article->user->name }}
                </div>
            </div>
            <span class="bg-gray-100 text-slate-700 font-semibold px-3 py-1 rounded-full text-sm">
                {{ $article->category->name }}
            </span>
            <span class="inline-flex items-center gap-1 bg-gray-100 text-slate-700 px-3 py-1 rounded-full text-sm font-semibold">
                {{ $article->published_at?->translatedFormat('d F Y') }}
            </span>
            <span>
                •
            </span>
            <span class="inline-flex items-center gap-1 bg-gray-100 text-slate-700 px-3 py-1 rounded-full text-sm font-semibold">
                {{ ceil(str_word_count(strip_tags($article->content))/200) }}
                menit membaca
            </span>
            <button
                    type="button"
                    id="likeBtn"
                    data-url="{{ route('article.like', $article) }}"
                    @disabled($liked)
                    class="inline-flex ml-auto gap-1 transition text-black 
                        {{ $liked
                            ? 'cursor-not-allowed'
                            : 'hover:text-red-600 text-slate-800' }}">

                    <i 
                        class='bx bxs-heart text-xl text-white'
                        style="-webkit-text-stroke: 1.5px black;"></i>
            </button>
        </div>

        @if($article->thumbnail)

        <img
            src="{{ asset('storage/'.$article->thumbnail) }}"
            class="mt-8 rounded-4xl w-full shadow-xl hover:scale-[1.01] transition duration-300">

        @endif

        {{-- Isi --}}
        <div class="bg-white rounded-2xl mt-8">

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
        <!-- <div class="mt-8 border-t pt-6">
        
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

        </div> -->

        {{-- Artikel terkait --}}
        @if($relatedArticles->count())
        <div class="mt-12 mb-6">
            <h2 class="text-3xl font-bold mb-6">
                Artikel Terkait
            </h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($relatedArticles as $related)
                <div class="bg-white rounded-xl transition6">
                    @if($related->thumbnail)
                        <img
                            src="{{ asset('storage/'.$related->thumbnail) }}"
                            class="w-full h-36 object-cover rounded-2xl">
                    @endif
                    <div class="py-4">
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
    <aside class="h-full bg-gray-50 rounded-4xl space-y-6 p-10 lg:col-span-1">

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
            'hover:bg-red-600'
        );

        likeBtn.classList.add(
            'text-red-600',
            'cursor-not-allowed'
        );

        likeBtn.disabled = true;

        // Ganti teks
        likeBtn.innerHTML = `
            <i class='bx bxs-heart text-red-600'></i>
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