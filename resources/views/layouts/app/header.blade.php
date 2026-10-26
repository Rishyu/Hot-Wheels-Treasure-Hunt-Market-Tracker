@props([
    'title' => null,
])

<!DOCTYPE html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="light"
>

<head>
    @include('partials.head')

    {{-- Force the project UI to use the light proposal theme. --}}
    <script>
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
    </script>
</head>

<body class="min-h-screen bg-[#e9eef5] text-slate-900">


    {{-- =====================================================
         MAIN HEADER
    ====================================================== --}}

    <header
        class="
            sticky
            top-0
            z-40
            border-b
            border-blue-800/20
            bg-[#1268d1]
            shadow-sm
        "
    >

        <div
            class="
                mx-auto
                flex
                min-h-[72px]
                max-w-[1480px]
                items-center
                gap-5
                px-4
                sm:px-6
                lg:px-8
            "
        >

            {{-- Mobile navigation button --}}

            <flux:sidebar.toggle
                class="mr-1 text-white lg:hidden"
                icon="bars-2"
                inset="left"
            />


            {{-- Hot Wheels Market Tracker Logo --}}

            <a
                href="{{ route('dashboard') }}"
                class="
                    flex
                    shrink-0
                    items-center
                    rounded-lg
                    px-1
                    py-1
                    transition
                    hover:bg-white/5
                "
            >

                <img
                    src="{{ asset(
                        'images/hot-wheels-market-tracker-logo.png'
                    ) }}"
                    alt="Hot Wheels Market Tracker"
                    class="
                        h-[54px]
                        w-auto
                        object-contain
                        sm:h-[58px]
                    "
                >

            </a>


            {{-- =================================================
                 DESKTOP NAVIGATION
            ================================================== --}}

            <nav
                class="
                    hidden
                    flex-1
                    items-center
                    justify-center
                    gap-1
                    lg:flex
                "
            >

                <a
                    href="{{ route('dashboard') }}"
                    class="
                        rounded-lg
                        px-4
                        py-2.5
                        text-sm
                        font-bold
                        transition

                        {{ request()->routeIs('dashboard')
                            ? 'bg-white/15 text-yellow-300'
                            : 'text-white hover:bg-white/10'
                        }}
                    "
                >
                    Dashboard
                </a>


                <a
                    href="{{ route('cars.index') }}"
                    class="
                        rounded-lg
                        px-4
                        py-2.5
                        text-sm
                        font-bold
                        transition

                        {{ request()->routeIs('cars.*')
                            ? 'bg-white/15 text-yellow-300'
                            : 'text-white hover:bg-white/10'
                        }}
                    "
                >
                    Browse Cars
                </a>


                <a
                    href="{{ route('profile.edit') }}#favorites"
                    class="
                        rounded-lg
                        px-4
                        py-2.5
                        text-sm
                        font-bold
                        text-white
                        transition
                        hover:bg-white/10
                    "
                >
                    Favorites
                </a>


                <a
                    href="{{ route('profile.edit') }}"
                    class="
                        rounded-lg
                        px-4
                        py-2.5
                        text-sm
                        font-bold
                        transition

                        {{ request()->routeIs('profile.edit')
                            ? 'bg-white/15 text-yellow-300'
                            : 'text-white hover:bg-white/10'
                        }}
                    "
                >
                    Profile
                </a>


                @if (auth()->user()?->isAdministrator())

                    <a
                        href="{{ route('admin.index') }}"
                        class="
                            rounded-lg
                            px-4
                            py-2.5
                            text-sm
                            font-bold
                            transition

                            {{ request()->routeIs('admin.*')
                                ? 'bg-white/15 text-yellow-300'
                                : 'text-white hover:bg-white/10'
                            }}
                        "
                    >
                        Admin
                    </a>

                @endif

            </nav>


            {{-- =================================================
                 USER MENU
            ================================================== --}}

            <div class="ml-auto shrink-0">

                <x-desktop-user-menu />

            </div>

        </div>

    </header>


    {{-- =====================================================
         MOBILE SIDEBAR
    ====================================================== --}}

    <flux:sidebar
        collapsible="mobile"
        sticky
        class="
            border-e
            border-slate-200
            bg-white
            text-slate-900
            lg:hidden
        "
    >

        <flux:sidebar.header>

            <a
                href="{{ route('dashboard') }}"
                class="
                    flex
                    items-center
                    px-2
                    py-2
                "
            >

                <img
                    src="{{ asset(
                        'images/hot-wheels-market-tracker-logo.png'
                    ) }}"
                    alt="Hot Wheels Market Tracker"
                    class="
                        h-14
                        w-auto
                        object-contain
                    "
                >

            </a>


            <flux:sidebar.collapse />

        </flux:sidebar.header>


        <flux:sidebar.nav>

            <flux:sidebar.group
                :heading="__('Navigation')"
            >

                <flux:sidebar.item
                    icon="home"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                >
                    Dashboard
                </flux:sidebar.item>


                <flux:sidebar.item
                    icon="magnifying-glass"
                    :href="route('cars.index')"
                    :current="request()->routeIs('cars.*')"
                >
                    Browse Cars
                </flux:sidebar.item>


                <flux:sidebar.item
                    icon="heart"
                    :href="route('profile.edit') . '#favorites'"
                >
                    Favorites
                </flux:sidebar.item>


                <flux:sidebar.item
                    icon="user"
                    :href="route('profile.edit')"
                    :current="request()->routeIs('profile.edit')"
                >
                    Profile
                </flux:sidebar.item>

            </flux:sidebar.group>


            @if (auth()->user()?->isAdministrator())

                <flux:sidebar.group
                    :heading="__('Administrator')"
                >

                    <flux:sidebar.item
                        icon="shield-check"
                        :href="route('admin.index')"
                        :current="request()->routeIs('admin.index')"
                    >
                        Admin Dashboard
                    </flux:sidebar.item>


                    <flux:sidebar.item
                        icon="wrench"
                        :href="route('admin.cars.index')"
                        :current="request()->routeIs('admin.cars.*')"
                    >
                        Manage Cars
                    </flux:sidebar.item>


                    <flux:sidebar.item
                        icon="check-circle"
                        :href="route('admin.pricing.index')"
                        :current="request()->routeIs(
                            'admin.pricing.*'
                        )"
                    >
                        Review Pricing
                    </flux:sidebar.item>


                    <flux:sidebar.item
                        icon="document-text"
                        :href="route('admin.logs.index')"
                        :current="request()->routeIs('admin.logs.*')"
                    >
                        Error Logs
                    </flux:sidebar.item>

                </flux:sidebar.group>

            @endif

        </flux:sidebar.nav>


        <flux:spacer />


        <flux:sidebar.nav>

            <flux:sidebar.group
                :heading="__('Account')"
            >

                <flux:sidebar.item
                    icon="lock-closed"
                    :href="route('security.edit')"
                >
                    Security
                </flux:sidebar.item>

            </flux:sidebar.group>

        </flux:sidebar.nav>

    </flux:sidebar>


    {{-- =====================================================
         PAGE CONTENT
    ====================================================== --}}

    <main
        class="
            min-h-[calc(100vh-72px)]
            bg-[#e9eef5]
            text-slate-900
        "
    >

        <div
            class="
                mx-auto
                max-w-[1480px]
                px-4
                py-8
                sm:px-6
                lg:px-8
                lg:py-10
            "
        >

            {{ $slot }}

        </div>

    </main>


    {{-- =====================================================
         TOASTS
    ====================================================== --}}

    @persist('toast')

        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>

    @endpersist


    @fluxScripts

</body>

</html>