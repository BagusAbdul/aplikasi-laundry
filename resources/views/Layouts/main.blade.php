<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Wash&Go' }} - Aplikasi Laundry</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">

        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-blue-800 text-white transition-all duration-300 flex flex-col">
            <div class="p-6 text-center font-bold text-xl border-b border-blue-700">
                <span x-show="sidebarOpen">Wash&Go</span>
                <span x-show="!sidebarOpen">W&G</span>
            </div>

            <nav class="flex-1 mt-5 px-4 space-y-2">
                @php $role = Auth::user()->role->nama_role; @endphp

                <a href="/{{ $role }}/dashboard" class="flex items-center p-2 rounded-lg hover:bg-blue-700 {{ Request::is('*/dashboard') ? 'bg-blue-900' : '' }}">
                    <span class="ml-3" x-show="sidebarOpen">Dashboard</span>
                </a>

                @if($role == 'admin')
                <div class="text-xs text-blue-300 mt-4 px-2 uppercase" x-show="sidebarOpen">Manajemen Data</div>
                <a href="{{ route('admin.outlet.index') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700">
                    <span class="ml-3" x-show="sidebarOpen">Outlet</span>
                </a>
                <a href="{{ route('admin.paket.index') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700">
                    <span class="ml-3" x-show="sidebarOpen">Paket Cucian</span>
                </a>
                <a href="{{ route('admin.user.index') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700">
                    <span class="ml-3" x-show="sidebarOpen">Pengguna</span>
                </a>
                <div class="text-xs text-blue-300 mt-4 px-2 uppercase" x-show="sidebarOpen">Transaksi</div>
                <a href="{{ route('admin.member.index') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 {{ Request::is('*/member*') ? 'bg-blue-900' : '' }}">
                    <span class="ml-3" x-show="sidebarOpen">Registrasi Member</span>
                </a>
                <a href="{{ route('kasir.transaksi.index') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700">
                    <span class="ml-3" x-show="sidebarOpen">Entri Transaksi</span>
                </a>

                @endif

                @if($role == 'kasir')
                <div class="text-xs text-blue-300 mt-4 px-2 uppercase" x-show="sidebarOpen">Transaksi</div>
                <a href="{{ route('kasir.member.index') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 {{ Request::is('*/member*') ? 'bg-blue-900' : '' }}">
                    <span class="ml-3" x-show="sidebarOpen">Registrasi Member</span>
                </a>
                <a href="{{ route('kasir.transaksi.index') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700">
                    <span class="ml-3" x-show="sidebarOpen">Entri Transaksi</span>
                </a>
                @endif

                <div class="text-xs text-blue-300 mt-4 px-2 uppercase" x-show="sidebarOpen">Laporan</div>
                <a href="{{ route('owner.laporan.index') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700">
                    <span class="ml-3" x-show="sidebarOpen">Generate Laporan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-blue-700">
                <div class="flex items-center mb-4" x-show="sidebarOpen">
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-semibold leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-blue-300 leading-none mt-1">{{ ucfirst($role) }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left p-2 rounded-lg hover:bg-red-600 transition">
                        <span x-show="sidebarOpen">Keluar</span>
                        <span x-show="!sidebarOpen">🚀</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="text-sm font-medium text-gray-600">
                    Outlet: <span class="text-blue-600">{{ Auth::user()->outlet->nama_outlet }}</span>
                </div>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
