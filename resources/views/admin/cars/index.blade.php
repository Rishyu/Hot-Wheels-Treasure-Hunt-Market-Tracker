<x-layouts::app :title="__('Manage Cars')">

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
                        Manage Hot Wheels Cars
                    </h1>

                    <p
                        class="
                            mt-2
                            max-w-2xl
                            text-blue-100
                        "
                    >
                        Add, update, and maintain Treasure Hunt
                        and Super Treasure Hunt listings.
                    </p>

                </div>

                <a
                    href="{{ route('admin.cars.create') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        rounded-lg
                        bg-yellow-400
                        px-6
                        py-3
                        font-black
                        text-slate-900
                        shadow-sm
                        transition
                        hover:bg-yellow-300
                    "
                >
                    + Add New Car
                </a>

            </div>

        </section>


        {{-- Flash message --}}

        @if (session('status') || session('success'))

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
                {{ session('status') ?? session('success') }}
            </div>

        @endif


        {{-- Page summary --}}

        <div
            class="
                flex
                flex-col
                gap-4
                sm:flex-row
                sm:items-center
                sm:justify-between
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
                    Car Database
                </h2>

                <p class="mt-1 text-slate-600">
                    Cars currently available in the market tracker.
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
                    font-bold
                    text-slate-600
                    shadow-sm
                "
            >
                {{ $cars->count() }}
                {{ $cars->count() === 1 ? 'car' : 'cars' }}
            </div>

        </div>


        @if ($cars->isEmpty())

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
                        bg-blue-50
                        text-3xl
                    "
                >
                    🚗
                </div>

                <h3
                    class="
                        mt-5
                        text-xl
                        font-black
                        text-slate-900
                    "
                >
                    No cars have been added
                </h3>

                <p class="mt-2 text-slate-600">
                    Add the first Hot Wheels car to the database.
                </p>

                <a
                    href="{{ route('admin.cars.create') }}"
                    class="
                        mt-5
                        inline-block
                        rounded-lg
                        bg-yellow-400
                        px-5
                        py-2.5
                        font-black
                        text-slate-900
                        hover:bg-yellow-300
                    "
                >
                    Add Car
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
                                    ['http://', 'https://']
                                )
                                    ? $car->image
                                    : asset(ltrim($car->image, '/'));
                        }
                    @endphp

                    <article
                        class="
                            overflow-hidden
                            rounded-xl
                            border
                            border-slate-200
                            bg-white
                            shadow-sm
                            transition
                            hover:-translate-y-1
                            hover:shadow-lg
                        "
                    >

                        {{-- Image --}}

                        <div
                            class="
                                relative
                                flex
                                h-44
                                items-center
                                justify-center
                                overflow-hidden
                                bg-gradient-to-br
                                from-blue-50
                                via-white
                                to-yellow-50
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
                                    "
                                >

                            @else

                                <img
                                    src="{{ asset(
                                        'images/hot-wheels-market-tracker-logo.png'
                                    ) }}"
                                    alt=""
                                    class="
                                        w-36
                                        opacity-50
                                    "
                                >

                            @endif


                            <span
                                class="
                                    absolute
                                    left-3
                                    top-3
                                    rounded-md
                                    px-2.5
                                    py-1
                                    text-xs
                                    font-black

                                    {{ $car->category === 'STH'
                                        ? 'bg-red-600 text-white'
                                        : 'bg-yellow-400 text-slate-900'
                                    }}
                                "
                            >
                                {{ $car->category }}
                            </span>

                        </div>


                        {{-- Content --}}

                        <div class="p-5">

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
                                    items-center
                                    justify-between
                                    border-t
                                    border-slate-100
                                    pt-4
                                "
                            >

                                <span
                                    class="
                                        text-sm
                                        font-bold
                                        text-slate-500
                                    "
                                >
                                    {{ $car->release_year }}
                                </span>

                                <span
                                    class="
                                        text-xs
                                        font-semibold
                                        text-slate-400
                                    "
                                >
                                    ID #{{ $car->id }}
                                </span>

                            </div>


                            <div
                                class="
                                    mt-5
                                    grid
                                    grid-cols-2
                                    gap-3
                                "
                            >

                                <a
                                    href="{{ route(
                                        'admin.cars.edit',
                                        $car
                                    ) }}"
                                    class="
                                        rounded-lg
                                        bg-[#1268d1]
                                        px-4
                                        py-2.5
                                        text-center
                                        text-sm
                                        font-bold
                                        text-white
                                        transition
                                        hover:bg-[#0b57a8]
                                    "
                                >
                                    Edit
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.cars.destroy',
                                        $car
                                    ) }}"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="
                                            return confirm(
                                                'Delete this Hot Wheels car?'
                                            )
                                        "
                                        class="
                                            w-full
                                            rounded-lg
                                            border
                                            border-red-200
                                            bg-red-50
                                            px-4
                                            py-2.5
                                            text-sm
                                            font-bold
                                            text-red-700
                                            transition
                                            hover:bg-red-100
                                        "
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</x-layouts::app>