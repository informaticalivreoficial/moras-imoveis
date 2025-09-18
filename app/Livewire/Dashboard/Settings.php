<?php

namespace App\Livewire\Dashboard;

use App\Models\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Settings extends Component
{
    use WithFileUploads;

    public array $configData = [];

    public string $currentTab = 'dados';

    public $logo;
    public $logo_admin;
    public $logo_footer;
    public $favicon;
    public $watermark;
    public $imgheader;
    public $metaimg;

    public array $tags = [];

    protected function imageValidationRules(): array
    {
        $rules = [];

        foreach (['logo', 'logo_admin', 'logo_footer', 'favicon', 'watermark', 'metaimg', 'imgheader'] as $field) {
            $isUpload = $this->{$field} instanceof TemporaryUploadedFile;
            $rules["configData.{$field}"] = $isUpload ? 'nullable|image|max:1024' : 'nullable|string';
        }

        return $rules;
    }

    protected function rules()
    {
        return array_merge([
            'configData.app_name' => 'required|min:3',
            //'configData.email' => 'required|email',
        ], $this->imageValidationRules());
    }

    protected function loadLogos()
    {
        $this->logo = $this->getLogo();
        $this->logo_admin = $this->getLogoadmin();
        $this->logo_footer = $this->getLogofooter();
        $this->favicon = $this->getfaveicon();
        $this->watermark = $this->getwatermark();
        $this->metaimg = $this->getmetaimg();
        $this->imgheader = $this->getheadersite();
    }

    public function mount()
    {
        $config = Config::findOrFail(1);
        $this->configData = $config->toArray();
        $this->tags = explode(',', $config->metatags ?? '');
        $this->loadLogos();
    }

    public function render()
    {
        $title = 'Configurações';
        return view('livewire.dashboard.settings')->with('title', $title);
    }

    public function update()
    {      
        try {
            $validated = $this->validate();            
            $this->handleImageUploads();            
            $this->configData['metatags'] = implode(',', $this->tags ?? []);            
            Config::updateOrCreate(['id' => 1], $this->configData);
            $this->resetImages();
            $this->dispatch(['atualizado']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura a primeira chave com erro
            $firstErrorKey = array_key_first($e->validator->errors()->messages());

            // Define a aba correta com base no campo com erro
            $this->currentTab = match (true) {
                str_starts_with($firstErrorKey, 'configData.app_name') => 'dados',

                //str_starts_with($firstErrorKey, 'configData.logo'),
                //$firstErrorKey === 'configData.logo' => 'imagens',

                str_starts_with($firstErrorKey, 'configData.meta_') => 'seo',

                str_starts_with($firstErrorKey, 'configData.contact_') => 'contato',

                default => 'dados',
            };

            throw $e; // Repassa a exceção para o Livewire exibir os erros no frontend
        } 
                
    }    

    public function updatedConfigDataZipcode(string $value)
    {
        $cep = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cep) === 8) {
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/")->json();

            if (!isset($response['erro'])) {
                $this->configData['street'] = $response['logradouro'] ?? '';
                $this->configData['neighborhood'] = $response['bairro'] ?? '';
                $this->configData['state'] = $response['uf'] ?? '';
                $this->configData['city'] = $response['localidade'] ?? '';
                //$this->configData['complement'] = $response['complemento'] ?? '';
            } else {
                $this->addError('configData.zipcode', 'CEP não encontrado.'); 
            }
        }
    }

    public function getQrCodeSvgProperty()
    {
        return QrCode::size(240)
            ->margin(2)
            //->format('png')
            ->color(0, 0, 255)
            //->merge($this->configData['favicon'] ? : asset('theme/images/chave.png'), 0.3)
            ->generate($this->configData['domain'] ?? env('DESENVOLVEDOR_URL'));
    }

    #[On('updatePrivacyPolicy')]
    public function updatePrivacyPolicy($value)
    {
        $this->configData['privacy_policy'] = $value;
    }

    public function getLogo()
    {
        if (empty($this->configData['logo']) || !Storage::disk('public')->exists($this->configData['logo'])) {
            return url(asset('theme/images/image.jpg'));
        }
        return Storage::url($this->configData['logo']);
    }     

    public function getLogoadmin()
    {
        if (empty($this->configData['logo_admin']) || !Storage::disk('public')->exists($this->configData['logo_admin'])) {
            return url(asset('theme/images/image.jpg'));
        }
        return Storage::url($this->configData['logo_admin']);
    }

    public function getLogofooter()
    {
        if (empty($this->configData['logo_footer']) || !Storage::disk('public')->exists($this->configData['logo_footer'])) {
            return url(asset('theme/images/image.jpg'));
        }
        return Storage::url($this->configData['logo_footer']);
    }

    public function getfaveicon()
    {
        if (empty($this->configData['favicon']) || !Storage::disk('public')->exists($this->configData['favicon'])) {
            return url(asset('theme/images/image.jpg'));
        }
        return Storage::url($this->configData['favicon']);
    }  

    public function getwatermark()
    {
        if (empty($this->configData['watermark']) || !Storage::disk('public')->exists($this->configData['watermark'])) {
            return url(asset('theme/images/image.jpg'));
        }
        return Storage::url($this->configData['watermark']);
    } 

    public function getmetaimg()
    {
        if (empty($this->configData['metaimg']) || !Storage::disk('public')->exists($this->configData['metaimg'])) {
            return url(asset('theme/images/image.jpg'));
        }
        return Storage::url($this->configData['metaimg']);
    }  

    public function getheadersite()
    {
        if (empty($this->configData['imgheader']) || !Storage::disk('public')->exists($this->configData['imgheader'])) {
            return url(asset('theme/images/image.jpg'));
        }
        return Storage::url($this->configData['imgheader']);
    }     
    
    protected function resetImages()
    {
        $this->reset('logo', 'logo_admin', 'logo_footer', 'favicon', 'watermark', 'metaimg', 'imgheader');
    }

    protected function handleImageUploads()
    {
        $images = [
            'logo' => $this->logo,
            'logo_admin' => $this->logo_admin,
            'logo_footer' => $this->logo_footer,
            'favicon' => $this->favicon,
            'watermark' => $this->watermark,
            'metaimg' => $this->metaimg,
            'imgheader' => $this->imgheader,
        ];

        foreach ($images as $key => $file) {
            if ($file instanceof TemporaryUploadedFile) {
                $currentPath = $this->configData[$key] ?? null;

                if (!empty($currentPath) && Storage::disk('public')->exists($currentPath)) {
                    Storage::disk('public')->delete($currentPath);
                }

                $path = $file->store('config', 'public');
                $this->configData[$key] = $path;
            }
        }
    }
    
}