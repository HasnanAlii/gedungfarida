<nav
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100
           transform transition-transform duration-300
           lg:static lg:translate-x-0
           flex flex-col h-full">

    {{-- ================= HEADER / LOGO ================= --}}
    <div class="px-6 py-6 flex items-center gap-3 shrink-0 relative">
        <button @click="sidebarOpen = false"
                class="lg:hidden absolute top-4 right-4 text-gray-500 hover:text-orange-600">
            {{-- <i data-feather="x"></i> --}}
        </button>

        <div class="p-2 bg-orange-50 rounded-lg">
            <x-application-logo class="h-8 w-8 text-orange-600" />
        </div>
        <div>
            <div class="text-lg font-bold text-gray-800 leading-tight">Gedung Farida</div>
            <div class="text-xs font-semibold text-orange-500 uppercase tracking-wider">
                @hasrole('admin') Admin Panel @endhasrole
                @hasrole('customer') Customer Panel @endhasrole
            </div>
        </div>
    </div>

    {{-- ================= MENU (SCROLLABLE) ================= --}}
    <div class="flex-1 overflow-y-auto custom-scrollbar px-4 pb-6">

        {{-- MENU UTAMA --}}
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
            Menu Utama
        </p>

        <ul class="space-y-1">
            {{-- Dashboard --}}
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
                   {{ request()->routeIs('dashboard')
                       ? 'bg-orange-600 text-white shadow shadow-orange-200'
                       : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    <i data-feather="grid"
                       class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400' }}"></i>
                    Dashboard
                </a>
            </li>

            @hasrole('admin')
                <li>
                    <a href="{{ route('halls.index') }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
                       {{ request()->routeIs('halls.*')
                           ? 'bg-orange-600 text-white shadow shadow-orange-200'
                           : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                        <i data-feather="home" class="w-5 h-5"></i>
                        Gedung
                    </a>
                </li>
                 <li>
                    <a href="{{ route('galleries.index') }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
                       {{ request()->routeIs('galleries.*')
                           ? 'bg-orange-600 text-white shadow shadow-orange-200'
                           : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                        <i data-feather="image" class="w-5 h-5"></i>
                        Galery
                    </a>
                </li>

                <li>
                    <a href="{{ route('services.index') }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
                       {{ request()->routeIs('services.*')
                           ? 'bg-orange-600 text-white shadow shadow-orange-200'
                           : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                        <i data-feather="layers" class="w-5 h-5"></i>
                        Layanan
                    </a>
                </li>

                <li>
                    <a href="{{ route('calendar.index') }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
                       {{ request()->routeIs('calendar.*')
                           ? 'bg-orange-600 text-white shadow shadow-orange-200'
                           : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                        <i data-feather="calendar" class="w-5 h-5"></i>
                        Jadwal Gedung
                    </a>
                </li>
            @endhasrole

            @hasrole('customer')
                <li>
                    <a href="{{ route('calendars.indexx') }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
                       {{ request()->routeIs('calendars.*')
                           ? 'bg-orange-600 text-white shadow shadow-orange-200'
                           : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                        <i data-feather="calendar" class="w-5 h-5"></i>
                        Jadwal Gedung
                    </a>
                </li>
            @endhasrole
        </ul>

        {{-- TRANSAKSI --}}
        <p class="px-4 pt-6 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
            Transaksi
        </p>

        <ul class="space-y-1">
            <li>
                <a href="{{ route('reservations.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
                   {{ request()->routeIs('reservations.*')
                       ? 'bg-orange-600 text-white shadow shadow-orange-200'
                       : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    <i data-feather="bookmark" class="w-5 h-5"></i>
                    Reservasi
                </a>
            </li>

            <li>
                <a href="{{ route('payments.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
                   {{ request()->routeIs('payments.*')
                       ? 'bg-orange-600 text-white shadow shadow-orange-200'
                       : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    <i data-feather="credit-card" class="w-5 h-5"></i>
                    Pembayaran
                </a>
            </li>

            @hasrole('admin')
                <li>
                    <a href="{{ route('finances.index') }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
                       {{ request()->routeIs('finances.*')
                           ? 'bg-orange-600 text-white shadow shadow-orange-200'
                           : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                        <i data-feather="trending-up" class="w-5 h-5"></i>
                        Keuangan
                    </a>
                </li>
            @endhasrole
        </ul>
    </div>

    {{-- ================= FOOTER (FIXED BOTTOM) ================= --}}
    <div class="border-t border-gray-100 bg-gray-50 p-4 shrink-0">
        <div class="flex items-center gap-3 mb-4">
            <div class="h-10 w-10 rounded-full bg-white border border-orange-100 shadow
                        flex items-center justify-center text-orange-600 font-bold uppercase">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="min-w-0">
                <div class="text-sm font-bold text-gray-800 truncate">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-xs text-gray-500 truncate">
                    {{ Auth::user()->email }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('profile.edit') }}"
               class="flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold
                      bg-white border rounded-lg text-gray-700
                      hover:bg-orange-50 hover:text-orange-600 transition">
                <i data-feather="user" class="w-3 h-3"></i>
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="w-full flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold
                           bg-white border border-red-200 rounded-lg text-red-600
                           hover:bg-red-50 hover:text-red-700 transition">
                    <i data-feather="log-out" class="w-3 h-3"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
