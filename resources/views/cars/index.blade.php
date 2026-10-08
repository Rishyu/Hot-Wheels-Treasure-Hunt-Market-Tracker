<x-layouts::app :title="__('Hot Wheels Cars')">
    <div class="mx-auto max-w-7xl p-6">

        <div class="mb-6">
            <flux:heading size="xl">
                {{ __('Hot Wheels Collection') }}
            </flux:heading>

            <flux:text class="mt-2">
                {{ __('Browse Treasure Hunt and Super Treasure Hunt cars.') }}
            </flux:text>
        </div>

        @if ($cars->isEmpty())
            <div class="rounded-lg border p-6">
                <flux:text>
                    {{ __('No Hot Wheels cars are available yet.') }}
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

                        <div class="mb-4 text-sm">
                            Release Year: {{ $car->release_year }}
                        </div>

                        @if ($car->description)
                            <flux:text class="mb-4">
                                {{ \Illuminate\Support\Str::limit($car->description, 100) }}
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