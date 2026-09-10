@extends('layouts.app')

@section('content')

<div class="mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl text-gray-900 font-bold">
            Tambah Artikel
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

    <form action="{{ route('articles.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white shadow rounded-lg p-6 space-y-5">

        @csrf

        <div>
            <label class="font-semibold">Judul</label>
            <input
                id="title"
                type="text"
                name="title"
                value="{{ old('title') }}"
                class="w-full border rounded-lg p-2 border-slate-300">
        </div>
        <div>
            <label class="font-semibold">Slug</label>
            <input
                id="slug"
                type="text"
                name="slug"
                value="{{ old('slug') }}"
                class="w-full border rounded-lg p-2 border-slate-300">
        </div>
        <div>
            <label class="font-semibold">Kategori</label>
            <select
                name="category_id"
                class="w-full border rounded-lg p-2 border-slate-300">
                @foreach($categories as $category)
                <option
                    value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="font-semibold">
                Status
            </label>
            <div class="mt-2">
                <label>
                    <input
                        type="radio"
                        name="status"
                        value="draft"
                        checked>
                    Draft
                </label>
                <label class="ml-6">
                    <input
                        type="radio"
                        name="status"
                        value="published">
                    Published
                </label>
            </div>
        </div>
        <div>
            <label for="" class="font-semibold">Thumbnail</label>
        </div>
        <div x-data="{ preview: null }" class="flex items-start gap-4">
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
                name="content"
                rows="10">
                {{ old('content') }}
            </textarea>
        </div>
        <button
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
            Simpan Artikel
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script 
    defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
</script>
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