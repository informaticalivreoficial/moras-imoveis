<?php

namespace App\Livewire\Dashboard\Manifests;

use App\Http\Requests\Admin\StoreUpdateManifestRequest;
use App\Models\Company;
use App\Models\Manifest;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\StatusOfManifestEnum;
use App\Http\Requests\Admin\StoreUpdateManifestItemRequest;
use App\Models\ManifestGb;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ManifestForm extends Component
{
    use WithFileUploads;

    public ?Manifest $manifest = null;

    public Collection $companies;
    public Collection $clients;
    public Collection $trips;

    public array $items = [];

    public ?int $trip = null;
    public ?int $company = null;
    public ?int $user = null;
    public ?string $object = null;
    public string $status = '';
    public ?string $zipcode = '53.990-000';
    public ?string $street = null;
    public ?string $number = null;
    public ?string $complement = null;
    public ?string $neighborhood = null;
    public ?string $city = 'Fernando de Noronha';
    public ?string $state = 'PE';
    public ?string $information = null;
    public ?string $contact = null;

    public string $type = 'fisica';
    public array $types = ['fisica', 'juridica'];

    public array $images = [];
    public $savedImages = [];

    public string $currentTab = 'dados'; 
    
    public string $section;

    public function render()
    {
        $title = $this->manifest ? 'Editar Manifesto' : 'Cadastrar Manifesto';
        return view('livewire.dashboard.manifests.manifest-form')->with([
            'title' => $title,
        ]);
    }

    public function updateSection(string $newSection)
    {
        $this->section = $newSection;
        if ($this->manifest) {
            $this->manifest->section = $newSection;
            $this->manifest->status = 'recebido';
            $this->manifest->save();
        }
        return redirect()->route(
            (
                $newSection == 'comercial' ? 'manifests.comercial' : (
                $newSection == 'financeiro' ? 'manifests.finance' : (
                $newSection == 'conferencia' ? 'manifests.comercial' : (
                $newSection == 'finalizado' ? 'manifests.finished' : (
                $newSection == 'financeiro-comercial' ? 'manifests.finance' : 'manifests.index')))))
            );
    }

    public function mount(Manifest $manifest)
    {
        $this->companies = Company::orderBy('social_name')->get();
        $this->clients = User::orderBy('name')->where('client', 1)->get();
        $this->trips = Trip::orderBy('start', 'desc')->whereYear('start', now()->year)->get();
        $this->currentTab = 'dados';

        if ($this->manifest) {
            $this->trip = $this->manifest->trip;
            $this->type = $this->manifest->type;
            $this->object = $this->manifest->object;
            $this->company = $this->manifest->company;
            $this->user = $this->manifest->user;
            $this->status = $manifest->status instanceof \App\Enums\StatusOfManifestEnum
            ? $manifest->status->value
            : (string) $manifest->status;
            //$this->zipcode = $this->manifest->zipcode ?? '53.990-000'; // Valor padrão se não for passado
            $this->zipcode = $this->manifest->zipcode;
            $this->street = $this->manifest->street;
            $this->number = $this->manifest->number;
            $this->complement = $this->manifest->complement;
            $this->neighborhood = $this->manifest->neighborhood;
            $this->city = $this->manifest->city;
            $this->state = $this->manifest->state;
            $this->information = $this->manifest->information;
            $this->contact = $this->manifest->contact;
            //Items
            $this->items = $manifest->items->toArray();
            $this->savedImages = $this->manifest->images;
        }        
    }

    public function save()
    {
        try {
            // Validação principal
            $request = new StoreUpdateManifestRequest();
            $request->merge([
                'trip' => $this->trip,
                'type' => $this->type,
                'object' => $this->object,
                'company' => $this->company,
                'user' => $this->user,
                'status' => $this->status,
                'zipcode' => $this->zipcode,
                'street' => $this->street,
                'number' => $this->number,
                'complement' => $this->complement,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'state' => $this->state,
                'information' => $this->information,
                'contact' => $this->contact,
            ]);
            $validated = validator($request->all(), $request->rules())->validate();
    
            // Validação antecipada dos itens
            $validatedItems = collect($this->items)->map(function ($item) {
                $itemRequest = new StoreUpdateManifestItemRequest();
                $itemRequest->merge($item);
                return validator($itemRequest->all(), $itemRequest->rules())->validate();
            });
    
            if ($this->manifest) {
                $this->manifest->update($validated);
                $this->manifest->items()->delete();
                foreach ($validatedItems as $item) {
                    $this->manifest->items()->create($item);
                }

                // Validação das imagens
                $this->validate([
                    'images.*' => 'image|max:2048',
                ]);
    
                foreach ($this->images as $image) {
                    $path = $image->store('manifests/' . $this->manifest->id, 'public');
                    ManifestGb::create([
                        'manifest' => $this->manifest->id,
                        'path' => $path,
                        'cover' => $this->cover ?? null,
                    ]);
                }
    
                $this->reset('images');
                $this->dispatch(['atualizado']);
            } else {
                $manifestCreate = Manifest::create($validated);
                foreach ($validatedItems as $item) {
                    $manifestCreate->items()->create($item);
                }
    
                // Validação das imagens
                $this->validate([
                    'images.*' => 'image|max:2048',
                ]);
    
                foreach ($this->images as $image) {
                    $path = $image->store('manifests/' . $manifestCreate->id, 'public');
                    ManifestGb::create([
                        'manifest' => $manifestCreate->id,
                        'path' => $path,
                        'cover' => $this->cover ?? null,
                    ]);
                }
    
                $this->reset('images');
                $this->dispatch(['cadastrado']);
                $this->manifest = $manifestCreate;
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Muda para a aba "dados" se houver erro
            $this->currentTab = 'dados';
            throw $e; // Deixa Livewire lidar com os erros e mostrar mensagens
        }
        // $request = new StoreUpdateManifestRequest();
        // $request->merge([
        //     'trip' => $this->trip,
        //     'type' => $this->type,
        //     'object' => $this->object,
        //     'company' => $this->company,
        //     'user' => $this->user,
        //     'status' => $this->status,
        //     'zipcode' => $this->zipcode,
        //     'street' => $this->street,
        //     'number' => $this->number,
        //     'complement' => $this->complement,
        //     'neighborhood' => $this->neighborhood,
        //     'city' => $this->city,
        //     'state' => $this->state,
        //     'information' => $this->information,
        //     'contact' => $this->contact,
        // ]);
        // $validated = validator($request->all(), $request->rules())->validate();        

        // // Validação antecipada dos itens
        // $validatedItems = collect($this->items)->map(function ($item) {
        //     $itemRequest = new StoreUpdateManifestItemRequest();
        //     $itemRequest->merge($item);
        //     return validator($itemRequest->all(), $itemRequest->rules())->validate();
        // });
        
        // if ($this->manifest) {
        //     //$this->manifest->update($data);
        //     $this->manifest->update($validated);
            
        //     $this->manifest->items()->delete();
        //     foreach ($validatedItems as $item) {
        //         $this->manifest->items()->create($item);
        //     }
        //     $this->dispatch(['atualizado']);
        // } else {            
        //     //$manifestCreate = Manifest::create($data);
        //     $manifestCreate = Manifest::create($validated);

        //     foreach ($validatedItems as $item) {
        //         $manifestCreate->items()->create($item);
        //     }     
            
        //     $this->validate([
        //         'images.*' => 'image|max:2048', // 2MB por imagem
        //     ]);
        //     foreach ($this->images as $image) {
        //         $path = $image->store('manifests/'.$manifestCreate->id, 'public');

        //         ManifestGb::create([
        //             'manifest' => $manifestCreate->id, // Relacionamento com o manifesto
        //             'path' => $path,
        //             'cover' => $this->cover ?? null, // Se você tiver uma imagem cover
        //         ]);
        //     }
        //     $this->reset('images');

        //     $this->dispatch(['cadastrado']);
        //     $this->manifest = $manifestCreate;
        // }
    }    

    public function addItem()
    {
        $this->items[] = [
            'unit' => '',
            'description' => '',
            'quantity' => '',
            'horti_fruit' => null,
            'cubage' => null,
            'secure' => null,
            'dry_weight' => null,
            'package' => null,
            'glace' => null,
            'tax' => null,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // reindexa
    }

    //Remover imagem temporária
    public function removeTempImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function removeSavedImage($id)
    {
        $image = ManifestGb::find($id);
        if ($image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
            $this->savedImages = collect($this->savedImages)->filter(fn ($img) => $img->id !== $id);
            $this->manifest->refresh(); // Para garantir que os dados estejam atualizados
        }
    }
    
}