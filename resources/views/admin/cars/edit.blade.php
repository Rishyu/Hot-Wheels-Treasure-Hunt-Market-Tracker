<x-layouts::app :title="__('Edit Car')">

    <div
        class="
            mx-auto
            max-w-4xl
            text-slate-900
        "
    >

        <a
            href="{{ route('admin.cars.index') }}"
            class="
                mb-5
                inline-flex
                text-sm
                font-bold
                text-[#1268d1]
                hover:underline
            "
        >
            ← Back to Car Management
        </a>


        <div
            class="
                overflow-hidden
                rounded-2xl
                border
                border-slate-200
                bg-white
                shadow-sm
            "
        >

            <div
                class="
                    bg-gradient-to-r
                    from-[#0b57a8]
                    to-[#1976d2]
                    px-6
                    py-7
                    text-white
                    sm:px-8
                "
            >

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
                    Edit {{ $car->model_name }}
                </h1>

                <p class="mt-2 text-blue-100">
                    Update the Hot Wheels listing information.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.cars.update', $car) }}"
                class="
                    grid
                    gap-6
                    p-6
                    sm:grid-cols-2
                    sm:p-8
                "
            >

                @csrf
                @method('PUT')


                <div>

                    <label
                        for="model_name"
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
                        id="model_name"
                        name="model_name"
                        type="text"
                        required
                        value="{{ old(
                            'model_name',
                            $car->model_name
                        ) }}"
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

                    @error('model_name')
                        <p class="mt-1 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label
                        for="series_name"
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
                        id="series_name"
                        name="series_name"
                        type="text"
                        required
                        value="{{ old(
                            'series_name',
                            $car->series_name
                        ) }}"
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

                    @error('series_name')
                        <p class="mt-1 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label
                        for="release_year"
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

                    <input
                        id="release_year"
                        name="release_year"
                        type="number"
                        required
                        value="{{ old(
                            'release_year',
                            $car->release_year
                        ) }}"
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

                    @error('release_year')
                        <p class="mt-1 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


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

                        <option
                            value="TH"
                            @selected(
                                old(
                                    'category',
                                    $car->category
                                ) === 'TH'
                            )
                        >
                            Treasure Hunt (TH)
                        </option>

                        <option
                            value="STH"
                            @selected(
                                old(
                                    'category',
                                    $car->category
                                ) === 'STH'
                            )
                        >
                            Super Treasure Hunt (STH)
                        </option>

                    </select>

                    @error('category')
                        <p class="mt-1 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div class="sm:col-span-2">

                    <label
                        for="image"
                        class="
                            mb-2
                            block
                            text-sm
                            font-bold
                            text-slate-700
                        "
                    >
                        Image URL
                    </label>

                    <input
                        id="image"
                        name="image"
                        type="text"
                        value="{{ old(
                            'image',
                            $car->image
                        ) }}"
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

                    @error('image')
                        <p class="mt-1 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div class="sm:col-span-2">

                    <label
                        for="description"
                        class="
                            mb-2
                            block
                            text-sm
                            font-bold
                            text-slate-700
                        "
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
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
                    >{{ old(
                        'description',
                        $car->description
                    ) }}</textarea>

                    @error('description')
                        <p class="mt-1 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div
                    class="
                        flex
                        flex-col-reverse
                        gap-3
                        border-t
                        border-slate-200
                        pt-6
                        sm:col-span-2
                        sm:flex-row
                        sm:justify-end
                    "
                >

                    <a
                        href="{{ route('admin.cars.index') }}"
                        class="
                            rounded-lg
                            border
                            border-slate-300
                            bg-white
                            px-6
                            py-3
                            text-center
                            font-bold
                            text-slate-700
                            hover:bg-slate-50
                        "
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="
                            rounded-lg
                            bg-yellow-400
                            px-7
                            py-3
                            font-black
                            text-slate-900
                            shadow-sm
                            hover:bg-yellow-300
                        "
                    >
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>