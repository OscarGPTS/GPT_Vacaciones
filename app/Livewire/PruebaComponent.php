<?php

namespace App\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

class PruebaComponent extends Component
{
    use Actions;
    public function render()
    {
        return view('livewire.prueba-component');
    }

    public function dialog(){
        $this->notification()->success(
            $title = 'Profile saved',
            $description = 'Your profile was successfully saved'
        );
    }
}
