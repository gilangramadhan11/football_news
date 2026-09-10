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
            <h1 class="text-2xl font-bold text-gray-900">Users</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua user di sini</p>
        </div>

        <a href="{{ route('users.create') }}"
           class="flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium text-sm hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-all duration-200">
            <i class='bx bx-plus text-lg'></i>
            Tambah user
        </a>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Role</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Artikel</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Bergabung</th>
                    <th class="p-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="p-4">
                        <p class="text-sm font-medium text-gray-900 line-clamp-2 max-w-xs">
                            {{ $user->name }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm font-medium text-gray-900 line-clamp-2 max-w-xs">
                            {{ $user->email }}
                        </p>
                    </td>
                    <td class="p-4">
                        @if($user->role=='super_admin')
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-medium max-w-xs">
                                Super Admin
                            </span>
                        @elseif($user->role=='editor')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium max-w-xs">
                                Editor
                            </span>
                        @else
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium max-w-xs">
                                Author
                            </span>
                        @endif
                    </td>
                    <td class="p-4">
                        <p class="text-sm font-medium text-gray-900 line-clamp-2 max-w-xs">
                            {{ $user->articles()->count() }}
                        </p>
                    </td>

                    <td class="p-4">
                        <p class="text-sm font-medium text-gray-900 line-clamp-2 max-w-xs">
                            {{ $user->created_at->format('d M Y') }}
                        </p>
                    </td>

                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('users.edit',$user) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition" title="Edit">
                                <i class='bx bx-edit text-lg'></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition" title="Hapus">
                                    <i class='bx bx-trash text-lg'></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-6">
        {{ $users->links() }}
    </div>
</div>
@endsection