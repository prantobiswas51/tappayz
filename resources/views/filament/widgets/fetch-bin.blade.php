<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget action: calls the fetch_bins route --}}
        <a href="{{ route('fetch_bins') }}" role="button" aria-label="Fetch BINs">
            <div class="" style="display: flex; justify-content: center; align-items: center;">
                Fetch BINs
                <x-heroicon-o-arrow-path class="w-2 h-2" style="max-width: 30px !important" />
            </div>
        </a>
    </x-filament::section>
</x-filament-widgets::widget>