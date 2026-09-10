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
            <h1 class="text-2xl font-bold text-gray-900">Kategori</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua kategori berita di sini</p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium text-sm hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-all duration-200">
            <i class='bx bx-plus text-lg'></i>
            Tambah Kategori
        </a>
    </div>   
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Slug</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Deskripsi</th>
                    <th class="p-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50/80 transition">

                    <td class="p-4">
                        <p class="text-sm font-medium text-gray-900 line-clamp-2 max-w-xs">{{ $category->name }}</p>
                    </td>

                    <td class="p-4">
                        <span class="text-sm font-medium text-gray-900 line-clamp-2 max-w-xs">
                            {{ $category->slug }}
                        </span>
                    </td>

                    <td class="p-4">
                        <span class="text-sm font-medium text-gray-900 line-clamp-2 max-w-xs">
                            {{ $category->description }}
                        </span>
                    </td>

                    <td class="p-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('categories.show', $category->slug) }}" target="_blank"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition" title="Lihat">
                                <i class='bx bx-show text-lg'></i>
                            </a>

                            <a href="{{ route('categories.edit', $category) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition" title="Edit">
                                <i class='bx bx-edit text-lg'></i>
                            </a>

                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
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
</div>
@endsection