@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Artikel
</h1>

@if ($errors->any())
<div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-5">
    <ul class="list-disc ml-5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('articles.update', $article->id) }}"
      method="POST"
      enctype="multipart/form-data"
      class="bg-white shadow rounded-lg p-6 space-y-5">

    @csrf
    @method('PUT')

    <div>
        <label class="font-semibold">Judul</label>

        <input
            id="title"
            type="text"
            name="title"
            value="{{ old('title', $article->title) }}"
            class="w-full border rounded-lg p-2">
    </div>
    <div>
        <input
            id="slug"
            type="text"
            name="slug"
            value="{{ old('slug', $article->slug) }}"
            class="w-full border rounded-lg p-2"
            hidden>
    </div>

    <div>
        <label class="font-semibold">Kategori</label>
        <select
            name="category_id"
            class="w-full border rounded-lg p-2">
            @foreach($categories as $category)
            <option
                value="{{ $category->id }}"
                {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label for="status" class="block font-semibold mb-2">
            Status
        </label>
        <select
            name="status"
            id="status"
            class="w-full border rounded-lg p-2">
            <option value="draft"
                {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>
                Draft
            </option>
            <option value="published"
                {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>
                Published
            </option>
        </select>
    </div>

    <div class="mb-4">
        <label for="published_at" class="block font-semibold mb-2">
            Tanggal Publish
        </label>
        <input
            type="datetime-local"
            id="published_at"
            name="published_at"
            value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}"
            class="w-full border rounded-lg p-2">
    </div>
    <div>
        <label class="font-semibold">
            Thumbnail
        </label>
    </div>
    <div x-data="{ 
        preview: '{{ $article->thumbnail ? Storage::url($article->thumbnail) : '' }}'
    }" class="flex items-start gap-4">
        {{-- Preview box --}}
        <div class="relative w-32 h-32 shrink-0 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 overflow-hidden flex items-center justify-center">
            <template x-if="!preview">
                <div class="flex flex-col items-center gap-1 text-gray-400">
                    <i class='bx bx-image text-2xl'></i>
                    <span class="text-[10px]">No Image</span>
                </div>
            </template>
            <img x-show="preview" :src="preview" alt="Preview"
            class="w-full h-full object-cover">
        </div>
        
        {{-- Upload area --}}
        <div class="flex-1">
            <label for="thumbnail"
                class="group relative flex flex-col items-center justify-center gap-2 w-full h-32 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 hover:bg-indigo-50/50 hover:border-indigo-300 cursor-pointer transition-all duration-200">
                <i class='bx bx-cloud-upload text-3xl text-gray-400 group-hover:text-indigo-500 transition'></i>
                <p class="text-sm text-gray-500 group-hover:text-indigo-600 transition">
                    <span class="font-semibold text-indigo-600">Klik untuk upload</span> atau drag & drop
                </p>
                <p class="text-xs text-gray-400">PNG, JPG hingga 2MB</p>
                
                <input
                id="thumbnail"
                type="file"
                name="thumbnail"
                accept="image/*"
                class="hidden"
                @change="
                const file = $event.target.files[0];
                if (file) { preview = URL.createObjectURL(file) }
                ">
            </label>
        </div>
    </div>

    <div>
        <label class="font-semibold">
            Isi Artikel
        </label>
        <textarea
            id="editor"
            name="content">
            {{ old('content', $article->content) }}
        </textarea>
    </div>

    <button
        class="bg-blue-600 text-white px-6 py-3 rounded-lg">
        Update Artikel
    </button>

</form>

@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"> </script>
<script 
    src="https://cdn.tiny.cloud/1/9m99g076jgb1ieinphwp8if3zdojnindol7c8ksa550ky4n8/tinymce/7/tinymce.min.js"
        referrerpolicy="origin">
</script>
<script>

const title = document.getElementById('title');
const slug = document.getElementById('slug');

title.addEventListener('keyup', function(){

    slug.value = title.value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g,'-')
        .replace(/-+/g,'-');

});

const thumbnail = document.querySelector('input[name="thumbnail"]');
const preview = document.getElementById('preview');

thumbnail.addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){

        preview.src = URL.createObjectURL(file);

        preview.classList.remove('hidden');

    }

});

tinymce.init({
    selector: '#editor',
    height: 500,
    menubar: false,
    plugins: [
        'lists',
        'link',
        'table',
        'image',
        'code',
        'wordcount'
    ],
    toolbar:
        'undo redo | styles | bold italic | alignleft aligncenter alignright | bullist numlist | link image table | code'
});
</script>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Premium features
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'tinymceai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | tinymceai-chat tinymceai-quickactions tinymceai-review | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    tinymceai_token_provider: async () => {
      await fetch(`https://demo.api.tiny.cloud/1/9m99g076jgb1ieinphwp8if3zdojnindol7c8ksa550ky4n8/auth/random`, { method: "POST", credentials: "include" });
      return { token: await fetch(`https://demo.api.tiny.cloud/1/9m99g076jgb1ieinphwp8if3zdojnindol7c8ksa550ky4n8/jwt/tinymceai`, { credentials: "include" }).then(r => r.text()) };
    },
    uploadcare_public_key: '5b3535a43f7eae115e52',
  });
</script>
@endpush