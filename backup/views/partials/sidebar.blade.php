{{-- Kategori --}}
<div class="bg-white rounded-xl shadow p-6">

    <h3 class="font-bold text-xl mb-5">

        📂 Kategori

    </h3>

    <div class="space-y-3">

        @foreach($categories as $category)

            <a
                href="{{ route('category.show',$category->slug) }}"
                class="flex justify-between hover:text-blue-600">

                <span>{{ $category->name }}</span>

                <span class="bg-gray-100 rounded-full px-2 py-1 text-xs">

                    {{ $category->articles_count }}

                </span>

            </a>

        @endforeach

    </div>

</div>

{{-- Artikel Terbaru --}}
<div class="bg-white rounded-xl shadow p-6">

    <h3 class="font-bold text-xl mb-5">

        📰 Artikel Terbaru

    </h3>

    <div class="space-y-4">

        @foreach($recentArticles as $recent)

            <div>

                <a
                    href="{{ route('article.show',$recent->slug) }}"
                    class="font-semibold hover:text-blue-600">

                    {{ $recent->title }}

                </a>

                <p class="text-gray-500 text-sm mt-1">

                    {{ $recent->published_at?->diffForHumans() }}

                </p>

            </div>

        @endforeach

    </div>

</div>

<div class="bg-white rounded-xl shadow p-6">

    <h3 class="font-bold text-xl mb-5">

        🔥 Artikel Populer

    </h3>

    <div class="space-y-4">

        @foreach($popularArticles as $popular)

            <div class="flex gap-3">

                <div class="text-red-600 font-bold text-xl">

                    {{ $loop->iteration }}

                </div>

                <div>

                    <a
                        href="{{ route('article.show', $popular->slug) }}"
                        class="font-semibold hover:text-blue-600">

                        {{ Str::limit($popular->title, 45) }}

                    </a>

                    <p class="text-sm text-gray-500 mt-1">

                        👁 {{ number_format($popular->views) }} kali dibaca

                    </p>

                </div>

            </div>

        @endforeach

    </div>

</div>