<x-layouts::app :title="__('Add Car')">

    <div class="mx-auto max-w-3xl p-6">

        <flux:heading size="xl">
            {{ __('Add Hot Wheels Car') }}
        </flux:heading>

        <flux:text class="mt-2">
            {{ __('Create a new TH or STH car entry.') }}
        </flux:text>


        <form
            method="POST"
            action="{{ route('admin.cars.store') }}"
            class="mt-6 space-y-5"
        >
            @csrf


            <flux:input
                name="model_name"
                :label="__('Model Name')"
                :value="old('model_name')"
                required
            />

            @error('model_name')
                <p class="text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror


            <flux:input
                name="series_name"
                :label="__('Series Name')"
                :value="old('series_name')"
                required
            />

            @error('series_name')
                <p class="text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror


            <flux:input
                name="release_year"
                type="number"
                :label="__('Release Year')"
                :value="old('release_year')"
                required
            />

            @error('release_year')
                <p class="text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror


            <div>

                <label class="mb-2 block font-medium">
                    Category
                </label>

                <select
                    name="category"
                    class="w-full rounded-lg border p-3"
                    required
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
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <div>

                <label class="mb-2 block font-medium">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="w-full rounded-lg border p-3"
                >{{ old('description') }}</textarea>

            </div>


            <flux:input
                name="image"
                :label="__('Image URL / Path')"
                :value="old('image')"
            />


            <div class="flex gap-3">

                <flux:button
                    type="submit"
                    variant="primary"
                >
                    {{ __('Add Car') }}
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