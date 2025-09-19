<?php

namespace App\Livewire\Dashboard\Properties;

use App\Http\Requests\Admin\StoreUpdatePropertyRequest;
use App\Models\Property;
use App\Models\PropertyGb;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PropertyForm extends Component
{
    use WithFileUploads;

    public ?Property $property = null;

    public string $option = 'venda';
    public array $types = ['venda', 'locacao'];

    public array $images = [];
    public $savedImages = [];

    public string $currentTab = 'dados'; 
    public ?string $expired_at = null;

    public $category, $type, $display_values,
       $sale_value, $rental_value, $location_period, $iptu, $construction_year,
       $reference, $condominium, $description, $additional_notes,
       $dormitories, $suites, $bathrooms, $rooms, $garage, $covered_garage,
       $total_area, $useful_area, $measures,
       $latitude, $longitude, 
       // Address
       $display_address, $zipcode, $street, $number, $complement,
       $neighborhood, $state, $city,
       
       // Acessórios
       $ar_condicionado, $aquecedor_solar, $bar, $biblioteca, $churrasqueira, $estacionamento,
       $cozinha_americana, $cozinha_planejada, $dispensa, $edicula, $espaco_fitness,
       $escritorio, $fornodepizza, $armarionautico, $portaria24hs, $quintal, $zeladoria,
       $salaodejogos, $saladetv, $areadelazer, $balcaoamericano, $varandagourmet,
       $banheirosocial, $brinquedoteca, $pertodeescolas, $condominiofechado,
       $interfone, $sistemadealarme, $jardim, $salaodefestas, $permiteanimais,
       $quadrapoliesportiva, $geradoreletrico, $banheira, $lareira, $lavabo, $lavanderia,
       $elevador, $mobiliado, $vista_para_mar, $piscina, $sauna, $ventilador_teto,
       $internet, $geladeira,

       $title, $slug, $url_booking, $url_arbnb, $status, $views,
       $headline, $display_marked_water, $youtube_video, $caption_img_cover,
       $google_map, $experience, $highlight, $publication_type;

       public array $metatags = [];

    protected $booleanFields = [
        'display_values','display_address','ar_condicionado','aquecedor_solar','bar','biblioteca',
        'churrasqueira','estacionamento','cozinha_americana','cozinha_planejada','dispensa','edicula',
        'espaco_fitness','escritorio','fornodepizza','armarionautico','portaria24hs','quintal','zeladoria',
        'salaodejogos','saladetv','areadelazer','balcaoamericano','varandagourmet','banheirosocial',
        'brinquedoteca','pertodeescolas','condominiofechado','interfone','sistemadealarme','jardim',
        'salaodefestas','permiteanimais','quadrapoliesportiva','geradoreletrico','banheira','lareira',
        'lavabo','lavanderia','elevador','mobiliado','vista_para_mar','piscina','sauna','ventilador_teto',
        'internet','geladeira','display_marked_water',
    ];

    public function render()
    {
        $titlee = $this->property ? 'Editar Imóvel' : 'Cadastrar Imóvel';
        return view('livewire.dashboard.properties.property-form')->with([
            'titlee' => $titlee,
        ]);
    }

    public function mount(Property $property)
    {
        if ($property->exists) {
            $this->property = $property;

            // Preenche todos os campos exceto metatags
            $data = collect($property->toArray())
                ->except(['metatags'])
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
            $this->property = new Property();
        }
    }

    // Salvar (create ou update)
    public function save(string $mode = 'draft')
    {
        try {            
            // Validação principal            
            $validated = $this->validate((new StoreUpdatePropertyRequest())->rules()); 
            // Converte array de metatags em string para o banco
            $validated['metatags'] = implode(',', $this->metatags ?? []);
            // status depende do botão
            $validated['status'] = $mode === 'published' ? 1 : 0;            

            foreach ($this->booleanFields as $field) {
                $validated[$field] = (bool) $this->{$field};
            }

            if($this->property->exists){
                //Atualizar
                
                $this->property->update($validated);
                $this->property->setSlug();

                // Validação das imagens
                $this->validate([
                    'images.*' => 'image|max:2048',
                ]);

                // Salvar imagens
                foreach ($this->images as $image) {
                    $path = $image->store('properties/' . $this->property->id, 'public');
                    PropertyGb::create([
                        'property' => $this->property->id,
                        'path' => $path,
                        'cover' => $this->cover ?? null,
                    ]);
                }
    
                // Limpar imagens temporárias
                $this->reset('images');
                $this->dispatch(['atualizado']);
            }else{
                //Criar
                
                $property = Property::create($validated);
                session()->flash('message', 'Imóvel cadastrado com sucesso!');
                return redirect()->route('dashboard.properties.edit', $property);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
            // Muda para a aba "dados" se houver erro
            $this->currentTab = 'dados';
            throw $e; // Deixa Livewire lidar com os erros e mostrar mensagens
        }        
    }

    //Remover imagem temporária
    public function removeTempImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    //Remover imagem do Bd
    public function removeSavedImage($id)
    {
        $image = PropertyGb::find($id);
        if ($image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
            $this->savedImages = collect($this->savedImages)->filter(fn ($img) => $img->id !== $id);
            $this->manifest->refresh(); // Para garantir que os dados estejam atualizados
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

        if(strlen($this->zipcode) === 8){
            $response = Http::get("https://viacep.com.br/ws/{$this->zipcode}/json/")->json();            
            if(!isset($response['erro'])){                
                $this->street = $response['logradouro'] ?? '';
                $this->neighborhood = $response['bairro'] ?? '';
                $this->state = $response['uf'] ?? '';
                $this->city = $response['localidade'] ?? '';
                $this->complement = $response['complemento'] ?? '';      
            }else{                
                $this->addError('zipcode', 'CEP não encontrado.'); 
            }
        }
    }
}
