@extends('layouts.app')

@section('content')

<div class="mx-auto">

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3.5">
        <i class='bx bxs-check-circle text-xl'></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Articles</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua artikel berita di sini</p>
        </div>

        <a href="{{ route('articles.create') }}"
           class="flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium text-sm hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-all duration-200">
            <i class='bx bx-plus text-lg'></i>
            Tambah Artikel
        </a>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 mb-6">
        <form action="{{ route('articles.index') }}" method="GET" class="flex flex-wrap items-center gap-3">

            <div class="relative flex-1 min-w-[240px]">
                <i class='bx bx-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="Cari judul artikel..."
                    class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition">
            </div>

            <select name="category"
                class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="status"
                class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <select name="sort"
                class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition">
                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul A–Z</option>
                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul Z–A</option>
            </select>

            <button class="flex items-center gap-1.5 bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-indigo-700 transition">
                <i class='bx bx-filter-alt'></i>
                Cari
            </button>

            @if(request('keyword') || request('category') || request('status'))
            <a href="{{ route('articles.index') }}"
               class="flex items-center gap-1.5 bg-gray-100 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 transition">
                <i class='bx bx-x'></i>
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Table Card --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Thumbnail</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Judul</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Penulis</th>
                    <th class="p-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="p-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Publish</th>
                    <th class="p-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($articles as $article)
                <tr class="hover:bg-gray-50/80 transition">

                    <td class="p-4">
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                                 class="w-16 h-16 object-cover rounded-xl shadow-sm border border-gray-100">
                        @else
                            <div class="w-16 h-16 flex items-center justify-center bg-gray-100 rounded-xl text-gray-400">
                                <i class='bx bx-image text-xl'></i>
                            </div>
                        @endif
                    </td>

                    <td class="p-4">
                        <p class="text-sm font-medium text-gray-900 line-clamp-2 max-w-xs">{{ $article->title }}</p>
                    </td>

                    <td class="p-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-medium">
                            {{ $article->category->name }}
                        </span>
                    </td>

                    <td class="p-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-xs font-semibold text-gray-600 shrink-0">
                                {{ strtoupper(substr($article->user->name, 0, 1)) }}
                            </div>
                            <span class="text-sm text-gray-700">{{ $article->user->name }}</span>
                        </div>
                    </td>

                    <td class="p-4 text-center">
                        @if($article->status == 'published')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Published
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Draft
                            </span>
                        @endif
                    </td>

                    <td class="p-4 text-center">
                        <span class="text-sm text-gray-500">
                            {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}
                        </span>
                    </td>

                    <td class="p-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('article.show', $article->slug) }}" target="_blank"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition" title="Lihat">
                                <i class='bx bx-show text-lg'></i>
                            </a>

                            <a href="{{ route('articles.edit', $article) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition" title="Edit">
                                <i class='bx bx-edit text-lg'></i>
                            </a>

                            <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                  onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition" title="Hapus">
                                    <i class='bx bx-trash text-lg'></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class='bx bx-file-blank text-4xl text-gray-300'></i>
                            <p class="text-gray-500 text-sm">Belum ada artikel.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $articles->links() }}
    </div>

</div>

@endsection