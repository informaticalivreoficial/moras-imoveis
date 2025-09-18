<?php

namespace App\Livewire\Dashboard\Manifests;

use App\Models\Manifest;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ManifestsFinance extends Component
{
    use WithPagination;

    public string $search = '';

    public string $sortField = 'trip';

    public string $sortDirection = 'asc';

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
        $title = 'Gerenciar Manifestos no Financeiro';
        $manifests = Manifest::query()
            ->where('object', 'carga')
            ->where('section', 'financeiro')
            ->when($this->search, function($query){
                $query->where(function($q) {
                    $q->where('trip', 'LIKE', "%{$this->search}%")
                        //->orWhere('status', 'LIKE', "%{$this->search}%")
                        ->orWhere('type', 'LIKE', "%{$this->search}%")
                        ->orWhereRaw("LOWER(status) LIKE ?", ['%' . strtolower($this->search) . '%'])
                        //->orWhereHas('company', function ($q) {
                        //    $q->where('social_name', 'LIKE', "%{$this->search}%");
                        //})
                        ->orWhereHas('userObject', function ($q) {
                            $q->where('name', 'LIKE', "%{$this->search}%");
                        });
                });
        })->orderBy($this->sortField, $this->sortDirection)->paginate(50);

        return view('livewire.dashboard.manifests.manifests-finance',[
            'manifests' => $manifests
        ])->with('title', $title);
    }

    public function setDeleteId($id)
    {
        $this->delete_id = $id;
        $this->dispatch('delete-prompt');        
    }

    #[On('goOn-Delete')]
    public function delete()
    {
        $manifest = Manifest::find($this->delete_id);
        
        if ($manifest) {
            $manifest->delete();
            $this->delete_id = null;

            $this->dispatch('swal', [
                'title' => 'Sucesso!',
                'icon' => 'success',
                'text' => 'Manifesto removido com sucesso!'
            ]);
        } else {
            $this->dispatch('swal', [
                'title' => 'Error!',
                'icon' => 'error',
                'text' => 'Manifesto não encontrado!'
            ]);
        }
    }
}
