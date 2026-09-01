<?php

namespace App\Livewire\Dashboard\Properties;

use App\Models\Config;
use App\Models\Property;
use App\Support\ImageService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Properties extends Component
{
    use WithPagination;

    // Quantidade de itens por página
    public int $perPage = 24;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    protected $updatesQueryString = ['search'];

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    // {Url}
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
        $searchableFields = ['title', 'city', 'state', 'reference', 'type', 'neighborhood'];
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

        return view('livewire.dashboard.properties.properties', [
            'properties' => $properties,
        ])->with('title', $title);
    }

    public function toggleStatus($id)
    {
        $property = Property::findOrFail($id);
        $property->status = ! $property->status;
        $property->save();
    }

    public function toggleHighlight(Property $property)
    {
        $property->highlight = ! $property->highlight;
        $property->save();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Imóvel',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteProperty',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteProperty')]
    public function deleteProperty($id): void
    {
        $property = Property::findOrFail($id);

        $property->delete();

        $this->dispatch('swal', [
            'title' => 'Excluído!',
            'text' => 'Imóvel e todas as imagens foram removidas!',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function applyWatermark(Property $property)
    {
        // Se já estiver marcada, não faz nada
        if ($property->display_marked_water) {
            return;
        }

        // Pega a marca d'água da tabela config
        $config = Config::first(); // ou filtro específico se tiver mais de uma
        if (! $config || ! $config->watermark) {
            $this->dispatch('swal', [
                'title' => 'Erro!',
                'icon' => 'error',
                'text' => 'Nenhuma marca d’água configurada.',
            ]);

            return;
        }

        $disk = Storage::disk('r2');

        // Marca d'água armazenada no R2
        if (! $disk->exists($config->watermark)) {
            $this->dispatch('swal', [
                'title' => 'Erro!',
                'icon' => 'error',
                'text' => 'Arquivo de marca d’água não encontrado.',
            ]);

            return;
        }

        $watermarkBinary = $disk->get($config->watermark);

        $manager = new ImageManager(new Driver);

        foreach ($property->images as $image) {
            if (! $disk->exists($image->path)) {
                continue;
            }

            $img = $manager->read($disk->get($image->path));

            // Prepara a marca d'água (redimensiona para no máximo 25% da largura da foto)
            $mark = $manager->read($watermarkBinary);
            $maxWidth = (int) ($img->width() * 0.25);
            if ($mark->width() > $maxWidth) {
                $mark->scale($maxWidth);
            }

            // Aplica a marca d'água no canto inferior direito
            $img->place($mark, 'bottom-right', 20, 20);

            // Salva de volta no R2 (WebP)
            $disk->put(
                $image->path,
                (string) $img->toWebp(ImageService::WEBP_QUALITY),
                ['visibility' => 'public']
            );

            $image->update(['watermark' => true]);
        }

        // Atualiza o campo display_marked_water
        $property->update(['display_marked_water' => true]);

        $this->dispatch('swal', [
            'title' => 'Marca d’água aplicada!',
            'icon' => 'success',
        ]);

        $property->refresh();
    }
}
