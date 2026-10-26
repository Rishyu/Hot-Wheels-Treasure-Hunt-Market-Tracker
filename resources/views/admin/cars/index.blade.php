<x-layouts::app :title="__('Manage Cars')">

    <div class="mx-auto max-w-7xl p-6">

        <div class="mb-6 flex items-center justify-between">

            <div>
                <flux:heading size="xl">
                    {{ __('Manage Hot Wheels Cars') }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ __('Add, edit, and delete Hot Wheels entries.') }}
                </flux:text>
            </div>

            <flux:button
                :href="route('admin.cars.create')"
                variant="primary"
            >
                {{ __('Add Car') }}
            </flux:button>

        </div>

        @if (session('status'))
            <div class="mb-6 rounded-lg border p-4">
                {{ session('status') }}
            </div>
        @endif


        @if ($cars->isEmpty())

            <div class="rounded-xl border p-6">
                {{ __('No cars have been added yet.') }}
            </div>

        @else

            <div class="space-y-4">

                @foreach ($cars as $car)

                    <div class="rounded-xl border p-5">

                        <div class="flex flex-col justify-between gap-4 md:flex-row">

                            <div>

                                <flux:heading size="lg">
                                    {{ $car->model_name }}
                                </flux:heading>

                                <flux:text>
                                    {{ $car->series_name }}
                                </flux:text>

                                <div class="mt-2 text-sm">
                                    {{ $car->release_year }}
                                    ·
                                    {{ $car->category }}
                                </div>

                            </div>


                            <div class="flex items-start gap-3">

                                <flux:button
                                    :href="route('admin.cars.edit', $car)"
                                >
                                    {{ __('Edit') }}
                                </flux:button>


                                <form
                                    method="POST"
                                    action="{{ route('admin.cars.destroy', $car) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this car?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <flux:button
                                        type="submit"
                                        variant="danger"
                                    >
                                        {{ __('Delete') }}
                                    </flux:button>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</x-layouts::app>