@extends('layouts.app')

@section('content')

<div class="mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl text-gray-900 font-bold">
            Tambah User
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
        action="{{ route('users.store') }}"
        method="POST"
        class="bg-white shadow rounded-lg p-6 space-y-5"
        >
        @csrf
        <div>
            <label class="font-semibold">Nama Lengkap</label>
            <input
                type="text"
                name="name"
                class="w-full border rounded-lg p-2 border-slate-300"
                placeholder="Masukan nama lengkap...">
        </div>

        <div>
            <label class="font-semibold">Email</label>
            <input
                type="email"
                name="email"
                class="w-full border rounded-lg p-2 border-slate-300"
                placeholder="Masukan Email...">
        </div>

        <div>
            <label class="font-semibold">Password</label>
            <input
                type="password"
                name="password"
                class="w-full border rounded-lg p-2 border-slate-300"
                >
        </div>

        <div>
            <label>
                Role
            </label>
            <select
                name="role"
                class="w-full border rounded-lg p-2 border-slate-300">
                <option value="author">
                    Author
                </option>
                <option value="editor">
                    Editor
                </option>
                <option value="super_admin">
                    Super Admin
                </option>
            </select>
        </div>
        <button
            class="bg-blue-600 text-white px-6 py-3 rounded-lg">
            Simpan
        </button>
    </form>
</div>
@endsection