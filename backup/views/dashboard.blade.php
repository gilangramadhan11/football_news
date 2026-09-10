@extends('layouts.app')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
        Dashboard
    </h2>
</x-slot>
<div class="p-4 space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">
                Selamat Datang, {{ Auth::user()->name }} 👋
            </h1>
            <p class="text-gray-500 mt-2">
                Kelola artikel Football News dari dashboard admin.
            </p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 sm:grid-cols-4 gap-6">
        <x-stat-card   
            title="Total Artikel" 
            :value="$totalArticles ?? '0'"
            icon="bxs-user-detail" 
            :trend="$percentageChange ?? '0'" 
            trendDirection="up" 
            color="lime" />
        <x-stat-card   
            title="Total Published" 
            :value="$publishedArticles ?? '0'"
            icon="bx bx-check-circle" 
            :trend="$publishedArticles ?? '0'" 
            trendDirection="up" 
            color="fuchsia" />
        <x-stat-card   
            title="Total Views" 
            :value="$totalViews ?? '0'"
            icon="bx bx-show" 
            :trend="$viewsPercentage ?? '0'" 
            :trendDirection="$viewsPercentage" 
            color="sky" />
        <x-stat-card   
            title="Total Likes" 
            :value="$totalLikes ?? '0'"
            icon="bx bx-heart" 
            :trend="$likesPercentage ?? '0'" 
            :trendDirection="$likesPercentage" 
            color="red" />
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div x-data="{ activeTab: 'activity' }" 
                class="relative bg-white backdrop-blur-sm rounded-2xl border border-slate-100/50 overflow-hidden">

                {{-- Aksen glow atas, konsisten tema --}}
                <div class="absolute -left-10 -top-10 w-40 h-40 bg-lime-500/10 rounded-full blur-3xl"></div>

                {{-- Header + Tab Switcher --}}
                <div class="relative flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-200">
                    <h3 class="text-slate-800 font-bold text-lg flex items-center gap-2">
                        <i class='bx bx-pulse text-lime-600 text-xl'></i>
                        Dasboard Activity
                    </h3>

                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-lg">
                        <button @click="activeTab = 'activity'"
                            :class="activeTab === 'activity' ? 'bg-[#CCFE02] text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-white'"
                            class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200">
                            Latest Articles
                        </button>
                        <button @click="activeTab = 'views'"
                            :class="activeTab === 'views' ? 'bg-[#CCFE02] text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-white'"
                            class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200">
                            Top Views
                        </button>
                        <button @click="activeTab = 'category'"
                            :class="activeTab === 'category' ? 'bg-[#CCFE02] text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-white'"
                            class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200">
                            Top Likes
                        </button>
                    </div>
                </div>

                <div x-show="activeTab === 'activity'" x-transition class="relative p-6 space-y-4">
                    @foreach($latestArticles as $article)
                    <div class="flex items-start gap-3 rounded-xl group transition">
                        <div class="w-9 h-9 rounded-lg bg-lime-50 flex items-center justify-center shrink-0 group-hover:bg-[#CCFE02]/20 transition ">
                            <i class='bx bx-news text-lime-600 text-lg'></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-slate-800 text-sm font-medium leading-snug">{{ $article->title }}</p>
                            <span class="text-slate-400 text-xs">{{ $article->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div x-show="activeTab === 'views'" x-transition class="relative p-6 space-y-3">
                    @foreach($topArticles as $index => $article)
                        <div class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 transition-all duration-200">
                            <span class="w-7 h-7 flex items-center justify-center
                       rounded-md text-xs font-bold shrink-0
                       {{ $loop->first
                            ? 'bg-[#CCFE02] text-slate-900'
                            : 'bg-slate-100 text-slate-500'
                       }}">
                        {{$loop->iteration}}
                        </span>
                        <p class="text-slate-800 text-sm font-medium flex-1 truncate">{{ $article->title }}</p>
                        <span class="flex items-center gap-1 text-lime-600 text-xs font-semibold shrink-0">
                        <i class='bx bx-show'></i>{{ number_format($article->views) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                <div x-show="activeTab === 'category'" x-transition class="relative p-6 space-y-4">
                    @foreach($topLikes as $index => $likes)
                        <div class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 transition-all duration-200">
                            <span class="w-7 h-7 flex items-center justify-center
                       rounded-md text-xs font-bold shrink-0
                       {{ $loop->first
                            ? 'bg-[#CCFE02] text-slate-900'
                            : 'bg-slate-100 text-slate-500'
                       }}">
                        {{$loop->iteration}}
                        </span>
                        <p class="text-slate-800 text-sm font-medium flex-1 truncate">{{ $likes->title }}</p>
                        <span class="flex items-center gap-1 text-lime-600 text-xs font-semibold shrink-0">
                        <i class='bx bx-heart'></i>{{ number_format($likes->likes) }}
                        </span>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
        <div class="relative bg-white backdrop-blur-sm rounded-2xl border border-slate-100/50 overflow-hidden p-6">

            {{-- Glow dekorasi --}}
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-lime-500/10 rounded-full blur-3xl"></div>

            <h3 class="relative text-slate-800 font-bold text-lg flex items-center gap-2 mb-5">
                <i class='bx bxs-zap text-lime-400 text-xl'></i>
                Quick Actions
            </h3>

            <div class="relative grid grid-cols-2 gap-3">

                {{-- Action 1: Tambah Berita --}}
                <a href="{{ route('articles.index') }}"
                class="group relative flex flex-col items-start gap-3 p-4 rounded-xl bg-gray-50 border border-slate-300/50 hover:border-lime-500/50 hover:bg-slate-200/80 transition-all duration-300 overflow-hidden">
                    <div class="relative w-10 h-10 rounded-lg bg-gradient-to-br from-lime-400 to-lime-600 flex items-center justify-center shadow-[0_0_15px_rgba(163,230,53,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <i class='bx bx-plus text-xl text-slate-900'></i>
                    </div>
                    <div class="relative">
                        <p class="text-slate-800 text-sm font-semibold">Tambah Berita</p>
                        <p class="text-slate-500 text-xs mt-0.5">Buat artikel baru</p>
                    </div>
                </a>

                {{-- Action 2: Kelola Users --}}
                <a href="{{ route('users.index') }}"
                class="group relative flex flex-col items-start gap-3 p-4 rounded-xl bg-gray-50 border border-slate-300/50 hover:border-sky-500/50 hover:bg-slate-200/80 transition-all duration-300 overflow-hidden">
                    <div class="relative w-10 h-10 rounded-lg bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center shadow-[0_0_15px_rgba(56,189,248,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <i class='bx bxs-user-detail text-xl text-slate-900'></i>
                    </div>
                    <div class="relative">
                        <p class="text-slate-800 text-sm font-semibold">Kelola Users</p>
                        <p class="text-slate-500 text-xs mt-0.5">Lihat semua user</p>
                    </div>
                </a>

                {{-- Action 3: Kategori --}}
                <a href="{{ route('categories.index') }}"
                class="group relative flex flex-col items-start gap-3 p-4 rounded-xl bg-gray-50 border border-slate-300/50 hover:border-amber-500/50 hover:bg-slate-200/80 transition-all duration-300 overflow-hidden">
                    <div class="relative w-10 h-10 rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-[0_0_15px_rgba(251,191,36,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <i class='bx bxs-category text-xl text-slate-900'></i>
                    </div>
                    <div class="relative">
                        <p class="text-slate-800 text-sm font-semibold">Kategori</p>
                        <p class="text-slate-500 text-xs mt-0.5">Atur kategori berita</p>
                    </div>
                </a>
                {{-- Action 4: setting --}}
                <a href="{{ route('categories.index') }}"
                class="group relative flex flex-col items-start gap-3 p-4 rounded-xl bg-gray-50 border border-slate-300/50 hover:border-fuchsia-500/50 hover:bg-slate-200/80 transition-all duration-300 overflow-hidden">
                    <div class="relative w-10 h-10 rounded-lg bg-gradient-to-br from-fuchsia-400 to-fuchsia-600 flex items-center justify-center shadow-[0_0_15px_rgba(251,191,36,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <i class='bx bx-cog text-xl text-slate-900'></i>
                    </div>
                    <div class="relative">
                        <p class="text-slate-800 text-sm font-semibold">Setting</p>
                        <p class="text-slate-500 text-xs mt-0.5">Atur akun profil</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Artikel per Bulan</h2>
            <div class="relative h-80">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Status Artikel</h2>
            <div class="relative h-80">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
    
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
        
        const chartLabels = @json($chartLabels);
        const chartData   = @json($chartData);
        const statusChart = @json($statusChart);
 
        // 1. Bar chart: jumlah artikel per bulan
        new Chart(document.getElementById('monthlyChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Artikel',
                    data: chartData,
                    backgroundColor: 'rgba(79, 70, 229, 0.7)',
                    borderRadius: 6,
                    maxBarThickness: 40,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                    },
                },
            },
        });
 
        // 2. Doughnut chart: status artikel (published vs draft)
        new Chart(document.getElementById('statusChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusChart),
                datasets: [{
                    data: Object.values(statusChart),
                    backgroundColor: ['#22c55e', '#eab308'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
            },
        });
    </script>
    @endpush
@endsection
