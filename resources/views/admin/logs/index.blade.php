<x-layouts::app :title="__('System Error Logs')">

    <div class="mx-auto max-w-7xl p-6">

        <div class="mb-6">
            <flux:heading size="xl">
                {{ __('System Error Logs') }}
            </flux:heading>

            <flux:text class="mt-2">
                {{ __('Recent Laravel application log entries.') }}
            </flux:text>
        </div>

        <div class="overflow-x-auto rounded-xl border p-4">
            <pre class="whitespace-pre-wrap break-words text-sm">{{ $logContent }}</pre>
        </div>

    </div>

</x-layouts::app>