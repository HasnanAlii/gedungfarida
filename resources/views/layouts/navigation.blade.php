<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
              <div class="shrink-0 flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-orange-600" />
                        <span class="font-bold text-xl text-orange-600 tracking-wide">
                            Gedung Farida
                        </span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden sm:flex sm:space-x-8 sm:ms-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="hover:text-orange-600 hover:border-orange-500">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Admin --}}
                    @hasrole('admin')
                        <x-nav-link :href="route('halls.index')" :active="request()->routeIs('halls.*')" 
                            class="hover:text-orange-600 hover:border-orange-500">
                            {{ __('Gedung') }}
                        </x-nav-link>
                        <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')" 
                            class="hover:text-orange-600 hover:border-orange-500">
                            {{ __('Layanan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')" 
                            class="hover:text-orange-600 hover:border-orange-500">
                            {{ __('Jadwal Gedung') }}
                        </x-nav-link>
                   
                    @endhasrole

                    {{-- Customer --}}
                    @hasrole('customer')
                        <x-nav-link :href="route('calendars.indexx')" :active="request()->routeIs('calendars.*')" 
                            class="hover:text-orange-600 hover:border-orange-500">
                            {{ __('Jadwal Gedung') }}
                        </x-nav-link>
                    @endhasrole

                    {{-- All Users --}}
                    <x-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.*')" 
                        class="hover:text-orange-600 hover:border-orange-500">
                        {{ __('Reservasi') }}
                    </x-nav-link>
                    <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')" 
                        class="hover:text-orange-600 hover:border-orange-500">
                        {{ __('Pembayaran') }}
                    </x-nav-link>

                        @hasrole('admin')
                      <x-nav-link :href="route('finances.index')" :active="request()->routeIs('finances.*')" 
                            class="hover:text-orange-600 hover:border-orange-500">
                            {{ __('Keuangan') }}
                        </x-nav-link>
                    @endhasrole
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm 
                                       leading-4 font-medium rounded-md text-gray-600 bg-white 
                                       hover:text-orange-600 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-gray-500 group-hover:text-orange-600" 
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" 
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                                          111.414 1.414l-4 4a1 1 0 
                                          01-1.414 0l-4-4a1 1 0 
                                          010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 
                               hover:text-orange-600 hover:bg-orange-50 focus:outline-none focus:bg-orange-100 focus:text-orange-600">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" 
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" 
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link class="bg-orange-100 text-orange-700 font-semibold rounded-md">
                {{ __('☰ Menu') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- Admin --}}
            @hasrole('admin')
                <x-responsive-nav-link :href="route('halls.index')" :active="request()->routeIs('halls.*')">
                    {{ __('Gedung') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">
                    {{ __('Layanan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')">
                    {{ __('Jadwal Gedung') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('finances.index')" :active="request()->routeIs('finances.*')">
                    {{ __('Keuangan') }}
                </x-responsive-nav-link>
            @endhasrole

            {{-- Customer --}}
            @hasrole('customer')
                <x-responsive-nav-link :href="route('calendars.indexx')" :active="request()->routeIs('calendars.*')">
                    {{ __('Jadwal Gedung') }}
                </x-responsive-nav-link>
            @endhasrole

            {{-- All Users --}}
            <x-responsive-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.*')">
                {{ __('Reservasi') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')">
                {{ __('Pembayaran') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-1 pb-1 border-t border-gray-200">
            <div class="px-4 py-2 bg-orange-50 rounded-md mb-2">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
