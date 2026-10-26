<!DOCTYPE html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="light"
>

<head>
    @include('partials.head')

    {{-- Authentication pages always use the project light theme. --}}
    <script>
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
    </script>
</head>


<body
    class="
        min-h-screen
        bg-[#e9eef5]
        text-slate-900
        antialiased
    "
>

    <div
        class="
            relative
            flex
            min-h-screen
            overflow-hidden
        "
    >

        {{-- =====================================================
             DESKTOP BRAND PANEL
        ====================================================== --}}

        <aside
            class="
                relative
                hidden
                w-[46%]
                overflow-hidden
                bg-gradient-to-br
                from-[#0755aa]
                via-[#1268d1]
                to-[#1881df]
                lg:flex
                lg:flex-col
                lg:justify-between
                lg:p-12
                xl:p-16
            "
        >

            {{-- Decorative background shapes --}}

            <div
                class="
                    absolute
                    -right-28
                    -top-28
                    h-96
                    w-96
                    rounded-full
                    bg-white/10
                "
            ></div>

            <div
                class="
                    absolute
                    -bottom-36
                    -left-32
                    h-[420px]
                    w-[420px]
                    rounded-full
                    bg-yellow-300/10
                "
            ></div>

            <div
                class="
                    absolute
                    bottom-28
                    right-12
                    h-40
                    w-40
                    rotate-12
                    rounded-[40px]
                    border
                    border-white/10
                    bg-white/5
                "
            ></div>


            {{-- Brand --}}

            <a
                href="{{ route('home') }}"
                class="
                    relative
                    z-10
                    inline-flex
                    w-fit
                    items-center
                "
            >

                <img
                    src="{{ asset(
                        'images/hot-wheels-market-tracker-logo.png'
                    ) }}"
                    alt="Hot Wheels Market Tracker"
                    class="
                        h-24
                        w-auto
                        object-contain
                    "
                >

            </a>


            {{-- Marketing text --}}

            <div
                class="
                    relative
                    z-10
                    max-w-xl
                "
            >

                <p
                    class="
                        text-sm
                        font-black
                        uppercase
                        tracking-[0.18em]
                        text-yellow-300
                    "
                >
                    Treasure Hunt Market Data
                </p>

                <h1
                    class="
                        mt-4
                        text-4xl
                        font-black
                        leading-tight
                        tracking-tight
                        text-white
                        xl:text-5xl
                    "
                >
                    Track the cars collectors are hunting for.
                </h1>

                <p
                    class="
                        mt-5
                        max-w-lg
                        text-base
                        leading-7
                        text-blue-100
                        xl:text-lg
                    "
                >
                    Research Treasure Hunt and Super Treasure Hunt
                    Hot Wheels, save favorites, and compare
                    administrator-approved market prices.
                </p>


                <div
                    class="
                        mt-8
                        grid
                        max-w-lg
                        grid-cols-3
                        gap-3
                    "
                >

                    <div
                        class="
                            rounded-xl
                            border
                            border-white/15
                            bg-white/10
                            p-4
                            backdrop-blur-sm
                        "
                    >

                        <p
                            class="
                                text-2xl
                                font-black
                                text-yellow-300
                            "
                        >
                            TH
                        </p>

                        <p
                            class="
                                mt-1
                                text-xs
                                font-semibold
                                text-blue-100
                            "
                        >
                            Treasure Hunts
                        </p>

                    </div>


                    <div
                        class="
                            rounded-xl
                            border
                            border-white/15
                            bg-white/10
                            p-4
                            backdrop-blur-sm
                        "
                    >

                        <p
                            class="
                                text-2xl
                                font-black
                                text-red-300
                            "
                        >
                            STH
                        </p>

                        <p
                            class="
                                mt-1
                                text-xs
                                font-semibold
                                text-blue-100
                            "
                        >
                            Super Treasure Hunts
                        </p>

                    </div>


                    <div
                        class="
                            rounded-xl
                            border
                            border-white/15
                            bg-white/10
                            p-4
                            backdrop-blur-sm
                        "
                    >

                        <p
                            class="
                                text-2xl
                                font-black
                                text-white
                            "
                        >
                            $
                        </p>

                        <p
                            class="
                                mt-1
                                text-xs
                                font-semibold
                                text-blue-100
                            "
                        >
                            Market Prices
                        </p>

                    </div>

                </div>

            </div>


            {{-- Footer --}}

            <p
                class="
                    relative
                    z-10
                    text-xs
                    text-blue-200
                "
            >
                Hot Wheels Treasure Hunt Market Tracker
            </p>

        </aside>


        {{-- =====================================================
             LOGIN / REGISTER AREA
        ====================================================== --}}

        <main
            class="
                relative
                flex
                min-h-screen
                flex-1
                items-center
                justify-center
                px-4
                py-10
                sm:px-6
                lg:px-10
            "
        >

            {{-- Mobile decorative background --}}

            <div
                class="
                    absolute
                    inset-x-0
                    top-0
                    h-44
                    bg-gradient-to-r
                    from-[#0755aa]
                    to-[#1976d2]
                    lg:hidden
                "
            ></div>


            {{-- Authentication card --}}

            <div
                class="
                    relative
                    z-10
                    w-full
                    max-w-[470px]
                "
            >

                {{-- Mobile logo --}}

                <a
                    href="{{ route('home') }}"
                    class="
                        mb-5
                        flex
                        justify-center
                        lg:hidden
                    "
                >

                    <img
                        src="{{ asset(
                            'images/hot-wheels-market-tracker-logo.png'
                        ) }}"
                        alt="Hot Wheels Market Tracker"
                        class="
                            h-20
                            w-auto
                            object-contain
                        "
                    >

                </a>


                <div
                    class="
                        rounded-2xl
                        border
                        border-slate-200
                        bg-[#fdfefe]
                        p-6
                        shadow-xl
                        shadow-slate-900/10
                        sm:p-8
                    "
                >

                    {{ $slot }}

                </div>


                <p
                    class="
                        mt-5
                        text-center
                        text-xs
                        text-slate-500
                    "
                >
                    Hot Wheels Treasure Hunt Market Tracker
                </p>

            </div>

        </main>

    </div>


    @persist('toast')

        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>

    @endpersist


    @fluxScripts

</body>

</html>
