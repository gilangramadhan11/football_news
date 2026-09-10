@extends('layouts.app')

@section('title', 'Analytics')

@section('content')
@php
use Illuminate\Support\Str;
@endphp
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Analytics Dashboard
        </h1>
        <p class="text-gray-500 mt-2">
            Statistik performa Football News.
        </p>
    </div>
    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- Views -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        Total Views
                    </p>

                    <h2 class="text-3xl font-bold mt-2">

                        {{ number_format($totalViews) }}

                    </h2>

                </div>

                <i class='bx bx-show text-5xl text-blue-500'></i>

            </div>

        </div>

        <!-- Likes -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-red-500">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        Total Likes
                    </p>

                    <h2 class="text-3xl font-bold mt-2">

                        {{ number_format($totalLikes) }}

                    </h2>

                </div>

                <i class='bx bxs-heart text-5xl text-red-500'></i>

            </div>

        </div>

        <!-- Artikel -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        Artikel
                    </p>

                    <h2 class="text-3xl font-bold mt-2">

                        {{ number_format($totalArticles) }}

                    </h2>

                </div>

                <i class='bx bx-news text-5xl text-green-500'></i>

            </div>

        </div>

        <!-- Kategori -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        Kategori
                    </p>

                    <h2 class="text-3xl font-bold mt-2">

                        {{ number_format($totalCategories) }}

                    </h2>

                </div>

                <i class='bx bx-category text-5xl text-yellow-500'></i>

            </div>

        </div>

    </div>
    <div class="grid lg:grid-cols-3 gap-6 mt-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <h2 class="font-semibold text-lg mb-4">
                Views per Bulan
            </h2>
            <div class="h-96">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-semibold text-lg mb-4">
                Distribusi Artikel
            </h2>
            <div class="h-96">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
    <div class="grid lg:grid-cols-2 gap-6 mt-8">
        <!-- Top Artikel -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-6">
                🏆 Top Artikel
            </h2>
            @php
                $maxViews = max($topArticles->max('views'),1);
            @endphp
            @foreach($topArticles as $index => $article)
            @php
                $percentage = ($article->views / $maxViews) * 100;
            @endphp
            <div class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">
                            {{ $index+1 }}.
                            {{ Str::limit($article->title,35) }}
                        </p>
                        <small class="text-gray-500">
                            {{ number_format($article->views) }} Views
                        </small>
                    </div>
                    <span class="text-blue-600">
                        👁
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div
                        class="bg-blue-500 h-2 rounded-full"
                        style="width: {{ $percentage }}%">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Top Kategori -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-6">
                📂 Top Kategori
            </h2>
            @php
                $maxCategory = max($topCategories->max('articles_count'),1);
            @endphp
            @foreach($topCategories as $category)

            @php
                $percentage = ($category->articles_count / $maxCategory) * 100;
            @endphp

            <div class="mb-5">
                <div class="flex justify-between">
                    <span>
                        {{ $category->name }}
                    </span>
                    <span>
                        {{ $category->articles_count }}
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div
                        class="bg-green-500 h-2 rounded-full"
                        style="width: {{ $percentage }}%">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($chartLabels);
const data = @json($chartData);

new Chart(document.getElementById('viewsChart'),{

    type:'line',

    data:{
        labels:labels,
        datasets:[{
            label:'Artikel',
            data:data,
            tension:0.4,
            fill:true
        }]
    },

    options:{
        responsive:true,
        maintainAspectRatio:false
    }

});

const categoryLabels = @json($categoryLabels);
const categoryData = @json($categoryData);

new Chart(document.getElementById('categoryChart'), {

    type: 'doughnut',

    data: {

        labels: categoryLabels,

        datasets: [{

            data: categoryData,

            backgroundColor: [

                '#3b82f6',
                '#10b981',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6',
                '#06b6d4',
                '#84cc16',
                '#ec4899'

            ]

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {

                position: 'bottom'

            }

        }

    }

});

</script>
@endpush