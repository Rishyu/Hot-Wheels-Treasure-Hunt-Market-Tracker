<x-layouts::app :title="__('Pricing Approvals')">
    <div class="mx-auto max-w-6xl p-6">

        <div class="mb-6">
            <flux:heading size="xl">
                {{ __('Pending Pricing Submissions') }}
            </flux:heading>

            <flux:text class="mt-2">
                {{ __('Review collector-submitted Hot Wheels prices.') }}
            </flux:text>
        </div>

        @if (session('admin_pricing_status'))
            <div class="mb-6 rounded-lg border p-4">
                {{ session('admin_pricing_status') }}
            </div>
        @endif

        @if ($pendingSubmissions->isEmpty())

            <div class="rounded-xl border p-6">
                <flux:text>
                    {{ __('There are no pending pricing submissions.') }}
                </flux:text>
            </div>

        @else

            <div class="space-y-5">
                @foreach ($pendingSubmissions as $submission)

                    <div class="rounded-xl border p-6">

                        <div class="flex flex-col justify-between gap-6 md:flex-row">

                            <div class="space-y-2">

                                <flux:heading size="lg">
                                    {{ $submission->car->model_name }}
                                </flux:heading>

                                <flux:text>
                                    {{ $submission->car->series_name }}
                                    ·
                                    {{ $submission->car->release_year }}
                                    ·
                                    {{ $submission->car->category }}
                                </flux:text>

                                <div class="mt-4">
                                    <strong>{{ __('Price:') }}</strong>

                                    {{ number_format($submission->price, 2) }}
                                    {{ $submission->currency }}
                                </div>

                                <div>
                                    <strong>{{ __('Submission Date:') }}</strong>

                                    {{ $submission->submission_date->format('Y-m-d') }}
                                </div>

                                <div>
                                    <strong>{{ __('Submitted By:') }}</strong>

                                    {{ $submission->user?->username
                                        ?? $submission->user?->email
                                        ?? __('Unknown User') }}
                                </div>

                                <div>
                                    <strong>{{ __('Status:') }}</strong>

                                    {{ $submission->status }}
                                </div>

                            </div>

                            <div class="flex items-start gap-3">

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.pricing.approve',
                                        $submission
                                    ) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <flux:button
                                        type="submit"
                                        variant="primary"
                                    >
                                        {{ __('Approve') }}
                                    </flux:button>
                                </form>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.pricing.reject',
                                        $submission
                                    ) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <flux:button
                                        type="submit"
                                        variant="danger"
                                    >
                                        {{ __('Reject') }}
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