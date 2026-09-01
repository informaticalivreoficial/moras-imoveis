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

    public int $perPage = 24;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    // Filtros
    public string $filterNegocio = '';

    public string $filterCategory = '';

    public string $filterCity = '';

    public string $filterNeighborhood = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    protected $updatesQueryString = ['search', 'filterNegocio', 'filterCategory', 'filterCity', 'filterNeighborhood'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterNegocio(): void
    {
        $this->resetPage();
    }

    public function updatingFilterCategory(): void
    {
        $this->resetPage();
    }

    public function updatingFilterCity(): void
    {
        $this->resetPage();
        // Ao mudar cidade, reseta bairro (pois bairros dependem da cidade)
        $this->filterNeighborhood = '';
    }

    public function updatingFilterNeighborhood(): void
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 12;
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
            ->when($this->filterNegocio === 'sale', fn ($q) => $q->where('sale', 1)->where('location', 0))
            ->when($this->filterNegocio === 'location', fn ($q) => $q->where('location', 1)->where('sale', 0))
            ->when($this->filterNegocio === 'both', fn ($q) => $q->where('sale', 1)->where('location', 1))
            ->when($this->filterCategory !== '', fn ($q) => $q->where('category', $this->filterCategory))
            ->when($this->filterCity !== '', fn ($q) => $q->where('city', $this->filterCity))
            ->when($this->filterNeighborhood !== '', fn ($q) => $q->where('neighborhood', $this->filterNeighborhood))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $categories = Property::distinct()->pluck('category')->filter()->sort()->values();
        $cities = Property::distinct()->pluck('city')->filter()->sort()->values();
        $neighborhoods = Property::when($this->filterCity, function ($query) {
            $query->where('city', $this->filterCity);
        })->distinct()->pluck('neighborhood')->filter()->sort()->values();

        return view('livewire.dashboard.properties.properties', [
            'properties' => $properties,
            'categories' => $categories,
            'cities' => $cities,
            'neighborhoods' => $neighborhoods,
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
        if ($property->display_marked_water) {
            return;
        }

        $config = Config::first();
        if (! $config || ! $config->watermark) {
            $this->dispatch('swal', [
                'title' => 'Erro!',
                'icon' => 'error',
                'text' => 'Nenhuma marca dagua configurada.',
            ]);

            return;
        }

        $disk = Storage::disk('r2');

        if (! $disk->exists($config->watermark)) {
            $this->dispatch('swal', [
                'title' => 'Erro!',
                'icon' => 'error',
                'text' => 'Arquivo de marca dagua não encontrado.',
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

            $mark = $manager->read($watermarkBinary);
            $maxWidth = (int) ($img->width() * 0.25);
            if ($mark->width() > $maxWidth) {
                $mark->scale($maxWidth);
            }

            $img->place($mark, 'bottom-right', 20, 20);

            $disk->put(
                $image->path,
                (string) $img->toWebp(ImageService::WEBP_QUALITY),
                ['visibility' => 'public']
            );

            $image->update(['watermark' => true]);
        }

        $property->update(['display_marked_water' => true]);

        $this->dispatch('swal', [
            'title' => 'Marca dagua aplicada!',
            'icon' => 'success',
        ]);

        $property->refresh();
    }
}
