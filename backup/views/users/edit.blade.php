@extends('layouts.app')

@section('content')

<div class="mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl text-gray-900 font-bold">
            Edit User
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

    <form action="{{ route('users.update', $user) }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-5">

        @csrf
        @method('PUT')

        <div class="mb-5">

            <label class="font-semibold">Nama</label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="w-full border rounded-lg p-2 border-slate-300">

        </div>

        <div class="mb-5">

            <label class="font-semibold">Email</label>

            <input
                type="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="w-full border rounded-lg p-2 border-slate-300">

        </div>

        <div class="mb-5">

            <label class="font-semibold">Role</label>

            <select
                name="role"
                class="w-full border rounded-lg p-2 border-slate-300">

                <option value="super_admin"
                    @selected($user->role=='super_admin')>
                    Super Admin
                </option>

                <option value="editor"
                    @selected($user->role=='editor')>
                    Editor
                </option>

                <option value="author"
                    @selected($user->role=='author')>
                    Author
                </option>

            </select>

        </div>

        <div class="mb-6">

            <label class="font-semibold">
                Password Baru
            </label>

            <input
                type="password"
                name="password"
                class="w-full border rounded-lg p-2 border-slate-300">

            <p class="text-sm text-gray-500 mt-2">
                Kosongkan jika tidak ingin mengubah password.
            </p>

        </div>

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

            Update User

        </button>

    </form>

</div>

@endsection