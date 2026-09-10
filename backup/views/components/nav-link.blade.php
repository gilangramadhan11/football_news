@props(['route', 'icon', 'label', 'roles' => null, 'method' => 'GET', 'target' => null, ])

@php
    $isAllowed = is_null($roles) || in_array(auth()->user()->role, $roles);
    $isActive = request()->routeIs($route);
    $isPost = strtoupper($method) !== 'GET';
@endphp

@if($isAllowed)
    @if($isPost)
        {{-- Render sebagai form + button, tapi class & struktur SAMA PERSIS dengan <a> --}}
        <form action="{{ route($route) }}" method="POST" class="contents">
            @csrf
            @if(strtoupper($method) === 'DELETE')
                @method('DELETE')
            @endif
            <button type="submit"
                class="menu-item w-full flex items-center gap-3 px-6 py-3 mx-3 rounded-xl transition-all duration-200 group text-left bg-transparent border-0 appearance-none cursor-pointer
                       {{ $isActive
                          ? 'bg-gradient-to-r from-lime-500/20 to-transparent text-lime-400 font-semibold'
                          : 'text-slate-300 hover:bg-slate-800 hover:text-lime-300' }}">

                <i class='bx {{ $icon }} text-xl shrink-0 transition-colors duration-200
                          {{ $isActive ? "text-lime-400 drop-shadow-[0_0_6px_rgba(163,230,53,0.6)]" : "group-hover:text-lime-300" }}'></i>

                <span class="menu-text whitespace-nowrap">{{ $label }}</span>
            </button>
        </form>
    @else
        {{-- Menu biasa, method GET --}}
        <a href="{{ route($route) }}"
            @if($target) target="{{ $target }}" @endif
           class="menu-item relative flex items-center gap-3 px-6 py-3 mx-3 rounded-xl transition-all duration-200 group
                  {{ $isActive
                     ? 'bg-gradient-to-r from-lime-500/20 to-transparent text-lime-400 font-semibold'
                     : 'text-slate-300 hover:bg-slate-800 hover:text-lime-300' }}">

            @if($isActive)
            <span class="menu-indicator absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r-full bg-lime-400 shadow-[0_0_10px_rgba(163,230,53,0.7)]"></span>
            @endif

            <i class='bx {{ $icon }} text-xl shrink-0 transition-colors duration-200
                      {{ $isActive ? "text-lime-400 drop-shadow-[0_0_6px_rgba(163,230,53,0.6)]" : "group-hover:text-lime-300" }}'></i>

            <span class="menu-text whitespace-nowrap">{{ $label }}</span>

            @if($isActive)
            <span class="menu-indicator ml-auto w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span>
            @endif
        </a>
    @endif
@endif