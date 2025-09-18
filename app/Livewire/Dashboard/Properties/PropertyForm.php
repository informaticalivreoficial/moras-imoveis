<?php

namespace App\Livewire\Dashboard\Properties;

use App\Models\Property;
use App\Models\PropertyGb;
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

    public $category, $type, $display_values,
       $sale_value, $rental_value, $location_period, $iptu, $construction_year,
       $reference, $condominium, $description, $additional_notes,
       $dormitories, $suites, $bathrooms, $rooms, $garage, $covered_garage,
       $total_area, $useful_area, $measures,
       $latitude, $longitude, $display_address, $zipcode, $street, $number, $complement,
       $neighborhood, $state, $city,
       
       // ... todos os acessórios
        $ar_condicionado, $aquecedor_solar, $bar, $biblioteca, $churrasqueira, $estacionamento,
        $cozinha_americana, $cozinha_planejada, $dispensa, $edicula, $espaco_fitness,
        $escritorio, $fornodepizza, $armarionautico, $portaria24hs, $quintal, $zeladoria,
        $salaodejogos, $saladetv, $areadelazer, $balcaoamericano, $varandagourmet,
        $banheirosocial, $brinquedoteca, $pertodeescolas, $condominiofechado,
        $interfone, $sistemadealarme, $jardim, $salaodefestas, $permiteanimais,
        $quadrapoliesportiva, $geradoreletrico, $banheira, $lareira, $lavabo, $lavanderia,
        $elevador, $mobiliado, $vista_para_mar, $piscina, $sauna, $ventilador_teto,
        $internet, $geladeira,

       $title, $slug, $url_booking, $url_arbnb, $status, $views, $metatags,
       $headline, $display_marked_water, $youtube_video, $caption_img_cover,
       $google_map, $experience, $highlight, $publication_type;


    public function render()
    {
        $titlee = $this->property ? 'Editar Imóvel' : 'Cadastrar Imóvel';
        return view('livewire.dashboard.properties.property-form')->with([
            'titlee' => $titlee,
        ]);
    }

    public function mount(Property $property)
    {
        if($this->property){
            $this->option = $this->property->option;
            $this->title = $this->property->title;
            
        }
        
        
        

    }

    // Salvar (create ou update)
    public function save()
    {
        //dd($property);
        //$this->validate();

        //$this->property->type = $this->type;
        //$this->property->save();

        //session()->flash('success', 'Propriedade salva com sucesso!');

        //return redirect()->route('properties.index');
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
}
