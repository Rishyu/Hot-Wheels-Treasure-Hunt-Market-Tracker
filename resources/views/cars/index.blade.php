<x-layouts::app :title="__('Hot Wheels Collection')">

    <div class="space-y-7 text-slate-900">

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div
            class="
                flex
                flex-col
                gap-4
                sm:flex-row
                sm:items-end
                sm:justify-between
            "
        >

            <div>

                <p
                    class="
                        text-sm
                        font-bold
                        uppercase
                        tracking-[0.14em]
                        text-[#1268d1]
                    "
                >
                    Collector Database
                </p>

                <h1
                    class="
                        mt-1
                        text-3xl
                        font-black
                        tracking-tight
                        text-slate-900
                    "
                >
                    Hot Wheels Collection
                </h1>

                <p
                    class="
                        mt-2
                        max-w-2xl
                        text-slate-600
                    "
                >
                    Search Treasure Hunt and Super Treasure Hunt
                    models and compare approved market prices.
                </p>

            </div>


            <div
                class="
                    rounded-lg
                    border
                    border-slate-200
                    bg-white
                    px-4
                    py-2
                    text-sm
                    font-semibold
                    text-slate-600
                    shadow-sm
                "
            >
                {{ $cars->count() }}
                {{ $cars->count() === 1 ? 'car' : 'cars' }}
                shown
            </div>

        </div>


        {{-- =====================================================
             SEARCH / FILTER BAR
        ====================================================== --}}

        <form
            method="GET"
            action="{{ route('cars.index') }}"
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
                    grid
                    gap-4
                    md:grid-cols-2
                    xl:grid-cols-5
                "
            >

                {{-- Model --}}

                <div>

                    <label
                        for="model"
                        class="
                            mb-2
                            block
                            text-sm
                            font-bold
                            text-slate-700
                        "
                    >
                        Model Name
                    </label>

                    <input
                        id="model"
                        name="model"
                        type="text"
                        value="{{ request('model') }}"
                        placeholder="e.g. Bone Shaker"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-slate-300
                            bg-white
                            px-3.5
                            py-2.5
                            text-sm
                            text-slate-900
                            outline-none
                            placeholder:text-slate-400
                            focus:border-[#1268d1]
                            focus:ring-2
                            focus:ring-blue-100
                        "
                    >

                </div>


                {{-- Series --}}

                <div>

                    <label
                        for="series"
                        class="
                            mb-2
                            block
                            text-sm
                            font-bold
                            text-slate-700
                        "
                    >
                        Series
                    </label>

                    <input
                        id="series"
                        name="series"
                        type="text"
                        value="{{ request('series') }}"
                        placeholder="e.g. Factory Fresh"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-slate-300
                            bg-white
                            px-3.5
                            py-2.5
                            text-sm
                            text-slate-900
                            outline-none
                            placeholder:text-slate-400
                            focus:border-[#1268d1]
                            focus:ring-2
                            focus:ring-blue-100
                        "
                    >

                </div>


                {{-- Year --}}

                <div>

                    <label
                        for="year"
                        class="
                            mb-2
                            block
                            text-sm
                            font-bold
                            text-slate-700
                        "
                    >
                        Release Year
                    </label>

                    <select
                        id="year"
                        name="year"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-slate-300
                            bg-white
                            px-3.5
                            py-2.5
                            text-sm
                            text-slate-900
                            outline-none
                            focus:border-[#1268d1]
                            focus:ring-2
                            focus:ring-blue-100
                        "
                    >

                        <option value="">
                            All Years
                        </option>

                        @foreach ($years as $year)

                            <option
                                value="{{ $year }}"
                                @selected(
                                    request('year') == $year
                                )
                            >
                                {{ $year }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Category --}}

                <div>

                    <label
                        for="category"
                        class="
                            mb-2
                            block
                            text-sm
                            font-bold
                            text-slate-700
                        "
                    >
                        Category
                    </label>

                    <select
                        id="category"
                        name="category"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-slate-300
                            bg-white
                            px-3.5
                            py-2.5
                            text-sm
                            text-slate-900
                            outline-none
                            focus:border-[#1268d1]
                            focus:ring-2
                            focus:ring-blue-100
                        "
                    >

                        <option value="">
                            All Categories
                        </option>

                        <option
                            value="TH"
                            @selected(
                                request('category') === 'TH'
                            )
                        >
                            Treasure Hunt
                        </option>

                        <option
                            value="STH"
                            @selected(
                                request('category') === 'STH'
                            )
                        >
                            Super Treasure Hunt
                        </option>

                    </select>

                </div>


                {{-- Sort --}}

                <div>

                    <label
                        for="sort"
                        class="
                            mb-2
                            block
                            text-sm
                            font-bold
                            text-slate-700
                        "
                    >
                        Sort By
                    </label>

                    <select
                        id="sort"
                        name="sort"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-slate-300
                            bg-white
                            px-3.5
                            py-2.5
                            text-sm
                            text-slate-900
                            outline-none
                            focus:border-[#1268d1]
                            focus:ring-2
                            focus:ring-blue-100
                        "
                    >

                        <option
                            value="year_desc"
                            @selected(
                                request(
                                    'sort',
                                    'year_desc'
                                ) === 'year_desc'
                            )
                        >
                            Newest First
                        </option>

                        <option
                            value="year_asc"
                            @selected(
                                request('sort')
                                === 'year_asc'
                            )
                        >
                            Oldest First
                        </option>

                        <option
                            value="price_asc"
                            @selected(
                                request('sort')
                                === 'price_asc'
                            )
                        >
                            Price: Low to High
                        </option>

                        <option
                            value="price_desc"
                            @selected(
                                request('sort')
                                === 'price_desc'
                            )
                        >
                            Price: High to Low
                        </option>

                    </select>

                </div>

            </div>


            <div
                class="
                    mt-5
                    flex
                    flex-wrap
                    gap-3
                "
            >

                <button
                    type="submit"
                    class="
                        rounded-lg
                        bg-yellow-400
                        px-6
                        py-2.5
                        text-sm
                        font-bold
                        text-slate-900
                        shadow-sm
                        transition
                        hover:bg-yellow-300
                    "
                >
                    Apply Filters
                </button>


                <a
                    href="{{ route('cars.index') }}"
                    class="
                        rounded-lg
                        border
                        border-slate-300
                        bg-white
                        px-6
                        py-2.5
                        text-sm
                        font-bold
                        text-slate-700
                        transition
                        hover:bg-slate-50
                    "
                >
                    Clear
                </a>

            </div>

        </form>


        {{-- =====================================================
             CAR RESULTS
        ====================================================== --}}

        @if ($cars->isEmpty())

            <div
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    px-6
                    py-16
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
                        bg-blue-50
                        text-3xl
                    "
                >
                    🔎
                </div>

                <h2
                    class="
                        mt-5
                        text-xl
                        font-black
                        text-slate-900
                    "
                >
                    No cars found
                </h2>

                <p
                    class="
                        mx-auto
                        mt-2
                        max-w-md
                        text-slate-600
                    "
                >
                    Try changing your model, series, year,
                    category, or sorting options.
                </p>

                <a
                    href="{{ route('cars.index') }}"
                    class="
                        mt-5
                        inline-block
                        rounded-lg
                        bg-yellow-400
                        px-5
                        py-2.5
                        font-bold
                        text-slate-900
                        hover:bg-yellow-300
                    "
                >
                    Show All Cars
                </a>

            </div>

        @else

            <div
                class="
                    grid
                    gap-5
                    sm:grid-cols-2
                    lg:grid-cols-3
                    xl:grid-cols-4
                "
            >

                @foreach ($cars as $car)

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


                    <article
                        class="
                            group
                            overflow-hidden
                            rounded-xl
                            border
                            border-slate-200
                            bg-white
                            shadow-sm
                            transition
                            duration-200
                            hover:-translate-y-1
                            hover:border-blue-200
                            hover:shadow-lg
                        "
                    >

                        {{-- Car image --}}

                        <div
                            class="
                                relative
                                flex
                                h-48
                                items-center
                                justify-center
                                overflow-hidden
                                bg-gradient-to-br
                                from-slate-100
                                to-slate-200
                            "
                        >

                            @if ($imageUrl)

                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $car->model_name }}"
                                    class="
                                        h-full
                                        w-full
                                        object-cover
                                        transition
                                        duration-300
                                        group-hover:scale-105
                                    "
                                >

                            @else

                                <div
                                    class="
                                        flex
                                        h-full
                                        w-full
                                        items-center
                                        justify-center
                                        bg-gradient-to-br
                                        from-blue-50
                                        via-white
                                        to-yellow-50
                                    "
                                >

                                    <img
                                        src="{{ asset(
                                            'images/hot-wheels-market-tracker-logo.png'
                                        ) }}"
                                        alt=""
                                        class="
                                            w-36
                                            max-w-[70%]
                                            opacity-60
                                        "
                                    >

                                </div>

                            @endif


                            {{-- Category badge --}}

                            <div
                                class="
                                    absolute
                                    left-3
                                    top-3
                                "
                            >

                                @if ($car->category === 'STH')

                                    <span
                                        class="
                                            rounded-md
                                            bg-red-600
                                            px-2.5
                                            py-1
                                            text-xs
                                            font-black
                                            text-white
                                            shadow
                                        "
                                    >
                                        STH
                                    </span>

                                @else

                                    <span
                                        class="
                                            rounded-md
                                            bg-yellow-400
                                            px-2.5
                                            py-1
                                            text-xs
                                            font-black
                                            text-slate-900
                                            shadow
                                        "
                                    >
                                        TH
                                    </span>

                                @endif

                            </div>


                            {{-- Proposal-style favorite star --}}

                            <div
                                class="
                                    absolute
                                    right-3
                                    top-2
                                    text-2xl
                                    text-yellow-400
                                    drop-shadow
                                "
                                title="Treasure Hunt"
                            >
                                ★
                            </div>

                        </div>


                        {{-- Card content --}}

                        <div class="p-5">

                            <h2
                                class="
                                    truncate
                                    text-lg
                                    font-black
                                    text-slate-900
                                "
                            >
                                {{ $car->model_name }}
                            </h2>


                            <p
                                class="
                                    mt-1
                                    truncate
                                    text-sm
                                    font-medium
                                    text-slate-500
                                "
                            >
                                {{ $car->series_name }}
                            </p>


                            <div
                                class="
                                    mt-4
                                    flex
                                    items-end
                                    justify-between
                                    gap-4
                                "
                            >

                                <div>

                                    <p
                                        class="
                                            text-xs
                                            font-bold
                                            uppercase
                                            tracking-wide
                                            text-slate-400
                                        "
                                    >
                                        Release Year
                                    </p>

                                    <p
                                        class="
                                            mt-1
                                            text-lg
                                            font-black
                                            text-slate-900
                                        "
                                    >
                                        {{ $car->release_year }}
                                    </p>

                                </div>


                                <div class="text-right">

                                    <p
                                        class="
                                            text-xs
                                            font-bold
                                            uppercase
                                            tracking-wide
                                            text-slate-400
                                        "
                                    >
                                        Avg Price
                                    </p>

                                    <p
                                        class="
                                            mt-1
                                            text-lg
                                            font-black
                                            text-slate-900
                                        "
                                    >

                                        @if (
                                            $car->approved_prices_avg_price
                                            !== null
                                        )

                                            ${{ number_format(
                                                $car->approved_prices_avg_price,
                                                2
                                            ) }}

                                        @else

                                            —

                                        @endif

                                    </p>

                                </div>

                            </div>


                            @if ($car->description)

                                <p
                                    class="
                                        mt-4
                                        min-h-[40px]
                                        text-sm
                                        leading-5
                                        text-slate-600
                                    "
                                >
                                    {{ \Illuminate\Support\Str::limit(
                                        $car->description,
                                        85
                                    ) }}
                                </p>

                            @else

                                <div class="mt-4 min-h-[40px]"></div>

                            @endif


                            <a
                                href="{{ route(
                                    'cars.show',
                                    $car
                                ) }}"
                                class="
                                    mt-5
                                    block
                                    w-full
                                    rounded-lg
                                    bg-yellow-400
                                    px-4
                                    py-2.5
                                    text-center
                                    text-sm
                                    font-black
                                    text-slate-900
                                    shadow-sm
                                    transition
                                    hover:bg-yellow-300
                                "
                            >
                                View Details
                            </a>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</x-layouts::app>