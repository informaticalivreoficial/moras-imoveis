<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    use HasFactory;

    protected $table = 'properties';

    protected $fillable = [
        'sale',
        'location',
        'category',
        'owner',
        'display_values',
        'sale_value',
        'rental_value',
        'location_period',
        'iptu',
        'construction_year',
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
        'anodeconstrucao',
        'total_area',
        'useful_area',
        'measures',

        /** address */ 
        'latitude', 'longitude', 'display_address', 'zipcode', 'street',
        'number', 'complement', 'neighborhood', 'state', 'city',

        //accessories
        'ar_condicionado', 'aquecedor_solar', 'bar', 'biblioteca', 'churrasqueira', 'estacionamento',
        'cozinha_americana', 'cozinha_planejada', 'dispensa', 'edicula', 'espaco_fitness',
        'escritorio', 'fornodepizza', 'armarionautico', 'portaria24hs', 'quintal', 'zeladoria',
        'salaodejogos', 'saladetv', 'areadelazer', 'balcaoamericano', 'varandagourmet',
        'banheirosocial', 'brinquedoteca', 'pertodeescolas', 'condominiofechado',
        'interfone', 'sistemadealarme', 'jardim', 'salaodefestas', 'permiteanimais',
        'quadrapoliesportiva', 'geradoreletrico', 'banheira', 'lareira', 'lavabo', 'lavanderia',
        'elevador', 'mobiliado', 'vista_para_mar', 'piscina', 'sauna', 'ventilador_teto',
        'internet', 'geladeira',

        //SEO
        'title', 'slug', 'url_booking', 'url_arbnb', 'status', 'views', 'metatags', 'headline',
        'display_marked_water', 'youtube_video', 'caption_img_cover', 'google_map',
        'experience', 'highlight', 'publication_type'
    ];

    /**
     * Scopes
    */

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

    /**
     * Accerssors and Mutators
    */

    public function cover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if(empty($cover['path']) || !Storage::disk()->exists($cover['path'])) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url($cover['path']);
    }
}
