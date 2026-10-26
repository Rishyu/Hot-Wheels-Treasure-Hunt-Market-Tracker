<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="dark"
>
<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-zinc-950 text-zinc-100">

    <flux:sidebar
        sticky
        collapsible="mobile"
        class="
            border-e
            border-zinc-800
            bg-zinc-950
        "
    >

        {{-- Brand --}}

        <flux:sidebar.header>

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-2 py-3"
            >

                <div
                    class="
                        flex
                        h-10
                        w-10
                        items-center
                        justify-center
                        rounded-xl
                        bg-orange-500
                        font-black
                        text-white
                        shadow-lg
                    "
                >
                    HW
                </div>

                <div>

                    <div
                        class="
                            text-sm
                            font-black
                            tracking-wide
                            text-white
                        "
                    >
                        HOT WHEELS
                    </div>

                    <div
                        class="
                            text-xs
                            font-medium
                            text-orange-400
                        "
                    >
                        MARKET TRACKER
                    </div>

                </div>

            </a>

            <flux:sidebar.collapse
                class="lg:hidden"
            />

        </flux:sidebar.header>


        {{-- Collector Navigation --}}

        <flux:sidebar.nav>

            <flux:sidebar.group
                :heading="__('COLLECT')"
                class="grid"
            >

                <flux:sidebar.item
                    icon="home"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    wire:navigate
                >
                    {{ __('Dashboard') }}
                </flux:sidebar.item>


                <flux:sidebar.item
                    icon="magnifying-glass"
                    :href="route('cars.index')"
                    :current="request()->routeIs('cars.*')"
                >
                    {{ __('Browse Cars') }}
                </flux:sidebar.item>


                <flux:sidebar.item
                    icon="heart"
                    :href="route('profile.edit')"
                    :current="request()->routeIs('profile.edit')"
                >
                    {{ __('Favorites & Profile') }}
                </flux:sidebar.item>

            </flux:sidebar.group>

        </flux:sidebar.nav>


        {{-- Administrator Navigation --}}

        @if (auth()->user()?->isAdministrator())

            <flux:sidebar.nav>

                <flux:sidebar.group
                    :heading="__('ADMINISTRATION')"
                    class="grid"
                >

                    <flux:sidebar.item
                        icon="shield-check"
                        :href="route('admin.index')"
                        :current="request()->routeIs('admin.index')"
                    >
                        {{ __('Admin Dashboard') }}
                    </flux:sidebar.item>


                    <flux:sidebar.item
                        icon="wrench"
                        :href="route('admin.cars.index')"
                        :current="request()->routeIs('admin.cars.*')"
                    >
                        {{ __('Manage Cars') }}
                    </flux:sidebar.item>


                    <flux:sidebar.item
                        icon="check-circle"
                        :href="route('admin.pricing.index')"
                        :current="request()->routeIs('admin.pricing.*')"
                    >
                        {{ __('Review Pricing') }}
                    </flux:sidebar.item>


                    <flux:sidebar.item
                        icon="document-text"
                        :href="route('admin.logs.index')"
                        :current="request()->routeIs('admin.logs.*')"
                    >
                        {{ __('Error Logs') }}
                    </flux:sidebar.item>

                </flux:sidebar.group>

            </flux:sidebar.nav>

        @endif


        <flux:spacer />


        {{-- Account Navigation --}}

        <flux:sidebar.nav>

            <flux:sidebar.group
                :heading="__('ACCOUNT')"
                class="grid"
            >

                <flux:sidebar.item
                    icon="user"
                    :href="route('profile.edit')"
                    :current="request()->routeIs('profile.edit')"
                >
                    {{ __('Profile') }}
                </flux:sidebar.item>


                <flux:sidebar.item
                    icon="lock-closed"
                    :href="route('security.edit')"
                    :current="request()->routeIs('security.edit')"
                >
                    {{ __('Security') }}
                </flux:sidebar.item>

            </flux:sidebar.group>

        </flux:sidebar.nav>


        <x-desktop-user-menu />

    </flux:sidebar>


    {{-- Mobile Header --}}

    <flux:header
        class="
            border-b
            border-zinc-800
            bg-zinc-950
            lg:hidden
        "
    >

        <flux:sidebar.toggle
            class="lg:hidden"
            icon="bars-2"
            inset="left"
        />


        <div class="ml-2">

            <div class="text-sm font-black">
                HOT WHEELS
            </div>

            <div class="text-xs text-orange-400">
                MARKET TRACKER
            </div>

        </div>


        <flux:spacer />


        <flux:dropdown
            position="top"
            align="end"
        >

            <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
            />


            <flux:menu>

                <flux:menu.radio.group>

                    <div class="p-0 text-sm font-normal">

                        <div
                            class="
                                flex
                                items-center
                                gap-2
                                px-1
                                py-1.5
                            "
                        >

                            <span
                                class="
                                    relative
                                    flex
                                    h-8
                                    w-8
                                    shrink-0
                                    overflow-hidden
                                    rounded-lg
                                "
                            >

                                <span
                                    class="
                                        flex
                                        h-full
                                        w-full
                                        items-center
                                        justify-center
                                        rounded-lg
                                        bg-orange-500
                                        text-white
                                    "
                                >
                                    {{ auth()->user()->initials() }}
                                </span>

                            </span>


                            <div
                                class="
                                    grid
                                    flex-1
                                    text-start
                                    text-sm
                                    leading-tight
                                "
                            >

                                <span
                                    class="
                                        truncate
                                        font-semibold
                                    "
                                >
                                    {{ auth()->user()->username
                                        ?? auth()->user()->name }}
                                </span>

                                <span
                                    class="
                                        truncate
                                        text-xs
                                        text-zinc-400
                                    "
                                >
                                    {{ auth()->user()->email }}
                                </span>

                            </div>

                        </div>

                    </div>

                </flux:menu.radio.group>


                <flux:menu.separator />


                <flux:menu.item
                    :href="route('profile.edit')"
                    icon="cog"
                >
                    {{ __('Settings') }}
                </flux:menu.item>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <flux:menu.item
                        as="button"
                        type="submit"
                        icon="arrow-right-start-on-rectangle"
                        class="w-full"
                    >
                        {{ __('Log Out') }}
                    </flux:menu.item>

                </form>

            </flux:menu>

        </flux:dropdown>

    </flux:header>


    <flux:main class="hw-page">
        {{ $slot }}
    </flux:main>


    @fluxScripts

</body>
</html>