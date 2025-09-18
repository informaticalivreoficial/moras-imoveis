<?php

namespace App\Livewire\Dashboard;

use App\Models\Property;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        

        //$manifestCount = Trip::count();
        //$manifestYearCount = Trip::whereYear('start', now()->year)->count();
        

        return view('livewire.dashboard.dashboard',[
            
            //'manifestCount' => $manifestCount,
            //'manifestYearCount' => $manifestYearCount,
        ]);
    }
}
