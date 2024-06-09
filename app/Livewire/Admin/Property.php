<?php

namespace App\Livewire\Admin;

use App\Models\Property as ModelsProperty;
use Livewire\Component;
use Livewire\WithPagination;

class Property extends Component
{
    use WithPagination;
    public $propertyId;
    
    public function render()
    {
        return view('admin.properties.livewire.list',[
            'properties' => ModelsProperty::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(50),
        ]);
    }

    public function store()
    {

    }

    public function edit($id)
    {

    }
}
