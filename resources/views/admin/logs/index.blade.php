<x-layouts::app :title="__('System Error Logs')">

    <div class="space-y-7 text-slate-900">

        {{-- Header --}}

        <section
            class="
                rounded-2xl
                bg-gradient-to-r
                from-[#0b57a8]
                to-[#1976d2]
                px-6
                py-7
                text-white
                shadow-md
                lg:px-8
            "
        >

            <div
                class="
                    flex
                    flex-col
                    gap-5
                    md:flex-row
                    md:items-center
                    md:justify-between
                "
            >

                <div>

                    <p
                        class="
                            text-sm
                            font-bold
                            uppercase
                            tracking-[0.14em]
                            text-yellow-300
                        "
                    >
                        Administrator
                    </p>

                    <h1
                        class="
                            mt-1
                            text-3xl
                            font-black
                            text-white
                        "
                    >
                        System Error Logs
                    </h1>

                    <p
                        class="
                            mt-2
                            max-w-2xl
                            text-blue-100
                        "
                    >
                        Review recent Laravel application
                        errors and system messages.
                    </p>

                </div>


                <a
                    href="{{ route('admin.index') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        rounded-lg
                        bg-yellow-400
                        px-5
                        py-3
                        font-black
                        text-slate-900
                        shadow-sm
                        transition
                        hover:bg-yellow-300
                    "
                >
                    ← Admin Dashboard
                </a>

            </div>

        </section>


        {{-- Information cards --}}

        <div
            class="
                grid
                gap-5
                md:grid-cols-3
            "
        >

            <div
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    p-5
                    shadow-sm
                "
            >

                <p
                    class="
                        text-sm
                        font-bold
                        text-slate-500
                    "
                >
                    Log Source
                </p>

                <p
                    class="
                        mt-2
                        font-black
                        text-slate-900
                    "
                >
                    Laravel Application
                </p>

            </div>


            <div
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    p-5
                    shadow-sm
                "
            >

                <p
                    class="
                        text-sm
                        font-bold
                        text-slate-500
                    "
                >
                    Display
                </p>

                <p
                    class="
                        mt-2
                        font-black
                        text-slate-900
                    "
                >
                    Latest 200 Lines
                </p>

            </div>


            <div
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    p-5
                    shadow-sm
                "
            >

                <p
                    class="
                        text-sm
                        font-bold
                        text-slate-500
                    "
                >
                    Access
                </p>

                <p
                    class="
                        mt-2
                        font-black
                        text-green-600
                    "
                >
                    Administrator Only
                </p>

            </div>

        </div>


        {{-- Log viewer --}}

        <section
            class="
                overflow-hidden
                rounded-xl
                border
                border-slate-200
                bg-white
                shadow-sm
            "
        >

            <div
                class="
                    flex
                    flex-col
                    gap-3
                    border-b
                    border-slate-200
                    bg-slate-50
                    px-6
                    py-5
                    sm:flex-row
                    sm:items-center
                    sm:justify-between
                "
            >

                <div>

                    <h2
                        class="
                            text-xl
                            font-black
                            text-slate-900
                        "
                    >
                        Recent Log Entries
                    </h2>

                    <p
                        class="
                            mt-1
                            text-sm
                            text-slate-600
                        "
                    >
                        Most recent application activity and errors.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="window.location.reload()"
                    class="
                        rounded-lg
                        border
                        border-slate-300
                        bg-white
                        px-4
                        py-2
                        text-sm
                        font-bold
                        text-slate-700
                        transition
                        hover:bg-slate-100
                    "
                >
                    Refresh Logs
                </button>

            </div>


            @if (
                trim($logContent)
                === 'No application log file exists yet.'
            )

                <div
                    class="
                        px-6
                        py-14
                        text-center
                    "
                >

                    <div
                        class="
                            mx-auto
                            flex
                            h-16
                            w-16
                            items-center
                            justify-center
                            rounded-full
                            bg-green-50
                            text-3xl
                            text-green-600
                        "
                    >
                        ✓
                    </div>

                    <h3
                        class="
                            mt-5
                            text-xl
                            font-black
                            text-slate-900
                        "
                    >
                        No log file yet
                    </h3>

                    <p
                        class="
                            mt-2
                            text-slate-600
                        "
                    >
                        Laravel has not created an application
                        log file yet.
                    </p>

                </div>

            @else

                <div
                    class="
                        overflow-x-auto
                        bg-[#111827]
                        p-5
                    "
                >

                    <pre
                        class="
                            min-w-[900px]
                            whitespace-pre-wrap
                            break-words
                            font-mono
                            text-xs
                            leading-6
                            text-slate-200
                        "
                    >{{ $logContent }}</pre>

                </div>

            @endif

        </section>


        {{-- Admin shortcuts --}}

        <div
            class="
                grid
                gap-4
                md:grid-cols-3
            "
        >

            <a
                href="{{ route('admin.cars.index') }}"
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    p-5
                    font-bold
                    text-slate-700
                    shadow-sm
                    transition
                    hover:border-blue-300
                    hover:text-[#1268d1]
                "
            >
                Manage Cars →
            </a>


            <a
                href="{{ route('admin.pricing.index') }}"
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    p-5
                    font-bold
                    text-slate-700
                    shadow-sm
                    transition
                    hover:border-yellow-300
                    hover:text-[#1268d1]
                "
            >
                Review Pricing →
            </a>


            <a
                href="{{ route('admin.index') }}"
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    p-5
                    font-bold
                    text-slate-700
                    shadow-sm
                    transition
                    hover:border-blue-300
                    hover:text-[#1268d1]
                "
            >
                Admin Dashboard →
            </a>

        </div>

    </div>

</x-layouts::app>