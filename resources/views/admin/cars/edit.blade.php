<x-layouts::app :title="__('Edit Car')">

    <div class="mx-auto max-w-3xl p-6">

        <flux:heading size="xl">
            {{ __('Edit Hot Wheels Car') }}
        </flux:heading>

        <flux:text class="mt-2">
            {{ $car->model_name }}
        </flux:text>


        <form
            method="POST"
            action="{{ route('admin.cars.update', $car) }}"
            class="mt-6 space-y-5"
        >
            @csrf
            @method('PUT')


            <flux:input
                name="model_name"
                :label="__('Model Name')"
                :value="old('model_name', $car->model_name)"
                required
            />


            <flux:input
                name="series_name"
                :label="__('Series Name')"
                :value="old('series_name', $car->series_name)"
                required
            />


            <flux:input
                name="release_year"
                type="number"
                :label="__('Release Year')"
                :value="old('release_year', $car->release_year)"
                required
            />


            <div>

                <label class="mb-2 block font-medium">
                    Category
                </label>

                <select
                    name="category"
                    class="w-full rounded-lg border p-3"
                    required
                >

                    <option
                        value="TH"
                        @selected(
                            old('category', $car->category) === 'TH'
                        )
                    >
                        Treasure Hunt (TH)
                    </option>

                    <option
                        value="STH"
                        @selected(
                            old('category', $car->category) === 'STH'
                        )
                    >
                        Super Treasure Hunt (STH)
                    </option>

                </select>

            </div>


            <div>

                <label class="mb-2 block font-medium">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="w-full rounded-lg border p-3"
                >{{ old('description', $car->description) }}</textarea>

            </div>


            <flux:input
                name="image"
                :label="__('Image URL / Path')"
                :value="old('image', $car->image)"
            />


            <div class="flex gap-3">

                <flux:button
                    type="submit"
                    variant="primary"
                >
                    {{ __('Save Changes') }}
                </flux:button>

                <flux:button
                    :href="route('admin.cars.index')"
                >
                    {{ __('Cancel') }}
                </flux:button>

            </div>

        </form>

    </div>

</x-layouts::app>