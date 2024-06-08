<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Imovel extends Component
{
    public function getListProperty()
    {
        return Imovel::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(50);
    }

    public function render()
    {
        return view('admin.imoveis.livewire.list');
    }
}
