<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        .sidebar-collapsed .sidebar-text { display: none; }

        .sidebar-collapsed .menu-item {
            justify-content: center;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .sidebar-collapsed .menu-item span:first-child {
            margin: 0 auto;
        }

        .sidebar-collapsed .sidebar-logo-text,
        .sidebar-collapsed .sidebar-user,
        .sidebar-collapsed .sidebar-footer-text {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <div id="sidebar" class="w-64 h-screen bg-[#1A0000] text-white fixed flex flex-col transition-all duration-300">

        @php
        function active($path) {
            return request()->is($path) ? 'bg-red-600' : 'hover:bg-red-700';
        }
        @endphp

        <!-- HEADER -->
        <div class="px-5 py-4 border-b border-red-900 flex items-center gap-2">
            🛡️ <span class="sidebar-logo-text font-semibold">SISTEM KKO</span>
        </div>

        <!-- USER -->
        <div class="px-5 py-4 sidebar-user">
            <div class="bg-[#7A1717] border border-red-500 rounded-xl p-3">
                <p class="font-semibold text-sm">Administrator</p>
                <p class="text-xs text-red-300">Sesi Aktif</p>
            </div>
        </div>

        <!-- MENU -->
        <div class="flex-1 px-3 space-y-2 text-sm">

            <a href="/admin/dashboard" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl {{ active('admin/dashboard') }}">
                📊 <span class="sidebar-text">Dashboard</span>
            </a>

            <a href="/admin/kredensial" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl {{ active('admin/kredensial*') }}">
                🔑 <span class="sidebar-text">Kredensial</span>
            </a>

            <a href="/admin/negara" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl {{ active('admin/negara*') }}">
                🌍 <span class="sidebar-text">Data Negara</span>
            </a>

            <a href="/admin/laporan" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl {{ active('admin/laporan*') }}">
                📄 <span class="sidebar-text">Laporan Akses</span>
            </a>

            <a href="/admin/notifikasi" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl {{ active('admin/notifikasi*') }}">
                🔔 <span class="sidebar-text">Notifikasi</span>
            </a>

            <a href="/admin/pengaturan" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl {{ active('admin/pengaturan*') }}">
                ⚙ <span class="sidebar-text">Pengaturan</span>
            </a>

        </div>

    </div>

    <!-- CONTENT -->
    <div id="main-content" class="ml-64 w-full transition-all duration-300">

        <!-- NAVBAR -->
        <div class="bg-[#7A1717] text-white px-6 py-3 flex justify-between">

            <div class="flex items-center gap-2">
                <span class="font-semibold">SISTEM KKO</span>
                <span>|</span>
                <span class="text-sm capitalize">
                    {{ request()->segment(2) ?? 'dashboard' }}
                </span>
            </div>

            <div class="flex items-center gap-4 text-sm">

                <div class="bg-[#8F1D1D] px-3 py-1 rounded-full">
                    Sesi aktif • Auto-logout 8j
                </div>

                <div class="bg-[#8F1D1D] px-3 py-1 rounded-full">
                    ADMINISTRATOR
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-200">Logout</button>
                </form>

            </div>

        </div>

        <!-- PAGE -->
        <div class="p-6">
            @yield('content')
        </div>

    </div>

</div>

<!-- SIDEBAR SCRIPT -->
<script>
let collapsed = false;

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('main-content');

    sidebar.classList.toggle('sidebar-collapsed');

    if (!collapsed) {
        sidebar.classList.replace('w-64','w-20');
        content.classList.replace('ml-64','ml-20');
        collapsed = true;
    } else {
        sidebar.classList.replace('w-20','w-64');
        content.classList.replace('ml-20','ml-64');
        collapsed = false;
    }
}
</script>

</body>
</html>