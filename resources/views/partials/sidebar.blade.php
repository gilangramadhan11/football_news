{{-- Kategori --}}
<div class="rounded-xl">
   <h3 class="text-lg font-semibold text-slate-700 mb-2">  
        Share on Social Media
    </h3>
   <div class="flex gap-3 flex-wrap pb-4">
        <a href="https://www.instagram.com/" target="_blank" class="bg-white text-slate-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <i class="bx bxl-instagram text-2xl"></i>
        </a>
       <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="bg-white text-slate-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <i class="bx bxl-facebook-circle text-slate-700 text-2xl"></i>
        </a>
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode('Check this out!') }}" target="_blank" class="bg-white text-slate-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <i class="bx bxl-twitter text-2xl"></i>
        </a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode('Check this out!') }}" target="_blank" class="bg-white text-slate-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <i class="bx bxl-linkedin text-2xl"></i>
        </a>
        <a href="https://www.whatsapp.com/send?text={{ urlencode('Check this out!') }}%20{{ urlencode(request()->fullUrl()) }}" target="_blank" class="bg-white text-slate-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <i class="bx bxl-whatsapp text-2xl"></i>
        </a>
        <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode('Check this out!') }}" target="_blank" class="bg-white text-slate-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <i class="bx bxl-telegram text-2xl"></i>
        </a>
    </div>
    <h3 class="text-lg font-semibold text-slate-700 mb-2 mt-6">All Tags</h3>
    <div class="flex gap-3 flex-wrap pb-4">
        @foreach($categories as $tag)
        <a href="{{ route('articles.index', ['category' => $tag->id]) }}" class="bg-white text-slate-700 px-4 py-2 rounded-lg font-mono font-semibold hover:bg-gray-100 transition-colors duration-200">
            {{ $tag->name }}
        </a>
        @endforeach
    </div>
    <h3 class="text-lg font-semibold text-slate-700 mb-2 mt-6">Breaking News</h3>
    <div class="flex flex-col items-start gap-4">
        @foreach($breakingNews->take(3) as $relatedArticle)
        <a href="{{ route('articles.show', $relatedArticle) }}" class="flex items-start gap-3 rounded-lg pb-5 transition-shadow duration-200">
            @if($relatedArticle->thumbnail)
            <img src="{{ asset('storage/'.$relatedArticle->thumbnail) }}" alt="{{ $relatedArticle->title }}" class="w-42 h-24 object-cover rounded-2xl">
            @else
            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                <i class="bx bx-image text-2xl"></i>
            </div>
            @endif
            <div class="flex flex-col justify-start">
                <span class="text-sm text-slate-500 font-semibold">
                    {{ $relatedArticle->published_at?->translatedFormat('d F Y') }}
                </span>
                <span class="mt-4 text-lg font-bold text-slate-700 line-clamp-2" title="{{ $relatedArticle->title }}">
                    {{ Str::limit($relatedArticle->title, 100) }}
                </span>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mx-auto p-6 sm:px-6 lg:px-8">
        <hr class="border-slate-200">
    </div>
    <div class="mx-auto text-start">

        <!-- Heading -->
        <h2 class="text-4xl font-bold text-slate-700 sm:text-4xl">
            Join Our Newsletter
        </h2>

        <p class="mt-3 text-sm leading-6 text-slate-600 sm:text-base">
            Get the latest football news, match updates, and exclusive
            stories delivered straight to your inbox.
        </p>
        <!-- Form -->
        <form action="#" method="POST" class="mt-6">
            @csrf
            <div class="mx-auto flex flex-col gap-3 sm:flex-row">
                <!-- Email -->
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email address"
                    required
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3
                           text-sm text-slate-700 placeholder-slate-500
                           outline-none transition
                           focus:border-slate-400 focus:ring-2 focus:ring-slate-400/20"
                >

                <!-- Subscribe -->
                
            </div>
            <div class="mx-auto flex flex-col gap-3 sm:flex-row mt-3">
                <button
                    type="submit"
                    class="w-full border-1 border-slate-200 rounded-4xl bg-white px-6 py-3 text-sm font-bold
                           text-slate-900 transition
                           hover:bg-gray-200
                           focus:outline-none focus:ring-2 focus:ring-slate-200 focus:ring-offset-2 focus:ring-offset-slate-900"
                >
                    Subscribe
                </button>
            </div>
        </form>

    </div>
</div>
@push('scripts')
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