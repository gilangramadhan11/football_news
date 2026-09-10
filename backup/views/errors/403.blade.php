@extends('errors.layout')

@section('title','403 Forbidden')

@section('content')

<i class='bx bx-lock-alt text-red-500 text-8xl'></i>

<h1 class="text-5xl font-bold mt-6">
403
</h1>

<p class="text-xl mt-3 font-semibold">
Akses Ditolak
</p>

<p class="text-gray-500 mt-3">
Anda tidak memiliki izin untuk membuka halaman ini.
</p>

<a href="/"
class="inline-block mt-8 bg-blue-600 text-white px-6 py-3 rounded-lg">

Kembali ke Beranda

</a>

@endsection