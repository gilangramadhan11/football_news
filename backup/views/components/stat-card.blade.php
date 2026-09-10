@props([
    'title',
    'value',
    'icon',
    'trend',
    'trendDirection' => null,
    'color' => 'lime',       // lime | sky | amber | fuchsia
])

@php
    // Mapping warna supaya class Tailwind-nya lengkap (bukan di-generate dinamis string)
    $colors = [
        'lime' => [
            'border' => 'hover:border-lime-500/50',
            'shadow' => 'hover:shadow-[0_10px_40px_-15px_rgba(163,230,53,0.3)]',
            'blob' => 'bg-lime-500/10 group-hover:bg-lime-500/20',
            'iconBg' => 'from-lime-400 to-lime-600 shadow-[0_0_20px_rgba(163,230,53,0.4)]',
            'trendUp' => 'text-lime-400',
        ],
        'sky' => [
            'border' => 'hover:border-sky-500/50',
            'shadow' => 'hover:shadow-[0_10px_40px_-15px_rgba(56,189,248,0.3)]',
            'blob' => 'bg-sky-500/10 group-hover:bg-sky-500/20',
            'iconBg' => 'from-sky-400 to-sky-600 shadow-[0_0_20px_rgba(56,189,248,0.4)]',
            'trendUp' => 'text-sky-400',
        ],
        'amber' => [
            'border' => 'hover:border-amber-500/50',
            'shadow' => 'hover:shadow-[0_10px_40px_-15px_rgba(251,191,36,0.3)]',
            'blob' => 'bg-amber-500/10 group-hover:bg-amber-500/20',
            'iconBg' => 'from-amber-400 to-amber-600 shadow-[0_0_20px_rgba(251,191,36,0.4)]',
            'trendUp' => 'text-amber-400',
        ],
        'fuchsia' => [
            'border' => 'hover:border-fuchsia-500/50',
            'shadow' => 'hover:shadow-[0_10px_40px_-15px_rgba(232,121,249,0.3)]',
            'blob' => 'bg-fuchsia-500/10 group-hover:bg-fuchsia-500/20',
            'iconBg' => 'from-fuchsia-400 to-fuchsia-600 shadow-[0_0_20px_rgba(232,121,249,0.4)]',
            'trendUp' => 'text-fuchsia-400',
        ],
        'red' => [
            'border' => 'hover:border-red-500/50',
            'shadow' => 'hover:shadow-[0_10px_40px_-15px_rgba(232,121,249,0.3)]',
            'blob' => 'bg-red-500/10 group-hover:bg-red-500/20',
            'iconBg' => 'from-red-400 to-red-600 shadow-[0_0_20px_rgba(232,121,249,0.4)]',
            'trendUp' => 'text-red-400',
        ],
    ];

    $c = $colors[$color] ?? $colors['lime'];
    $isUp = $trend >= 0;
@endphp

<div class="group relative bg-white backdrop-blur-sm rounded-2xl p-6 border border-slate-300/50 overflow-hidden transition-all duration-300 hover:-translate-y-1 {{ $c['border'] }} {{ $c['shadow'] }}">

    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full blur-2xl transition-all duration-300 {{ $c['blob'] }}"></div>

    <div class="relative flex items-start justify-between">
        <div>
            <p class="text-slate-400 text-sm font-medium">{{ $title }}</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $value }}</h3>

            @if(!is_null($trend))
            <div class="flex items-center gap-1 mt-3">
                <i class='bx {{ $isUp ? "bx-trending-up" : "bx-trending-down" }} {{ $isUp ? $c['trendUp'] : "text-red-400" }}'></i>
                <span class="text-sm font-semibold {{ $isUp ? $c['trendUp'] : "text-red-400" }}">{{ $trend }}%</span>
                <span class="text-slate-500 text-xs">vs bulan lalu</span>
            </div>
            @endif
        </div>

        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br {{ $c['iconBg'] }} group-hover:scale-110 transition-transform duration-300">
            <i class='bx {{ $icon }} text-2xl text-slate-100'></i>
        </div>
    </div>
</div>