<div>
    <p>{{ $startsAt->monthName }}</p>
    <p>{{ $endsAt->monthName }}</p>
    <x-button label="<" wire:click="goToPreviousMonth" />
    <x-button label=">" wire:click="goToNextMonth" />
</div>
