<nav class="bg-red-800 text-white h-screen w-64 fixed left-0 top-0 flex flex-col">

    <!-- LOGO / HEADER -->
    <div class="h-16 flex items-center px-6 border-b border-red-700">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-semibold">
            <i data-lucide="shield"></i>
            SISTEM KKO
        </a>
    </div>

    <!-- USER INFO -->
    <div class="px-6 py-4 border-b border-red-700">
        <div class="text-sm font-medium">Administrator</div>
        <div class="text-xs text-red-200">Sesi Aktif</div>
    </div>

    <!-- NAVIGATION MENU -->
    <div class="flex-1 px-3 py-4 space-y-2">

        <!-- DASHBOARD -->
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.dashboard') ? 'bg-red-500 text-white' : 'hover:bg-red-700' }}">
            <i data-lucide="layout-dashboard"></i>
            Dashboard
        </a>

        <!-- KREDENSIAL -->
        <a href="{{ route('admin.kredensial.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.kredensial.*') ? 'bg-red-500 text-white' : 'hover:bg-red-700' }}">
            <i data-lucide="key"></i>
            Kredensial
        </a>

        <!-- DATA NEGARA -->
        <a href="{{ route('admin.negara') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.negara') ? 'bg-red-500 text-white' : 'hover:bg-red-700' }}">
            <i data-lucide="globe"></i>
            Data Negara
        </a>

        <!-- LAPORAN -->
        <a href="{{ route('admin.laporan') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.laporan') ? 'bg-red-500 text-white' : 'hover:bg-red-700' }}">
            <i data-lucide="file-text"></i>
            Laporan Akses
        </a>

        <!-- NOTIFIKASI -->
        <a href="{{ route('admin.notifikasi') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.notifikasi') ? 'bg-red-500 text-white' : 'hover:bg-red-700' }}">
            <i data-lucide="bell"></i>
            Notifikasi
        </a>

        <!-- PENGATURAN -->
        <a href="{{ route('admin.pengaturan') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.pengaturan') ? 'bg-red-500 text-white' : 'hover:bg-red-700' }}">
            <i data-lucide="settings"></i>
            Pengaturan
        </a>

    </div>

    <!-- FOOTER -->
    <div class="p-4 border-t border-red-700 text-xs text-red-200">
        SISTEM AMAN • AES-256 <br>
        Auto-logout: 8 jam
    </div>

</nav>


<!-- TOPBAR -->
<div class="ml-64 bg-red-700 text-white h-16 flex items-center justify-between px-6">

    <div class="font-semibold">
        SISTEM KKO | Dashboard
    </div>

    <div class="flex items-center gap-4">
        <span class="text-sm">ADMINISTRATOR</span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm hover:underline">Logout</button>
        </form>
    </div>

</div>