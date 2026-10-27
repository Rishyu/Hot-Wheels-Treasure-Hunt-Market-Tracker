<x-layouts::app :title="__('Admin')">
    <div class="p-6">
        <flux:heading size="xl">
            {{ __('Administrator Area') }}
        </flux:heading>

        <flux:text class="mt-2">
            {{ __('This page is restricted to administrator accounts.') }}
        </flux:text>
    </div>
</x-layouts::app>