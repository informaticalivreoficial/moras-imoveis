<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $highlight = Property::where('highlight', 1)->available()->first();
        return view('livewire.home',[
            'highlight' => $highlight,
        ]);
    }
}
