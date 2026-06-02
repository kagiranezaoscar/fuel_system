<nav x-data="{ open: false }" class="bg-white border-b border-orange-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-bold text-slate-950">
                        <span class="rounded-md bg-slate-950 px-2.5 py-1.5 text-white shadow-sm"><span class="text-white">OSC</span> <span class="text-orange-400">ENERGY</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if(Auth::user()->isManager())
                        <x-nav-link :href="route('manager.fuel-types.index')" :active="request()->routeIs('manager.fuel-types.*')">Fuel Types & Prices</x-nav-link>
                        <x-nav-link :href="route('manager.stock.index')" :active="request()->routeIs('manager.stock.*')">Stock</x-nav-link>
                        <x-nav-link :href="route('manager.sales.index')" :active="request()->routeIs('manager.sales.*')">Sales</x-nav-link>
                        <x-nav-link :href="route('manager.customers.index')" :active="request()->routeIs('manager.customers.*')">Customers</x-nav-link>
                        <x-nav-link :href="route('manager.reports.index')" :active="request()->routeIs('manager.reports.*')">Reports</x-nav-link>
                    @else
                        <x-nav-link :href="route('customer.purchases.index')" :active="request()->routeIs('customer.purchases.*')">Purchases</x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-orange-100 text-sm leading-4 font-medium rounded-md text-slate-700 bg-orange-50 hover:bg-orange-100 hover:text-slate-950 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-600 hover:text-slate-950 hover:bg-orange-50 focus:outline-none focus:bg-orange-50 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(Auth::user()->isManager())
                <x-responsive-nav-link :href="route('manager.fuel-types.index')" :active="request()->routeIs('manager.fuel-types.*')">Fuel Types & Prices</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manager.stock.index')" :active="request()->routeIs('manager.stock.*')">Stock</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manager.sales.index')" :active="request()->routeIs('manager.sales.*')">Sales</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manager.customers.index')" :active="request()->routeIs('manager.customers.*')">Customers</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manager.reports.index')" :active="request()->routeIs('manager.reports.*')">Reports</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('customer.purchases.index')" :active="request()->routeIs('customer.purchases.*')">Purchases</x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-orange-100">
            <div class="px-4">
                <div class="font-medium text-base text-slate-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
