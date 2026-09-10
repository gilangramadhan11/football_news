@php
$notifications = auth()->check()
    ? auth()->user()->unreadNotifications()->latest()->take(5)->get()
    : collect();

$unreadCount = auth()->check()
    ? auth()->user()->unreadNotifications()->count()
    : 0;
@endphp
<nav class="relative bg-slate-800 h-16 text-white shadow px-8 py-4 flex items-center justify-between border-b border-slate-700/50">
    <!-- Judul -->
    <h2 class="font-semibold text-2xl">
        Dashboard
    </h2>
    <!-- Menu Kanan -->
    <div class="flex items-center gap-5">
        <!-- Notification -->
        <div class="relative">
            <button id="notificationBtn" class="relative">
                <i class='bx bx-bell text-2xl'></i>
                @if($unreadCount)
                    <span
                        class="absolute -top-2 -right-2
                               bg-red-500 text-white
                               text-xs w-5 h-5
                               rounded-full flex
                               items-center justify-center">
                        {{ $unreadCount }}
                    </span>
                @endif
            </button>
            <!-- Dropdown Notification -->
            <div id="notificationMenu"
                class="hidden absolute right-0 mt-3 w-96 bg-white rounded-xl shadow-xl border z-50">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="font-semibold">
                        Notifications
                    </h3>
                    <form action="{{ route('notifications.readAll') }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="text-sm text-blue-600 hover:text-blue-800">
                            Tandai semua
                        </button>
                    </form>
                </div>
                @forelse($notifications as $notification)
                    <a href="{{ route('notifications.show', $notification->id) }}"
                    class="block p-4 border-b
                        {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                        <p class="font-semibold">
                            {{ $notification->data['title'] }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $notification->data['message'] }}
                        </p>
                        <small class="text-gray-400">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </a>
                @empty
                    <p class="p-4 text-gray-500">
                        Tidak ada notifikasi.
                    </p>
                @endforelse
            </div>
        </div>
        <!-- Profile -->
        <div class="flex items-center gap-2">
        <div class="relative">
            <button id="profileBtn" class="flex items-center gap-2">
                @if(auth()->user()->profile_photo_url)
                    <img
                        src="{{ auth()->user()->profile_photo_url }}"
                        alt="{{ auth()->user()->name }}"
                        class="w-10 h-10 rounded-full object-cover">
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-lime-400 text-slate-800
                            flex items-center justify-center font-semibold">
                        {{ collect(explode(' ', trim(auth()->user()->name)))
                            ->filter()
                            ->take(2)
                            ->map(fn($name) => strtoupper(substr($name, 0, 1)))
                            ->implode('') }}
                    </div>
                @endif
                <span class="font-semibold">
                    {{ auth()->user()->name }}
                </span>
            </button>
            <!-- Dropdown Profile -->
            <div id="profileMenu"
                class="hidden absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border z-50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-slate-800 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        </div>
    </div>
</nav>
@push('scripts')
<script>

const btn = document.getElementById('notificationBtn');
const menu = document.getElementById('notificationMenu');

btn.addEventListener('click', ()=>{

    menu.classList.toggle('hidden');

});

document.addEventListener('click',(e)=>{

    if(!btn.contains(e.target) && !menu.contains(e.target)){

        menu.classList.add('hidden');

    }

});

const profileBtn = document.getElementById('profileBtn');
const profileMenu = document.getElementById('profileMenu');

profileBtn.addEventListener('click', ()=>{

    profileMenu.classList.toggle('hidden');

});

document.addEventListener('click',(e)=>{

    if(!profileBtn.contains(e.target) && !profileMenu.contains(e.target)){

        profileMenu.classList.add('hidden');

    }

});

</script>

@endpush