<x-layouts::app :title="__('Dashboard')">

    <div class="space-y-8">

        {{-- Hero / Search --}}

        <section
            class="
                overflow-hidden
                rounded-2xl
                bg-gradient-to-r
                from-[#0b57a8]
                to-[#1976d2]
                px-6
                py-8
                text-white
                shadow-md
                lg:px-10
            "
        >

            <div
                class="
                    flex
                    flex-col
                    gap-6
                    lg:flex-row
                    lg:items-center
                    lg:justify-between
                "
            >

                <div class="max-w-2xl">

                    <p
                        class="
                            text-sm
                            font-bold
                            uppercase
                            tracking-[0.15em]
                            text-yellow-300
                        "
                    >
                        Hot Wheels Market Tracker
                    </p>

                    <h1
                        class="
                            mt-2
                            text-3xl
                            font-black
                            tracking-tight
                            text-white
                            sm:text-4xl
                        "
                    >
                        Find Your Next Treasure Hunt
                    </h1>

                    <p
                        class="
                            mt-3
                            text-base
                            leading-7
                            text-blue-100
                        "
                    >
                        Browse Treasure Hunt and Super Treasure Hunt cars,
                        review approved market prices, and keep track of
                        your favorites.
                    </p>

                </div>


                <form
                    method="GET"
                    action="{{ route('cars.index') }}"
                    class="
                        flex
                        w-full
                        max-w-xl
                        flex-col
                        gap-3
                        sm:flex-row
                    "
                >

                    <input
                        type="text"
                        name="model"
                        placeholder="Search Hot Wheels cars..."
                        class="
                            min-w-0
                            flex-1
                            rounded-lg
                            border
                            border-white/20
                            bg-white
                            px-4
                            py-3
                            text-slate-900
                            shadow-sm
                            outline-none
                            placeholder:text-slate-400
                            focus:border-yellow-400
                            focus:ring-2
                            focus:ring-yellow-400/30
                        "
                    >

                    <button
                        type="submit"
                        class="
                            rounded-lg
                            bg-yellow-400
                            px-6
                            py-3
                            font-bold
                            text-slate-900
                            shadow
                            transition
                            hover:bg-yellow-300
                        "
                    >
                        Search
                    </button>

                </form>

            </div>

        </section>


        {{-- Statistics --}}

        <section
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
                    p-6
                    shadow-sm
                "
            >

                <p
                    class="
                        text-sm
                        font-semibold
                        text-slate-500
                    "
                >
                    Cars in Collection
                </p>

                <div
                    class="
                        mt-3
                        flex
                        items-end
                        justify-between
                    "
                >

                    <p
                        class="
                            text-4xl
                            font-black
                            text-[#1268d1]
                        "
                    >
                        {{ $carCount }}
                    </p>

                    <span class="text-3xl">
                        🚗
                    </span>

                </div>

            </div>


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

                <p
                    class="
                        text-sm
                        font-semibold
                        text-slate-500
                    "
                >
                    Saved Favorites
                </p>

                <div
                    class="
                        mt-3
                        flex
                        items-end
                        justify-between
                    "
                >

                    <p
                        class="
                            text-4xl
                            font-black
                            text-yellow-500
                        "
                    >
                        {{ $favoritesCount }}
                    </p>

                    <span
                        class="
                            text-3xl
                            text-yellow-400
                        "
                    >
                        ★
                    </span>

                </div>

            </div>


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

                <p
                    class="
                        text-sm
                        font-semibold
                        text-slate-500
                    "
                >
                    Price Submissions
                </p>

                <div
                    class="
                        mt-3
                        flex
                        items-end
                        justify-between
                    "
                >

                    <p
                        class="
                            text-4xl
                            font-black
                            text-red-600
                        "
                    >
                        {{ $submissionCount }}
                    </p>

                    <span class="text-3xl">
                        $
                    </span>

                </div>

            </div>

        </section>


        {{-- Collection --}}

        <section>

            <div
                class="
                    mb-5
                    flex
                    items-end
                    justify-between
                    gap-4
                "
            >

                <div>

                    <h2
                        class="
                            text-2xl
                            font-black
                            text-slate-900
                        "
                    >
                        Recent Cars
                    </h2>

                    <p
                        class="
                            mt-1
                            text-slate-600
                        "
                    >
                        Explore recently added Treasure Hunt models.
                    </p>

                </div>

                <a
                    href="{{ route('cars.index') }}"
                    class="
                        font-bold
                        text-[#1268d1]
                        hover:underline
                    "
                >
                    Browse All Cars
                </a>

            </div>


            @if ($cars->isEmpty())

                <div
                    class="
                        rounded-xl
                        border
                        border-slate-200
                        bg-white
                        p-8
                        text-center
                        text-slate-600
                    "
                >
                    No Hot Wheels cars are available yet.
                </div>

            @else

                <div
                    class="
                        grid
                        gap-5
                        sm:grid-cols-2
                        lg:grid-cols-4
                    "
                >

                    @foreach ($cars as $car)

                        <article
                            class="
                                overflow-hidden
                                rounded-xl
                                border
                                border-slate-200
                                bg-white
                                shadow-sm
                                transition
                                duration-200
                                hover:-translate-y-1
                                hover:shadow-lg
                            "
                        >

                            {{-- Image --}}

                            <div
                                class="
                                    flex
                                    h-44
                                    items-center
                                    justify-center
                                    overflow-hidden
                                    bg-gradient-to-br
                                    from-slate-100
                                    to-slate-200
                                "
                            >

                                @if ($car->image)

                                    <img
                                        src="{{ $car->image }}"
                                        alt="{{ $car->model_name }}"
                                        class="
                                            h-full
                                            w-full
                                            object-cover
                                        "
                                    >

                                @else

                                    <div class="text-center">

                                        <p
                                            class="
                                                text-4xl
                                                font-black
                                                italic
                                                text-red-600
                                            "
                                        >
                                            HW
                                        </p>

                                        <p
                                            class="
                                                mt-1
                                                text-xs
                                                font-semibold
                                                uppercase
                                                tracking-widest
                                                text-slate-400
                                            "
                                        >
                                            Image Coming Soon
                                        </p>

                                    </div>

                                @endif

                            </div>


                            <div class="p-5">

                                <div
                                    class="
                                        flex
                                        items-start
                                        justify-between
                                        gap-3
                                    "
                                >

                                    <div>

                                        <h3
                                            class="
                                                text-lg
                                                font-black
                                                text-slate-900
                                            "
                                        >
                                            {{ $car->model_name }}
                                        </h3>

                                        <p
                                            class="
                                                mt-1
                                                text-sm
                                                text-slate-500
                                            "
                                        >
                                            {{ $car->series_name }}
                                        </p>

                                    </div>


                                    <span
                                        class="
                                            rounded-md
                                            px-2.5
                                            py-1
                                            text-xs
                                            font-bold

                                            {{ $car->category === 'STH'
                                                ? 'bg-red-100 text-red-700'
                                                : 'bg-yellow-100 text-yellow-800'
                                            }}
                                        "
                                    >
                                        {{ $car->category }}
                                    </span>

                                </div>


                                <div
                                    class="
                                        mt-5
                                        flex
                                        items-end
                                        justify-between
                                    "
                                >

                                    <div>

                                        <p
                                            class="
                                                text-sm
                                                font-semibold
                                                text-slate-500
                                            "
                                        >
                                            {{ $car->release_year }}
                                        </p>

                                        <p
                                            class="
                                                mt-1
                                                text-xl
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

                                            <span
                                                class="
                                                    text-xs
                                                    font-normal
                                                    text-slate-500
                                                "
                                            >
                                                Avg Price
                                            </span>

                                        </p>

                                    </div>

                                    <span
                                        class="
                                            text-2xl
                                            text-yellow-400
                                        "
                                    >
                                        ★
                                    </span>

                                </div>


                                <a
                                    href="{{ route(
                                        'cars.show',
                                        $car
                                    ) }}"
                                    class="
                                        mt-5
                                        block
                                        rounded-lg
                                        bg-yellow-400
                                        px-4
                                        py-2.5
                                        text-center
                                        text-sm
                                        font-bold
                                        text-slate-900
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

        </section>

    </div>

</x-layouts::app>