<?php

namespace App\Livewire\Dashboard;

use App\Models\Property;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        

        $propertyCount = Property::count();
        $propertyYearCount = Property::whereYear('created_at', now()->year)->count();
        

        return view('livewire.dashboard.dashboard',[
            
            'propertyCount' => $propertyCount,
            'propertyYearCount' => $propertyYearCount,
        ]);
    }
}
