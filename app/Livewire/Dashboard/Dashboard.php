<?php

namespace App\Livewire\Dashboard;

use App\Models\Post;
use App\Models\Property;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        

        $propertyCount = Property::count();
        $propertyYearCount = Property::whereYear('created_at', now()->year)->count();

        $postsCount = Post::count();
        $postsYearCount = Post::whereYear('created_at', now()->year)->count();
        
        $title = 'Painel de Controle';
        return view('livewire.dashboard.dashboard',[            
            'propertyCount' => $propertyCount,
            'propertyYearCount' => $propertyYearCount,
            'postsCount' => $postsCount,
            'postsYearCount' => $postsYearCount,
            'title' => $title
        ]);
    }
}
