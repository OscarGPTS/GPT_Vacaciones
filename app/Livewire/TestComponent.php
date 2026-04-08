<?php

namespace App\Livewire;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Omnia\LivewireCalendar\LivewireCalendar;

class TestComponent extends  LivewireCalendar
{
    // public function render()
    // {
    //     return view('livewire.test-component');
    // }
    public function events() : Collection
{
    return collect([
        [
            'id' => 1,
            'title' => 'Breakfast',
            'description' => 'Pancakes! 🥞',
            'date' => Carbon::today(),
        ],
        [
            'id' => 2,
            'title' => 'Meeting with Pamela',
            'description' => 'Work stuff',
            'date' => Carbon::tomorrow(),
        ],
    ]);
}
}
