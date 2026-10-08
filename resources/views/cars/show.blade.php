<x-layouts::app :title="$car->model_name">
    <div class="mx-auto max-w-4xl p-6">

        <div class="mb-6">
            <flux:button
                :href="route('cars.index')"
                variant="ghost"
            >
                ← {{ __('Back to Cars') }}
            </flux:button>
        </div>

        <div class="rounded-xl border p-6">

            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <flux:heading size="xl">
                        {{ $car->model_name }}
                    </flux:heading>

                    <flux:text class="mt-2">
                        {{ $car->series_name }}
                    </flux:text>
                </div>

                <span class="rounded-full border px-3 py-1">
                    {{ $car->category }}
                </span>
            </div>

            <div class="space-y-4">
                <div>
                    <strong>{{ __('Release Year:') }}</strong>
                    {{ $car->release_year }}
                </div>

                <div>
                    <strong>{{ __('Series:') }}</strong>
                    {{ $car->series_name }}
                </div>

                <div>
                    <strong>{{ __('Category:') }}</strong>
                    {{ $car->category }}
                </div>

                <div>
                    <strong>{{ __('Description:') }}</strong>

                    <div class="mt-1">
                        {{ $car->description ?? __('No description available.') }}
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-layouts::app>