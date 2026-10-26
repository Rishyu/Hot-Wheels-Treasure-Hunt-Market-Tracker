<x-layouts::app :title="__('Hot Wheels Cars')">

    <div class="mx-auto max-w-7xl p-6">

        <div class="mb-6">
            <flux:heading size="xl">
                {{ __('Hot Wheels Collection') }}
            </flux:heading>

            <flux:text class="mt-2">
                {{ __('Search and browse Treasure Hunt and Super Treasure Hunt cars.') }}
            </flux:text>
        </div>


        <!-- Search / Filter / Sort -->

        <form
            method="GET"
            action="{{ route('cars.index') }}"
            class="mb-8 rounded-xl border p-5"
        >

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">

                <!-- Model Search -->

                <flux:input
                    name="model"
                    :label="__('Model Name')"
                    :value="request('model')"
                    placeholder="Example: Batmobile"
                />


                <!-- Series Search -->

                <flux:input
                    name="series"
                    :label="__('Series Name')"
                    :value="request('series')"
                    placeholder="Example: Factory Fresh"
                />


                <!-- Year -->

                <div>
                    <label class="mb-2 block font-medium">
                        Release Year
                    </label>

                    <select
                        name="year"
                        class="w-full rounded-lg border p-3"
                    >
                        <option value="">
                            All Years
                        </option>

                        @foreach ($years as $year)
                            <option
                                value="{{ $year }}"
                                @selected(request('year') == $year)
                            >
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- Category -->

                <div>
                    <label class="mb-2 block font-medium">
                        Category
                    </label>

                    <select
                        name="category"
                        class="w-full rounded-lg border p-3"
                    >
                        <option value="">
                            All Categories
                        </option>

                        <option
                            value="TH"
                            @selected(request('category') === 'TH')
                        >
                            Treasure Hunt (TH)
                        </option>

                        <option
                            value="STH"
                            @selected(request('category') === 'STH')
                        >
                            Super Treasure Hunt (STH)
                        </option>
                    </select>
                </div>


                <!-- Sort -->

                <div>
                    <label class="mb-2 block font-medium">
                        Sort By
                    </label>

                    <select
                        name="sort"
                        class="w-full rounded-lg border p-3"
                    >
                        <option
                            value="year_desc"
                            @selected(
                                request('sort', 'year_desc') === 'year_desc'
                            )
                        >
                            Year: Newest First
                        </option>

                        <option
                            value="year_asc"
                            @selected(
                                request('sort') === 'year_asc'
                            )
                        >
                            Year: Oldest First
                        </option>

                        <option
                            value="price_asc"
                            @selected(
                                request('sort') === 'price_asc'
                            )
                        >
                            Average Price: Low to High
                        </option>

                        <option
                            value="price_desc"
                            @selected(
                                request('sort') === 'price_desc'
                            )
                        >
                            Average Price: High to Low
                        </option>
                    </select>
                </div>

            </div>


            <div class="mt-5 flex gap-3">

                <flux:button
                    type="submit"
                    variant="primary"
                >
                    {{ __('Apply Filters') }}
                </flux:button>

                <flux:button
                    :href="route('cars.index')"
                >
                    {{ __('Clear') }}
                </flux:button>

            </div>

        </form>


        <!-- Cars -->

        @if ($cars->isEmpty())

            <div class="rounded-lg border p-6">

                <flux:heading size="lg">
                    {{ __('No cars found') }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ __('Try changing your search or filters.') }}
                </flux:text>

            </div>

        @else

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($cars as $car)

                    <div class="rounded-xl border p-5">

                        <div class="mb-3 flex items-start justify-between gap-4">

                            <div>

                                <flux:heading size="lg">
                                    {{ $car->model_name }}
                                </flux:heading>

                                <flux:text>
                                    {{ $car->series_name }}
                                </flux:text>

                            </div>

                            <span class="rounded-full border px-3 py-1 text-sm">
                                {{ $car->category }}
                            </span>

                        </div>


                        <div class="mb-2 text-sm">
                            <strong>
                                Release Year:
                            </strong>

                            {{ $car->release_year }}
                        </div>


                        <div class="mb-4 text-sm">

                            <strong>
                                Average Approved Price:
                            </strong>

                            @if (
                                $car->approved_prices_avg_price !== null
                            )

                                ${{ number_format(
                                    $car->approved_prices_avg_price,
                                    2
                                ) }}

                            @else

                                No approved pricing

                            @endif

                        </div>


                        @if ($car->description)

                            <flux:text class="mb-4">
                                {{ \Illuminate\Support\Str::limit(
                                    $car->description,
                                    100
                                ) }}
                            </flux:text>

                        @endif


                        <flux:button
                            :href="route('cars.show', $car)"
                            variant="primary"
                        >
                            {{ __('View Details') }}
                        </flux:button>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</x-layouts::app>