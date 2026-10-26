<x-layouts::app :title="__('Pricing Moderation')">

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
                        Pricing Moderation
                    </h1>

                    <p
                        class="
                            mt-2
                            max-w-2xl
                            text-blue-100
                        "
                    >
                        Review collector-submitted Hot Wheels prices
                        before they become part of the approved
                        market history.
                    </p>
                </div>


                <div
                    class="
                        rounded-xl
                        bg-white/15
                        px-5
                        py-3
                        text-center
                        backdrop-blur-sm
                    "
                >
                    <p
                        class="
                            text-xs
                            font-bold
                            uppercase
                            tracking-wide
                            text-blue-100
                        "
                    >
                        Pending
                    </p>

                    <p
                        class="
                            mt-1
                            text-3xl
                            font-black
                            text-yellow-300
                        "
                    >
                        {{ $pendingSubmissions->count() }}
                    </p>
                </div>

            </div>
        </section>


        {{-- Status message --}}
        @if (session('admin_pricing_status'))

            <div
                class="
                    rounded-xl
                    border
                    border-green-200
                    bg-green-50
                    px-5
                    py-4
                    font-semibold
                    text-green-700
                "
            >
                {{ session('admin_pricing_status') }}
            </div>

        @endif


        @if ($pendingSubmissions->isEmpty())

            {{-- Empty state --}}
            <div
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    px-6
                    py-14
                    text-center
                    shadow-sm
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

                <h2
                    class="
                        mt-5
                        text-xl
                        font-black
                        text-slate-900
                    "
                >
                    No pending submissions
                </h2>

                <p class="mt-2 text-slate-600">
                    All collector pricing submissions
                    have been reviewed.
                </p>
            </div>

        @else

            {{-- Desktop table --}}
            <section
                class="
                    hidden
                    overflow-hidden
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    shadow-sm
                    lg:block
                "
            >

                <div
                    class="
                        flex
                        items-center
                        justify-between
                        border-b
                        border-slate-200
                        px-6
                        py-5
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
                            Pending Price Submissions
                        </h2>

                        <p class="mt-1 text-sm text-slate-600">
                            Approve valid market data or reject
                            incorrect submissions.
                        </p>
                    </div>

                    <span
                        class="
                            rounded-full
                            bg-yellow-100
                            px-3
                            py-1.5
                            text-sm
                            font-bold
                            text-yellow-800
                        "
                    >
                        {{ $pendingSubmissions->count() }} Pending
                    </span>
                </div>


                <div class="overflow-x-auto">

                    <table
                        class="
                            w-full
                            min-w-[1000px]
                            text-left
                            text-sm
                        "
                    >

                        <thead
                            class="
                                bg-slate-50
                                text-xs
                                uppercase
                                tracking-wide
                                text-slate-500
                            "
                        >
                            <tr>
                                <th class="px-6 py-4 font-bold">
                                    Car
                                </th>

                                <th class="px-6 py-4 font-bold">
                                    Category
                                </th>

                                <th class="px-6 py-4 font-bold">
                                    Collector
                                </th>

                                <th class="px-6 py-4 font-bold">
                                    Price
                                </th>

                                <th class="px-6 py-4 font-bold">
                                    Date Found
                                </th>

                                <th class="px-6 py-4 font-bold">
                                    Status
                                </th>

                                <th
                                    class="
                                        px-6
                                        py-4
                                        text-right
                                        font-bold
                                    "
                                >
                                    Action
                                </th>
                            </tr>
                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @foreach ($pendingSubmissions as $submission)

                                <tr class="hover:bg-slate-50">

                                    {{-- Car --}}
                                    <td class="px-6 py-5">
                                        <div
                                            class="
                                                font-black
                                                text-slate-900
                                            "
                                        >
                                            {{ $submission->car->model_name }}
                                        </div>

                                        <div
                                            class="
                                                mt-1
                                                text-sm
                                                text-slate-500
                                            "
                                        >
                                            {{ $submission->car->series_name }}
                                            ·
                                            {{ $submission->car->release_year }}
                                        </div>
                                    </td>


                                    {{-- Category --}}
                                    <td class="px-6 py-5">

                                        <span
                                            class="
                                                inline-flex
                                                rounded-md
                                                px-2.5
                                                py-1
                                                text-xs
                                                font-black

                                                {{ $submission->car->category === 'STH'
                                                    ? 'bg-red-100 text-red-700'
                                                    : 'bg-yellow-100 text-yellow-800'
                                                }}
                                            "
                                        >
                                            {{ $submission->car->category }}
                                        </span>

                                    </td>


                                    {{-- Collector --}}
                                    <td
                                        class="
                                            px-6
                                            py-5
                                            text-slate-600
                                        "
                                    >
                                        {{ $submission->user?->username
                                            ?? $submission->user?->email
                                            ?? 'Unknown User'
                                        }}
                                    </td>


                                    {{-- Price --}}
                                    <td class="px-6 py-5">

                                        <span
                                            class="
                                                font-black
                                                text-slate-900
                                            "
                                        >
                                            ${{ number_format(
                                                $submission->price,
                                                2
                                            ) }}
                                        </span>

                                        <span
                                            class="
                                                ml-1
                                                text-xs
                                                font-semibold
                                                text-slate-500
                                            "
                                        >
                                            {{ $submission->currency }}
                                        </span>

                                    </td>


                                    {{-- Date --}}
                                    <td
                                        class="
                                            px-6
                                            py-5
                                            text-slate-600
                                        "
                                    >
                                        {{ $submission
                                            ->submission_date
                                            ->format('M j, Y')
                                        }}
                                    </td>


                                    {{-- Status --}}
                                    <td class="px-6 py-5">

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-yellow-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-bold
                                                text-yellow-800
                                            "
                                        >
                                            {{ $submission->status }}
                                        </span>

                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-6 py-5">

                                        <div
                                            class="
                                                flex
                                                justify-end
                                                gap-2
                                            "
                                        >

                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'admin.pricing.approve',
                                                    $submission
                                                ) }}"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="
                                                        rounded-lg
                                                        bg-green-600
                                                        px-4
                                                        py-2
                                                        text-sm
                                                        font-bold
                                                        text-white
                                                        hover:bg-green-700
                                                    "
                                                >
                                                    Approve
                                                </button>
                                            </form>


                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'admin.pricing.reject',
                                                    $submission
                                                ) }}"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    onclick="
                                                        return confirm(
                                                            'Reject this price submission?'
                                                        )
                                                    "
                                                    class="
                                                        rounded-lg
                                                        bg-red-600
                                                        px-4
                                                        py-2
                                                        text-sm
                                                        font-bold
                                                        text-white
                                                        hover:bg-red-700
                                                    "
                                                >
                                                    Reject
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </section>


            {{-- Mobile cards --}}
            <div class="space-y-4 lg:hidden">

                @foreach ($pendingSubmissions as $submission)

                    <article
                        class="
                            rounded-xl
                            border
                            border-slate-200
                            bg-white
                            p-5
                            shadow-sm
                        "
                    >

                        <div
                            class="
                                flex
                                items-start
                                justify-between
                                gap-4
                            "
                        >
                            <div>
                                <h2
                                    class="
                                        text-lg
                                        font-black
                                        text-slate-900
                                    "
                                >
                                    {{ $submission->car->model_name }}
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $submission->car->series_name }}
                                    ·
                                    {{ $submission->car->release_year }}
                                </p>
                            </div>


                            <span
                                class="
                                    rounded-md
                                    px-2.5
                                    py-1
                                    text-xs
                                    font-black

                                    {{ $submission->car->category === 'STH'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-yellow-100 text-yellow-800'
                                    }}
                                "
                            >
                                {{ $submission->car->category }}
                            </span>
                        </div>


                        {{-- Dynamic status --}}
                        <div class="mt-4">

                            <span
                                class="
                                    inline-flex
                                    rounded-full
                                    bg-yellow-100
                                    px-3
                                    py-1
                                    text-xs
                                    font-bold
                                    text-yellow-800
                                "
                            >
                                {{ $submission->status }}
                            </span>

                        </div>


                        <div
                            class="
                                mt-4
                                grid
                                grid-cols-2
                                gap-4
                                rounded-lg
                                bg-slate-50
                                p-4
                            "
                        >

                            <div>
                                <p
                                    class="
                                        text-xs
                                        font-bold
                                        uppercase
                                        text-slate-400
                                    "
                                >
                                    Price
                                </p>

                                <p
                                    class="
                                        mt-1
                                        font-black
                                        text-slate-900
                                    "
                                >
                                    ${{ number_format(
                                        $submission->price,
                                        2
                                    ) }}

                                    {{ $submission->currency }}
                                </p>
                            </div>


                            <div>
                                <p
                                    class="
                                        text-xs
                                        font-bold
                                        uppercase
                                        text-slate-400
                                    "
                                >
                                    Date
                                </p>

                                <p
                                    class="
                                        mt-1
                                        font-semibold
                                        text-slate-700
                                    "
                                >
                                    {{ $submission
                                        ->submission_date
                                        ->format('M j, Y')
                                    }}
                                </p>
                            </div>


                            <div class="col-span-2">
                                <p
                                    class="
                                        text-xs
                                        font-bold
                                        uppercase
                                        text-slate-400
                                    "
                                >
                                    Submitted By
                                </p>

                                <p
                                    class="
                                        mt-1
                                        font-semibold
                                        text-slate-700
                                    "
                                >
                                    {{ $submission->user?->username
                                        ?? $submission->user?->email
                                        ?? 'Unknown User'
                                    }}
                                </p>
                            </div>

                        </div>


                        <div
                            class="
                                mt-5
                                grid
                                grid-cols-2
                                gap-3
                            "
                        >

                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.pricing.approve',
                                    $submission
                                ) }}"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="
                                        w-full
                                        rounded-lg
                                        bg-green-600
                                        px-4
                                        py-2.5
                                        font-bold
                                        text-white
                                        hover:bg-green-700
                                    "
                                >
                                    Approve
                                </button>
                            </form>


                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.pricing.reject',
                                    $submission
                                ) }}"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    onclick="
                                        return confirm(
                                            'Reject this price submission?'
                                        )
                                    "
                                    class="
                                        w-full
                                        rounded-lg
                                        bg-red-600
                                        px-4
                                        py-2.5
                                        font-bold
                                        text-white
                                        hover:bg-red-700
                                    "
                                >
                                    Reject
                                </button>
                            </form>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</x-layouts::app>