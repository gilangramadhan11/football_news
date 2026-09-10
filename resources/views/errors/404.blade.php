@extends('layouts.frontend')

@section('title','404 - Halaman Tidak Ditemukan')

@section('content')

<div class="flex items-center justify-center py-24">

    <div class="text-center max-w-xl">

        <div class="text-8xl font-extrabold text-blue-600">

            404

        </div>

        <h1 class="text-4xl font-bold mt-6">

            Halaman Tidak Ditemukan

        </h1>

        <p class="text-gray-500 mt-4">

            Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.

        </p>

        <img
            src="{{ asset('images/404.svg') }}"
            class="mx-auto w-72 mt-10"
            alt="404">

        <div class="mt-10 flex justify-center gap-4">

            <a href="{{ route('home') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                🏠 Kembali ke Beranda

            </a>

            <a href="{{ url()->previous() }}"
                class="border border-gray-300 hover:bg-gray-100 px-6 py-3 rounded-lg">

                ← Halaman Sebelumnya

            </a>

        </div>

    </div>

</div>

@endsection