@extends('layouts.app')

@section('content')

<div class="mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl text-gray-900 font-bold">
            Tambah Kategori
        </h1>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-5">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form 
        action="{{ route('categories.store') }}" 
        method="POST"
        class="bg-white shadow rounded-lg p-6 space-y-5">

        @csrf
        <div>
            <label class="font-semibold">Kategori</label>
            <input
                id="title"
                type="text"
                name="name"
                value="{{ old('title') }}"
                class="w-full border rounded-lg p-2 border-slate-300"
                placeholder="Masukan kategori artikel...">
        </div>
        
        <div>
            <label for="" class="font-semibold">Slug</label>
            <input
                id="slug" 
                type="text"
                name="slug"
                value="{{ old('slug') }}"
                class="w-full border rounded-lg p-2 bg-gray-50 border-slate-300"
                readonly>
        </div>

        <div>
            <label for="description" class="block font-semibold mb-2">
                Deskripsi
            </label>

            <textarea
                name="description"
                id="description"
                rows="4"
                class="w-full border border-slate-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Masukkan deskripsi..."
            >{{ old('description') }}</textarea>
        </div>

        <button 
            type="submit" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
            Simpan
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', function () {

        let slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

        slugInput.value = slug;
    });
</script>
@endpush