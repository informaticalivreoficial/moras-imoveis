<?php

namespace App\Livewire\Dashboard\Properties;

use App\Models\Config;
use App\Models\Property;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Intervention\Image\Facades\Image;

class Properties extends Component
{
    use WithPagination;

    // Quantidade de itens por página
    public int $perPage = 12;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    protected $updatesQueryString = ['search'];

    public string $sortField = 'created_at';

    public string $sortDirection = 'asc';

    public bool $active;

    public ?int $delete_id = null;    

    #{Url}
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 12; // aumenta a quantidade de itens carregados
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
        $searchableFields = ['title','city','state','reference','type','neighborhood'];
        $properties = Property::query()
            ->when($this->search, function ($query) use ($searchableFields) {
                $query->where(function ($q) use ($searchableFields) {
                    foreach ($searchableFields as $field) {
                        $q->orWhere($field, 'LIKE', "%{$this->search}%");
                    }
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
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

        //$this->dispatch('highlightToggled'); // opcional: evento p/ mostrar toast
    }

    public function setDeleteId($id)
    {
        $this->delete_id = $id;
        $this->dispatch('delete-prompt');        
    }

    #[On('goOn-Delete')]
    public function delete(): void
    {
        try {
            $property = Property::findOrFail($this->delete_id);

            $property->delete(); // já dispara o hook no model

            $this->delete_id = null;

            $this->dispatch('swal', [
                'title' => 'Sucesso!',
                'icon'  => 'success',
                'text'  => 'Imóvel e todas as imagens foram removidas!',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Não foi possível excluir o imóvel.',
            ]);
        }
    }    

    public function applyWatermark(Property $property)
    {
        // Se já estiver marcada, não faz nada
        if ($property->display_marked_water) {
            return;
        }

        // Pega a marca d'água da tabela config
        $config = Config::first(); // ou filtro específico se tiver mais de uma
        if (!$config || !$config->watermark) {
            $this->dispatch('swal', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Nenhuma marca d’água configurada.'
            ]);
            return;
        }
        
        $watermarkPath = storage_path('app/public/' . $config->watermark);
        if (!file_exists($watermarkPath)) {
            $this->dispatch('swal', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Arquivo de marca d’água não encontrado.'
            ]);
            return;
        }

        foreach ($property->images as $image) {
            $imagePath = storage_path('app/public/' . $image->path);

            if (file_exists($imagePath)) {
                $img = Image::make($imagePath);
                $img->insert($watermarkPath, 'bottom-right', 20, 20); // posição
                $img->save($imagePath);
            }
        }

        // Atualiza o campo display_marked_water
        $property->update(['display_marked_water' => true]);

        $this->dispatch('swal', [
            'title' => 'Marca d’água aplicada!',
            'icon'  => 'success',
        ]);

        $property->refresh();
    }
}
