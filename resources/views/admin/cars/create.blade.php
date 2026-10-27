<x-layouts::app :title="__('Add Car')">

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
                    Add Hot Wheels Car
                </h1>

                <p class="mt-2 text-blue-100">
                    Add a new TH or STH model to the database.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.cars.store') }}"
                class="
                    grid
                    gap-6
                    p-6
                    sm:grid-cols-2
                    sm:p-8
                "
            >

                @csrf


                {{-- Model --}}

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
                        value="{{ old('model_name') }}"
                        required
                        placeholder="e.g. Bone Shaker"
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


                {{-- Series --}}

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
                        value="{{ old('series_name') }}"
                        required
                        placeholder="e.g. Factory Fresh"
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


                {{-- Year --}}

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
                        value="{{ old('release_year') }}"
                        required
                        placeholder="2026"
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

                        <option value="">
                            Select category
                        </option>

                        <option
                            value="TH"
                            @selected(old('category') === 'TH')
                        >
                            Treasure Hunt (TH)
                        </option>

                        <option
                            value="STH"
                            @selected(old('category') === 'STH')
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


                {{-- Image --}}

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
                        value="{{ old('image') }}"
                        placeholder="https://..."
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

                    <p class="mt-2 text-xs text-slate-500">
                        Optional. Add an image URL for the car.
                    </p>

                    @error('image')
                        <p class="mt-1 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Description --}}

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
                        placeholder="Optional information about the car..."
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
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-1 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Actions --}}

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
                        Add Car
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>