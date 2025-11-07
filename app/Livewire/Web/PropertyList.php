<?php

namespace App\Livewire\Web;

use App\Models\Property;
use Livewire\Component;
use Livewire\Attributes\On;

class PropertyList extends Component
{
    public $filters = [];

    protected $listeners = ['filterUpdated' => 'applyFilters'];

    public function applyFilters($filters)
    {
        $this->filters = $filters;
    }

    public function getFilteredProperties()
    {
        $query = Property::query();

        if (!empty($this->filters['operation'])) {
            if ($this->filters['operation'] === 'sale') {
                $query->where('sale', true);
            } elseif ($this->filters['operation'] === 'location') {
                $query->where('location', true);
            }
        }
        if (!empty($this->filters['cidade'])) {
            $query->where('city', $this->filters['cidade']);
        }
        if (!empty($this->filters['bairro'])) {
            $query->where('neighborhood', $this->filters['bairro']);
        }
        if (!empty($this->filters['valores'])) {
            if (($this->filters['operation'] ?? '') === 'sale') {
                $query->where('sale_value', '<=', $this->filters['valores']);
            } elseif (($this->filters['operation'] ?? '') === 'location') {
                $query->where('rental_value', '<=', $this->filters['valores']);
            } else {
                // Se não escolheu operação, aplica em ambos
                $query->where(function ($q) use ($filters) {
                    $q->where('sale_value', '<=', $filters['valores'])
                      ->orWhere('rental_value', '<=', $filters['valores']);
                });
            }
        }
        if (!empty($this->filters['dormitorios'])) {
            $query->where('dormitories', '>=', $this->filters['dormitorios']);
        }

        return $query->latest()->get();
    }

    public function render()
    {
        return view('livewire.web.property-list', [
            'properties' => $this->getFilteredProperties(),
        ]);
    }
}
