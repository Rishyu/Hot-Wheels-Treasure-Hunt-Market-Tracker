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

        @if (session('status'))
            <div class="mb-6 rounded-lg border p-4">
                {{ session('status') }}
            </div>
        @endif

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

            <div class="mt-6">
                @if ($isFavorite)
                    <form
                        method="POST"
                        action="{{ route('cars.unfavorite', $car) }}"
                    >
                        @csrf
                        @method('DELETE')

                        <flux:button
                            type="submit"
                            variant="danger"
                        >
                            {{ __('Remove Favorite') }}
                        </flux:button>
                    </form>
                @else
                    <form
                        method="POST"
                        action="{{ route('cars.favorite', $car) }}"
                    >
                        @csrf

                        <flux:button
                            type="submit"
                            variant="primary"
                        >
                            {{ __('Save Favorite') }}
                        </flux:button>
                    </form>
                @endif
            </div>
            <div class="mt-8 border-t pt-6">
                <flux:heading size="lg">
                    {{ __('Submit Pricing') }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ __('Submit a price you have found for this Hot Wheels car.') }}
                </flux:text>

                @if (session('pricing_status'))
                    <div class="mt-4 rounded-lg border p-4">
                        {{ session('pricing_status') }}
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('cars.pricing.store', $car) }}"
                    class="mt-6 space-y-5"
                >
                    @csrf

                    <flux:input
                        name="price"
                        :label="__('Price')"
                        type="number"
                        step="0.01"
                        min="0"
                        :value="old('price')"
                        required
                    />

                    @error('price')
                        <div class="text-sm text-red-600">
                            {{ $message }}
                        </div>
                    @enderror

                    <flux:input
                        name="currency"
                        :label="__('Currency')"
                        type="text"
                        maxlength="3"
                        :value="old('currency', 'CAD')"
                        required
                    />

                    @error('currency')
                        <div class="text-sm text-red-600">
                            {{ $message }}
                        </div>
                    @enderror

                    <flux:input
                        name="submission_date"
                        :label="__('Date')"
                        type="date"
                        :value="old('submission_date', now()->toDateString())"
                        required
                    />

                    @error('submission_date')
                        <div class="text-sm text-red-600">
                            {{ $message }}
                        </div>
                    @enderror

                    <flux:button
                        type="submit"
                        variant="primary"
                    >
                        {{ __('Submit Price') }}
                    </flux:button>
                </form>
            </div>

        </div>
    </div>
</x-layouts::app>