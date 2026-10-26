<x-layouts::app :title="$car->model_name">

    @php

        $imageUrl = null;

        if ($car->image) {
            $imageUrl =
                \Illuminate\Support\Str::startsWith(
                    $car->image,
                    [
                        'http://',
                        'https://',
                    ]
                )
                    ? $car->image
                    : asset(
                        ltrim(
                            $car->image,
                            '/'
                        )
                    );
        }

    @endphp


    <div class="space-y-8 text-slate-900">

        {{-- Back link --}}

        <a
            href="{{ route('cars.index') }}"
            class="
                inline-flex
                items-center
                gap-2
                text-sm
                font-bold
                text-[#1268d1]
                hover:underline
            "
        >
            ← Back to Collection
        </a>


        {{-- =====================================================
             MAIN CAR SECTION
        ====================================================== --}}

        <section
            class="
                grid
                overflow-hidden
                rounded-2xl
                border
                border-slate-200
                bg-white
                shadow-sm
                lg:grid-cols-2
            "
        >

            {{-- Car image --}}

            <div
                class="
                    flex
                    min-h-[340px]
                    items-center
                    justify-center
                    overflow-hidden
                    bg-gradient-to-br
                    from-blue-50
                    via-white
                    to-yellow-50
                    lg:min-h-[500px]
                "
            >

                @if ($imageUrl)

                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ $car->model_name }}"
                        class="
                            h-full
                            max-h-[520px]
                            w-full
                            object-cover
                        "
                    >

                @else

                    <div class="text-center">

                        <img
                            src="{{ asset(
                                'images/hot-wheels-market-tracker-logo.png'
                            ) }}"
                            alt="Hot Wheels Market Tracker"
                            class="
                                mx-auto
                                w-60
                                max-w-[75%]
                                opacity-75
                            "
                        >

                        <p
                            class="
                                mt-5
                                text-sm
                                font-semibold
                                text-slate-400
                            "
                        >
                            Car image coming soon
                        </p>

                    </div>

                @endif

            </div>


            {{-- Car information --}}

            <div
                class="
                    flex
                    flex-col
                    justify-between
                    p-6
                    sm:p-8
                    lg:p-10
                "
            >

                <div>

                    <div
                        class="
                            flex
                            flex-wrap
                            items-center
                            gap-3
                        "
                    >

                        @if ($car->category === 'STH')

                            <span
                                class="
                                    rounded-md
                                    bg-red-600
                                    px-3
                                    py-1.5
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wide
                                    text-white
                                "
                            >
                                Super Treasure Hunt (STH)
                            </span>

                        @else

                            <span
                                class="
                                    rounded-md
                                    bg-yellow-400
                                    px-3
                                    py-1.5
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wide
                                    text-slate-900
                                "
                            >
                                Treasure Hunt (TH)
                            </span>

                        @endif


                        <span
                            class="
                                text-sm
                                font-bold
                                text-slate-500
                            "
                        >
                            {{ $car->release_year }}
                        </span>

                    </div>


                    <h1
                        class="
                            mt-5
                            text-3xl
                            font-black
                            tracking-tight
                            text-slate-900
                            sm:text-4xl
                        "
                    >
                        {{ $car->model_name }}
                    </h1>


                    <p
                        class="
                            mt-2
                            text-lg
                            font-semibold
                            text-slate-500
                        "
                    >
                        {{ $car->series_name }}
                    </p>


                    @if ($car->description)

                        <p
                            class="
                                mt-6
                                max-w-2xl
                                leading-7
                                text-slate-600
                            "
                        >
                            {{ $car->description }}
                        </p>

                    @endif


                    {{-- Price card --}}

                    <div
                        class="
                            mt-8
                            rounded-xl
                            border
                            border-blue-100
                            bg-blue-50
                            p-5
                        "
                    >

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-[0.12em]
                                text-[#1268d1]
                            "
                        >
                            Average Approved Price
                        </p>

                        @if (
                            $car->approved_prices_avg_price !== null
                        )

                            <p
                                class="
                                    mt-2
                                    text-4xl
                                    font-black
                                    text-slate-900
                                "
                            >
                                ${{ number_format(
                                    $car->approved_prices_avg_price,
                                    2
                                ) }}

                                <span
                                    class="
                                        text-base
                                        font-semibold
                                        text-slate-500
                                    "
                                >
                                    CAD
                                </span>
                            </p>

                        @else

                            <p
                                class="
                                    mt-2
                                    text-xl
                                    font-bold
                                    text-slate-600
                                "
                            >
                                No approved pricing yet
                            </p>

                        @endif

                    </div>

                </div>


                {{-- Favorite button --}}

                <div class="mt-8">

                    @if (session('status'))

                        <div
                            class="
                                mb-4
                                rounded-lg
                                border
                                border-green-200
                                bg-green-50
                                px-4
                                py-3
                                text-sm
                                font-semibold
                                text-green-700
                            "
                        >
                            {{ session('status') }}
                        </div>

                    @endif


                    @if ($isFavorite)

                        <form
                            method="POST"
                            action="{{ route(
                                'cars.unfavorite',
                                $car
                            ) }}"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="
                                    w-full
                                    rounded-lg
                                    border
                                    border-yellow-400
                                    bg-yellow-50
                                    px-5
                                    py-3
                                    font-black
                                    text-yellow-800
                                    transition
                                    hover:bg-yellow-100
                                "
                            >
                                ★ Remove Favorites
                            </button>

                        </form>

                    @else

                        <form
                            method="POST"
                            action="{{ route(
                                'cars.favorite',
                                $car
                            ) }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="
                                    w-full
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
                                ☆ Add to Favorites
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </section>


        {{-- =====================================================
             PRICE HISTORY + PRICE SUBMISSION
        ====================================================== --}}

        <section
            class="
                grid
                gap-6
                lg:grid-cols-[1fr_0.9fr]
            "
        >

            {{-- Approved price history --}}

            <div
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    p-6
                    shadow-sm
                "
            >

                <div class="mb-5">

                    <p
                        class="
                            text-sm
                            font-bold
                            uppercase
                            tracking-[0.12em]
                            text-[#1268d1]
                        "
                    >
                        Market Data
                    </p>

                    <h2
                        class="
                            mt-1
                            text-2xl
                            font-black
                            text-slate-900
                        "
                    >
                        Approved Price History
                    </h2>

                    <p
                        class="
                            mt-1
                            text-sm
                            text-slate-600
                        "
                    >
                        Only administrator-approved prices
                        appear here.
                    </p>

                </div>


                @if ($car->approvedPrices->isEmpty())

                    <div
                        class="
                            rounded-lg
                            border
                            border-dashed
                            border-slate-300
                            bg-slate-50
                            px-5
                            py-10
                            text-center
                            text-slate-500
                        "
                    >
                        No approved price history is available yet.
                    </div>

                @else

                    <div class="overflow-x-auto">

                        <table
                            class="
                                w-full
                                text-left
                                text-sm
                            "
                        >

                            <thead
                                class="
                                    border-b
                                    border-slate-200
                                    text-xs
                                    uppercase
                                    tracking-wide
                                    text-slate-500
                                "
                            >

                                <tr>

                                    <th class="pb-3 font-bold">
                                        Price
                                    </th>

                                    <th class="pb-3 font-bold">
                                        Currency
                                    </th>

                                    <th class="pb-3 font-bold">
                                        Approved
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach (
                                    $car->approvedPrices
                                    as $approvedPrice
                                )

                                    <tr
                                        class="
                                            border-b
                                            border-slate-100
                                            last:border-0
                                        "
                                    >

                                        <td
                                            class="
                                                py-4
                                                font-black
                                                text-slate-900
                                            "
                                        >
                                            ${{ number_format(
                                                $approvedPrice->price,
                                                2
                                            ) }}
                                        </td>

                                        <td
                                            class="
                                                py-4
                                                text-slate-600
                                            "
                                        >
                                            {{ $approvedPrice->currency }}
                                        </td>

                                        <td
                                            class="
                                                py-4
                                                text-slate-600
                                            "
                                        >
                                            {{ $approvedPrice
                                                ->approved_at
                                                ?->format('M j, Y')
                                                ?? '—'
                                            }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>


            {{-- Price submission --}}

            <div
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    p-6
                    shadow-sm
                "
            >

                <div class="mb-5">

                    <p
                        class="
                            text-sm
                            font-bold
                            uppercase
                            tracking-[0.12em]
                            text-[#1268d1]
                        "
                    >
                        Collector Submission
                    </p>

                    <h2
                        class="
                            mt-1
                            text-2xl
                            font-black
                            text-slate-900
                        "
                    >
                        Submit a Market Price
                    </h2>

                    <p
                        class="
                            mt-1
                            text-sm
                            leading-6
                            text-slate-600
                        "
                    >
                        Submit a price you found for this car.
                        An administrator must approve it before
                        it becomes part of the market data.
                    </p>

                </div>


                @if (session('pricing_status'))

                    <div
                        class="
                            mb-5
                            rounded-lg
                            border
                            border-green-200
                            bg-green-50
                            px-4
                            py-3
                            text-sm
                            font-semibold
                            text-green-700
                        "
                    >
                        {{ session('pricing_status') }}
                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route(
                        'cars.pricing.store',
                        $car
                    ) }}"
                    class="space-y-5"
                >

                    @csrf


                    {{-- Price --}}

                    <div>

                        <label
                            for="price"
                            class="
                                mb-2
                                block
                                text-sm
                                font-bold
                                text-slate-700
                            "
                        >
                            Price
                        </label>

                        <div class="relative">

                            <span
                                class="
                                    absolute
                                    left-3.5
                                    top-1/2
                                    -translate-y-1/2
                                    font-bold
                                    text-slate-500
                                "
                            >
                                $
                            </span>

                            <input
                                id="price"
                                name="price"
                                type="number"
                                step="0.01"
                                min="0"
                                value="{{ old('price') }}"
                                placeholder="59.99"
                                required
                                class="
                                    w-full
                                    rounded-lg
                                    border
                                    border-slate-300
                                    bg-white
                                    py-3
                                    pl-8
                                    pr-4
                                    text-slate-900
                                    outline-none
                                    focus:border-[#1268d1]
                                    focus:ring-2
                                    focus:ring-blue-100
                                "
                            >

                        </div>

                        @error('price')

                            <p
                                class="
                                    mt-1.5
                                    text-sm
                                    font-semibold
                                    text-red-600
                                "
                            >
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Currency --}}

                    <div>

                        <label
                            for="currency"
                            class="
                                mb-2
                                block
                                text-sm
                                font-bold
                                text-slate-700
                            "
                        >
                            Currency
                        </label>

                        <input
                            id="currency"
                            name="currency"
                            type="text"
                            maxlength="3"
                            value="{{ old(
                                'currency',
                                'CAD'
                            ) }}"
                            required
                            class="
                                w-full
                                rounded-lg
                                border
                                border-slate-300
                                bg-white
                                px-4
                                py-3
                                uppercase
                                text-slate-900
                                outline-none
                                focus:border-[#1268d1]
                                focus:ring-2
                                focus:ring-blue-100
                            "
                        >

                        @error('currency')

                            <p
                                class="
                                    mt-1.5
                                    text-sm
                                    font-semibold
                                    text-red-600
                                "
                            >
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Date --}}

                    <div>

                        <label
                            for="submission_date"
                            class="
                                mb-2
                                block
                                text-sm
                                font-bold
                                text-slate-700
                            "
                        >
                            Date Found
                        </label>

                        <input
                            id="submission_date"
                            name="submission_date"
                            type="date"
                            value="{{ old(
                                'submission_date',
                                now()->toDateString()
                            ) }}"
                            required
                            class="
                                w-full
                                rounded-lg
                                border
                                border-slate-300
                                bg-white
                                px-4
                                py-3
                                text-slate-900
                                outline-none
                                focus:border-[#1268d1]
                                focus:ring-2
                                focus:ring-blue-100
                            "
                        >

                        @error('submission_date')

                            <p
                                class="
                                    mt-1.5
                                    text-sm
                                    font-semibold
                                    text-red-600
                                "
                            >
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <button
                        type="submit"
                        class="
                            w-full
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
                        Submit Price for Approval
                    </button>

                </form>

            </div>

        </section>

    </div>

</x-layouts::app>