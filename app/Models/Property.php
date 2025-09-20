<?php

namespace App\Models;

use App\Support\Cropper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $table = 'properties';

    protected $fillable = [
        'sale',
        'location',
        'category',
        'type',
        'expired_at',
        'display_values',
        'sale_value',
        'rental_value',
        'location_period',
        'iptu',
        'reference',
        'condominium',
        'description',
        'additional_notes',
        'dormitories',
        'suites',
        'bathrooms',
        'rooms',
        'garage',
        'covered_garage',
        'construction_year',
        'total_area',
        'useful_area',
        'measures',

        /** address */ 
        'latitude', 'longitude', 'display_address', 'zipcode', 'street',
        'number', 'complement', 'neighborhood', 'state', 'city',

        //accessories
        'ar_condicionado', 'areadelazer', 'aquecedor_solar', 'bar', 'banheirosocial', 'brinquedoteca',
        'biblioteca', 'balcaoamericano', 'churrasqueira', 'condominiofechado', 'estacionamento',
        'cozinha_americana', 'cozinha_planejada', 'dispensa', 'edicula', 'espaco_fitness',
        'escritorio', 'banheira', 'geradoreletrico', 'interfone', 'jardim', 'lareira', 'lavabo', 'lavanderia',
        'elevador', 'mobiliado', 'vista_para_mar', 'piscina', 'quadrapoliesportiva', 'sauna', 'salaodejogos',
        'salaodefestas', 'sistemadealarme', 'saladetv', 'ventilador_teto', 'armarionautico', 'fornodepizza',  
        'portaria24hs', 'permiteanimais', 'pertodeescolas', 'quintal', 'zeladoria', 'varandagourmet', 
        'internet', 'geladeira',

        //SEO
        'title', 'slug', 'url_booking', 'url_arbnb', 'status', 'views', 'metatags', 'headline',
        'display_marked_water', 'youtube_video', 'caption_img_cover', 'google_map',
        'experience', 'highlight', 'publication_type'
    ];

    /**
     * Scopes
    */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }    
    public function scopeSale($query)
    {
        return $query->where('sale', 1);
    }

    public function scopeLocation($query)
    {
        return $query->where('location', 1);
    }

    /**
     * Relationships
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'owner', 'id');
    }

    public function images()
    {
        return $this->hasMany(PropertyGb::class, 'property', 'id')->orderBy('cover', 'ASC');
    }

    public function imagesmarkedwater()
    {
        return $this->hasMany(PropertyGb::class, 'property', 'id')->whereNull('watermark')->count();
    }

    public function pimoveis()
    {
        return $this->hasMany(PortalImoveis::class, 'imovel', 'id');
    }

    /**
     * Accerssors and Mutators
    */    
    public function getContentWebAttribute()
    {
        return Str::words($this->description, '20', ' ...');
    }

    public function cover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }
        
        if(empty($cover['path']) || !Storage::disk()->exists($cover['path'])) {
            return url(asset('theme/images/image.jpg'));
        }
        
        return Storage::url(Cropper::thumb($cover['path'], 385, 180));        
    }

    public function nocover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }
        
        if(empty($cover['path']) || !Storage::disk()->exists($cover['path'])) {
            return url(asset('theme/images/image.jpg'));
        }
        
        return Storage::url($cover['path']);        
    }

    public function getLocationPeriod()
    {
        if (empty($this->location_period)) {
            return null;
        }

        $periodo = ($this->location_period == 1 ? 'Diária' : 
                   ($this->location_period == 2 ? 'Quinzenal' : 
                   ($this->location_period == 3 ? 'Mensal' : 
                   ($this->location_period == 4 ? 'Trimestral' : 
                   ($this->location_period == 5 ? 'Semestral' : 
                   ($this->location_period == 6 ? 'Anual' : 
                   ($this->location_period == 7 ? 'Bianual' : 'Diária')))))));

        return $periodo;
    }

    public function setDisplayAddressAttribute($value)
    {
        $this->attributes['display_address'] = ($value == true || $value == '1' ? 1 : 0);
    }

    public function setDisplayValuesAttribute($value)
    {
        $this->attributes['display_values'] = ($value == true || $value == '1' ? 1 : 0);
    }

    public function setDisplayMarkedWaterAttribute($value)
    {
        $this->attributes['display_marked_water'] = ($value == true || $value == '1' ? 1 : 0);
    }
    
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function getFormattedSaleValueAttribute(): ?string
    {
        return $this->sale_value !== null
            ? 'R$ ' . number_format($this->sale_value, 0, ',', '.')
            : null;
    }

    public function getFormattedRentalValueAttribute(): ?string
    {
        return $this->rental_value !== null
            ? 'R$ ' . number_format($this->rental_value, 0, ',', '.')
            : null;
    }

    // public function setSaleValueAttribute($value)
    // {
    //     $this->attributes['sale_value'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    // }

    // public function getSaleValueAttribute($value)
    // {
    //     if (empty($value)) {
    //         return null;
    //     }

    //     return number_format($value, 2, ',', '.');
    // }
    
    // public function setRentalValueAttribute($value)
    // {
    //     $this->attributes['rental_value'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    // }

    // public function getRentalValueAttribute($value)
    // {
    //     if (empty($value)) {
    //         return null;
    //     }

    //     return number_format($value, 2, ',', '.');
    // }
    
    // public function setIptuAttribute($value)
    // {
    //     $this->attributes['iptu'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    // }

    // public function getIptuAttribute($value)
    // {
    //     if (empty($value)) {
    //         return null;
    //     }

    //     return number_format($value, 2, ',', '.');
    // }
    
    // public function setCondominiumAttribute($value)
    // {
    //     $this->attributes['condominium'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    // }

    // public function getCondominiumAttribute($value)
    // {
    //     if (empty($value)) {
    //         return null;
    //     }

    //     return number_format($value, 2, ',', '.');
    // }
    
    // public function setZipcodeAttribute($value)
    // {
    //     $this->attributes['zipcode'] = (!empty($value) ? $this->clearField($value) : null);
    // }

    // public function getZipcodeAttribute($value)
    // {
    //     if (empty($value)) {
    //         return null;
    //     }

    //     return substr($value, 0, 5) . '-' . substr($value, 5, 3);
    // }

    public function setSlug()
    {
        if(!empty($this->title)){
            $property = Property::where('title', $this->title)->first(); 
            if(!empty($property) && $property->id != $this->id){
                $this->attributes['slug'] = Str::slug($this->title) . '-' . $this->id;
            }else{
                $this->attributes['slug'] = Str::slug($this->title);
            }            
            $this->save();
        }
    }    

    public function setExpiredAtAttribute($value)
    {
        $this->attributes['expired_at'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }
    
    public function getExpiredAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return date('d/m/Y', strtotime($value));
    }

    private function convertStringToDouble($param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(',', '.', str_replace('.', '', $param));
    }

    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }

    private function clearField(?string $param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
