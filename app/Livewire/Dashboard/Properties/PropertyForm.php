<?php

namespace App\Livewire\Dashboard\Properties;

use App\Http\Requests\Admin\StoreUpdatePropertyRequest;
use App\Models\Property;
use App\Models\PropertyGb;
use App\Support\ImageService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class PropertyForm extends Component
{
    use WithFileUploads;

    public ?Property $property = null;

    public array $types = ['venda', 'locacao'];

    public array $images = [];

    public $savedImages = [];

    public string $currentTab = 'dados';

    public ?string $expired_at = null;

    public $category;

    public $type;

    public $sale_value;

    public $rental_value;

    public $location_period;

    public $iptu;

    public $construction_year;

    public $reference;

    public $condominium;

    public $description;

    public $additional_notes;

    public $dormitories;

    public $suites;

    public $bathrooms;

    public $rooms;

    public $garage;

    public $covered_garage;

    public $total_area;

    public $useful_area;

    public $measures;

    public $latitude;

    public $longitude;

    // Address
    public $zipcode;

    public $street;

    public $number;

    public $complement;

    public $neighborhood;

    public $state;

    public $city;

    // Acessórios
    public $ar_condicionado;

    public $aquecedor_solar;

    public $bar;

    public $biblioteca;

    public $churrasqueira;

    public $estacionamento;

    public $cozinha_americana;

    public $cozinha_planejada;

    public $dispensa;

    public $edicula;

    public $espaco_fitness;

    public $escritorio;

    public $fornodepizza;

    public $armarionautico;

    public $portaria24hs;

    public $quintal;

    public $zeladoria;

    public $salaodejogos;

    public $saladetv;

    public $areadelazer;

    public $balcaoamericano;

    public $varandagourmet;

    public $banheirosocial;

    public $brinquedoteca;

    public $pertodeescolas;

    public $condominiofechado;

    public $interfone;

    public $sistemadealarme;

    public $jardim;

    public $salaodefestas;

    public $permiteanimais;

    public $quadrapoliesportiva;

    public $geradoreletrico;

    public $banheira;

    public $lareira;

    public $lavabo;

    public $lavanderia;

    public $elevador;

    public $mobiliado;

    public $vista_para_mar;

    public $piscina;

    public $sauna;

    public $ventilador_teto;

    public $internet;

    public $geladeira;

    public $title;

    public $slug;

    public $url_booking;

    public $url_arbnb;

    public $status;

    public $views;

    public $headline;

    public $youtube_video;

    public $caption_img_cover;

    public $google_map;

    public $experience;

    public $highlight;

    public $publication_type;

    public array $metatags = [];

    public bool $sale = false;

    public bool $location = false;

    public ?int $display_address = 0; // 0 = Não, 1 = Sim

    public int $display_values = 0; // 0 = Não, 1 = Sim

    public ?int $display_marked_water = 0; // 0 = Não, 1 = Sim

    protected $booleanFields = [
        'ar_condicionado', 'aquecedor_solar', 'bar', 'biblioteca',
        'churrasqueira', 'estacionamento', 'cozinha_americana', 'cozinha_planejada', 'dispensa', 'edicula',
        'espaco_fitness', 'escritorio', 'fornodepizza', 'armarionautico', 'portaria24hs', 'quintal', 'zeladoria',
        'salaodejogos', 'saladetv', 'areadelazer', 'balcaoamericano', 'varandagourmet', 'banheirosocial',
        'brinquedoteca', 'pertodeescolas', 'condominiofechado', 'interfone', 'sistemadealarme', 'jardim',
        'salaodefestas', 'permiteanimais', 'quadrapoliesportiva', 'geradoreletrico', 'banheira', 'lareira',
        'lavabo', 'lavanderia', 'elevador', 'mobiliado', 'vista_para_mar', 'piscina', 'sauna', 'ventilador_teto',
        'internet', 'geladeira',
    ];

    public function render()
    {
        $titlee = $this->property->exists ? 'Editar Imóvel' : 'Cadastrar Imóvel';

        return view('livewire.dashboard.properties.property-form')->with([
            'titlee' => $titlee,
        ]);
    }

    public function mount(Property $property)
    {
        if ($property->exists) {
            $this->property = $property;

            $this->display_address = $property->exists ? (int) $property->display_address : 0;
            $this->display_values = $property->exists ? (int) $property->display_values : 0;
            $this->display_marked_water = $property->exists ? (int) $property->display_marked_water : 0;

            $this->sale = (bool) $property->sale;
            $this->location = (bool) $property->location;

            // Preenche todos os campos exceto metatags
            $data = collect($property->toArray())
                ->except(['metatags', 'sale', 'location', 'display_marked_water'])
                ->toArray();
            $this->fill($data);

            // Converte booleanos
            foreach ($this->booleanFields as $field) {
                $this->{$field} = (bool) $property->{$field};
            }

            // Metatags como array
            $this->metatags = is_string($property->metatags)
                ? explode(',', $property->metatags)
                : [];
        } else {
            $this->property = new Property;
        }
    }

    // Salvar (create ou update)
    public function save(string $mode = 'draft')
    {
        try {
            // Validação principal
            $validated = $this->validate((new StoreUpdatePropertyRequest)->rules());
            // Converte array de metatags em string para o banco
            $validated['metatags'] = implode(',', $this->metatags ?? []);
            // status depende do botão
            $validated['status'] = $mode === 'published' ? 1 : 0;

            foreach ($this->booleanFields as $field) {
                $validated[$field] = (bool) $this->{$field};
            }

            // Valida as imagens enviadas (jpeg, jpg, png, webp — até 5MB, pois serão convertidas para WebP)
            $this->validate([
                'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120',
            ]);

            if ($this->property->exists) {
                // Atualizar
                $this->property->update($validated);

                if (! $this->storeImages()) {
                    return;
                }

                $this->reset('images');
                $this->dispatch(['atualizado']);
            } else {
                // Criar
                if (! $this->sale && ! $this->location) {
                    $this->dispatch('swal', [
                        'title' => 'Erro!',
                        'icon' => 'error',
                        'text' => 'Selecione pelo menos uma finalidade (Venda ou Locação).',
                    ]);
                    throw ValidationException::withMessages([
                        'sale' => 'Selecione pelo menos uma finalidade (Venda ou Locação).',
                    ]);
                }

                $property = Property::create($validated);
                $this->property = $property; // Atualiza a propriedade para o novo registro

                if (! $this->storeImages()) {
                    return;
                }

                $this->reset('images');
                $this->dispatch(['cadastrado']);
            }

        } catch (ValidationException $e) {
            // Muda para a aba "dados" se houver erro
            $this->currentTab = 'dados';
            throw $e; // Deixa Livewire lidar com os erros e mostrar mensagens
        }
    }

    /**
     * Salva as imagens enviadas (convertidas para WebP) vinculadas ao imóvel.
     *
     * @return bool false se o limite de imagens foi atingido (mensagem já exibida)
     */
    protected function storeImages(): bool
    {
        $maxImages = (int) env('MAX_PROPERTY_IMAGES', 40);
        $existingImages = $this->property->images()->count();
        $allowed = $maxImages - $existingImages;

        if (count($this->images ?? []) > $allowed) {
            $this->dispatch('swal', [
                'title' => 'Atenção!',
                'text' => "Você já atingiu o limite máximo de {$maxImages} imagens para este imóvel.",
                'icon' => 'warning',
            ]);

            return false;
        }

        foreach ($this->images as $index => $image) {
            if ($index >= $allowed) {
                break;
            } // garante que só serão salvas as permitidas

            // Converte para WebP e salva no R2
            $path = ImageService::storeAsWebp($image, 'properties/'.$this->property->id);

            $maxOrder = PropertyGb::where('property', $this->property->id)->max('order_img') ?? 0;

            PropertyGb::create([
                'property' => $this->property->id,
                'path' => $path,
                'cover' => $this->cover ?? null,
                'order_img' => $maxOrder + $index + 1,
            ]);
        }

        return true;
    }

    // Remover imagem temporária
    public function removeTempImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    // Remover imagem do Bd
    public function removeSavedImage($id)
    {
        $image = PropertyGb::find($id);
        if ($image) {
            Storage::disk('r2')->delete($image->path);
            $image->delete();
            $this->savedImages = collect($this->savedImages)->filter(fn ($img) => $img->id !== $id);
            $this->property->refresh(); // Para garantir que os dados estejam atualizados
        }
    }

    public function toggleCover($imageId)
    {
        $image = PropertyGb::where('id', $imageId)->where('property', $this->property->id)->first();

        if ($image) {
            if ($image->cover) {
                // Se já é capa, remove
                $image->update(['cover' => 0]);
            } else {
                // Remove capa das outras e define esta
                PropertyGb::where('property', $this->property->id)->update(['cover' => 0]);
                $image->update(['cover' => 1]);
            }

            // Atualiza a relação para refletir na view
            $this->property->refresh();
        }
    }

    public function updatedZipcode(string $value)
    {
        $this->zipcode = preg_replace('/[^0-9]/', '', $value);

        if (strlen($this->zipcode) === 8) {
            $response = Http::get("https://viacep.com.br/ws/{$this->zipcode}/json/")->json();
            if (! isset($response['erro'])) {
                $this->street = $response['logradouro'] ?? '';
                $this->neighborhood = $response['bairro'] ?? '';
                $this->state = $response['uf'] ?? '';
                $this->city = $response['localidade'] ?? '';
                $this->complement = $response['complemento'] ?? '';
            } else {
                $this->addError('zipcode', 'CEP não encontrado.');
            }
        }
    }

    #[On('updateDescription')]
    public function updateDescription($value)
    {
        $this->description = $value;
    }

    public function updateImageOrder($order)
    {
        try {
            foreach ($order as $item) {
                PropertyGb::where('id', $item['id'])
                    ->where('property', $this->property->id)
                    ->update(['order_img' => $item['position']]);
            }

            // Atualiza a propriedade para refletir a nova ordem
            $this->property->refresh();

        } catch (\Exception $e) {
            $this->toastError('Erro ao atualizar ordem das imagens: '.$e->getMessage());
        }
    }
}
