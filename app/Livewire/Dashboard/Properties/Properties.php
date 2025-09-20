<?php

namespace App\Livewire\Dashboard\Properties;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class Properties extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'asc';

    public bool $active;

    public $delete_id;

    #{Url}
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function render()
    {
        $title = 'Lista de Imóveis';
        $properties = Property::query()->when($this->search, function($query){
            $query->orWhere('title', 'LIKE', "%{$this->search}%");
            $query->orWhere('city', 'LIKE', "%{$this->search}%");
        })->orderBy($this->sortField, $this->sortDirection)->paginate(35);
        return view('livewire.dashboard.properties.properties',[
            'properties' => $properties
        ])->with('title', $title);
    }

    public function toggleStatus($id)
    {              
        $property = Property::find($id);
        $property->status = !$this->active;        
        $property->save();
        $this->active = $property->status;
    }

    public function toggleHighlight(Property $property)
    {
        $property->highlight = !$property->highlight;
        $property->save();

        $this->dispatch('highlightToggled'); // opcional: evento p/ mostrar toast
    }
}
