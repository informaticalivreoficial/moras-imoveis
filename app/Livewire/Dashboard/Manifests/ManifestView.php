<?php

namespace App\Livewire\Dashboard\Manifests;

use App\Models\Manifest;
use Livewire\Component;

class ManifestView extends Component
{
    public $manifest;

    public array $items = [];

    public function render()
    {
        $title = 'Visualizar Manifesto';
        return view('livewire.dashboard.manifests.manifest-view')->with('title', $title);
    }

    public function mount(Manifest $manifest)
    {
        $this->manifest = $manifest;
        //Items
        $this->items = $manifest->items->toArray();
    }


}
