<aside id="sidebar" class="w-64 min-h-screen bg-slate-900 flex flex-col transition-all duration-300 relative z-30">
    <div id="brand" class="relative h-16 flex items-center px-6 bg-slate-800 border-b border-slate-700/50">
        <div class="flex items-center gap-3 min-w-0">
            <i class="bx bx-football text-2xl text-lime-300 shrink-0 drop-shadow-sm"></i>
            <h1 id="brandText" class="text-xl font-bold text-white whitespace-nowrap overflow-hidden transition-all duration-300">
                Football<span class="text-lime-400">News</span>
            </h1>
        </div>
        <button 
            id="sidebarToggle" 
            type="button"
            class="absolute top-1/2 -translate-y-1/2 -right-3 z-50 w-6 h-6 flex items-center justify-center rounded-full bg-slate-800 text-white hover:bg-lime-500 hover:text-slate-900 hover:border-lime-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-lime-400">
            <i id="toggleIcon" class='bx bx-chevron-left text-2xl'></i>
        </button>
    </div>
    <nav class="flex-1 overflow-y-auto py-4">
        <x-nav-link route="dashboard" icon="bx-home" label="Dashboard" :roles="['super_admin']" />
        <x-nav-link route="home" target="_blank" icon="bx bx-globe" label="Landing Page" :roles="['super_admin', 'editor', 'author']" />
        <x-nav-link route="articles.index" icon="bx-news" label="Articles" :roles="['super_admin', 'editor', 'author']" />
        <x-nav-link route="categories.index" icon="bx-category" label="Categories" :roles="['super_admin']" />
        <x-nav-link route="users.index" icon="bx-user" label="Users" :roles="['super_admin']" />
        <hr class="my-4 border-slate-700 mx-3">
        <x-nav-link route="logout" icon="bx-log-out" label="Logout" method="POST" />
    </nav>
</aside>
<script>
    const sidebar = document.getElementById('sidebar');
    const brand = document.getElementById('brand');
    const brandText = document.getElementById('brandText');

    const menuItems = document.querySelectorAll('.menu-item');
    const menuTexts = document.querySelectorAll('.menu-text');
    const menuIndicators = document.querySelectorAll('.menu-indicator');

    const toggleButton = document.getElementById('sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');

    toggleButton.addEventListener('click', () => {
        const isCollapsed = sidebar.classList.contains('w-20');
        if (isCollapsed) {
         sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            brand.classList.remove('justify-center');
            brand.classList.add('px-6');
            brandText.classList.remove('hidden');
            menuTexts.forEach(text => {
                text.classList.remove('hidden');
            });
            menuIndicators.forEach(el => el.classList.remove('hidden'));
            menuItems.forEach(item => {
                item.classList.remove('justify-center');
                item.classList.add('px-6');
            });
            toggleIcon.classList.remove('bx-chevron-right');
            toggleIcon.classList.add('bx-chevron-left');
        } else {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');
            brand.classList.add('justify-center');
            brand.classList.remove('px-6');
            brandText.classList.add('hidden');
            menuTexts.forEach(text => {
                text.classList.add('hidden');
            });
            menuIndicators.forEach(el => el.classList.add('hidden'));
            menuItems.forEach(item => {
                item.classList.add('justify-center');
                item.classList.remove('px-6');
            });
            toggleIcon.classList.remove('bx-chevron-left');
            toggleIcon.classList.add('bx-chevron-right');
        }
    });
</script>