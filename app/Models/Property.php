<?php

namespace App\Models;

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
        'construction_year',
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
            return url(asset('backend/assets/images/image.jpg'));
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
    
    public function setSaleAttribute($value)
    {
        $this->attributes['sale'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function setSaleValueAttribute($value)
    {
        $this->attributes['sale_value'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getSaleValueAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }
    
    public function setRentalValueAttribute($value)
    {
        $this->attributes['rental_value'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getRentalValueAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }
    
    public function setIptuAttribute($value)
    {
        $this->attributes['iptu'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getIptuAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }
    
    public function setCondominiumAttribute($value)
    {
        $this->attributes['condominium'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getCondominiumAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }
    
    public function setZipcodeAttribute($value)
    {
        $this->attributes['zipcode'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getZipcodeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return substr($value, 0, 5) . '-' . substr($value, 5, 3);
    }

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

    /**
     * Mutator Air Conditioning
     *
     * @param $value
     */
    public function setArCondicionadoAttribute($value)
    {
        $this->attributes['ar_condicionado'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Air Conditioning
     *
     * @param $value
     */
    public function setAquecedorsolarAttribute($value)
    {
        $this->attributes['aquecedor_solar'] = (($value === true || $value === 'on') ? 1 : 0);
    }
    
    /**
     * Mutator Air Conditioning
     *
     * @param $value
     */
    public function setBarAttribute($value)
    {
        $this->attributes['bar'] = (($value === true || $value === 'on') ? 1 : 0);
    }
    
    /**
     * Mutator Air Conditioning
     *
     * @param $value
     */
    public function setBibliotecaAttribute($value)
    {
        $this->attributes['biblioteca'] = (($value === true || $value === 'on') ? 1 : 0);
    }
    
    /**
     * Mutator Air Conditioning
     *
     * @param $value
     */
    public function setChurrasqueiraAttribute($value)
    {
        $this->attributes['churrasqueira'] = (($value === true || $value === 'on') ? 1 : 0);
    }
    
    /**
     * Mutator Estacionamento
     *
     * @param $value
     */
    public function setEstacionamentoAttribute($value)
    {
        $this->attributes['estacionamento'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Espaço Fitness
     *
     * @param $value
     */
    public function setEspacofitnessAttribute($value)
    {
        $this->attributes['espaco_fitness'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Forno de Pizza
     *
     * @param $value
     */
    public function setFornodepizzaAttribute($value)
    {
        $this->attributes['fornodepizza'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Portaria 24hs
     *
     * @param $value
     */
    public function setPortaria24hsAttribute($value)
    {
        $this->attributes['portaria24hs'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Armário Náutico
     *
     * @param $value
     */
    public function setArmarionauticoAttribute($value)
    {
        $this->attributes['armarionautico'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Quintal
     *
     * @param $value
     */
    public function setQuintalAttribute($value)
    {
        $this->attributes['quintal'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Zeladoria
     *
     * @param $value
     */
    public function setZeladoriaAttribute($value)
    {
        $this->attributes['zeladoria'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Salão de Jogos
     *
     * @param $value
     */
    public function setSalaodejogosAttribute($value)
    {
        $this->attributes['salaodejogos'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Sala de TV
     *
     * @param $value
     */
    public function setSaladetvAttribute($value)
    {
        $this->attributes['saladetv'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Área de Lazer
     *
     * @param $value
     */
    public function setAreadelazerAttribute($value)
    {
        $this->attributes['areadelazer'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Balcão Americano
     *
     * @param $value
     */
    public function setBalcaoamericanoAttribute($value)
    {
        $this->attributes['balcaoamericano'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Varanda Gourmet
     *
     * @param $value
     */
    public function setVarandagourmetAttribute($value)
    {
        $this->attributes['varandagourmet'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Banheiro Social
     *
     * @param $value
     */
    public function setBanheirosocialAttribute($value)
    {
        $this->attributes['banheirosocial'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Brinquedoteca
     *
     * @param $value
     */
    public function setBrinquedotecaAttribute($value)
    {
        $this->attributes['brinquedoteca'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Perto de Escolas
     *
     * @param $value
     */
    public function setPertodeescolasAttribute($value)
    {
        $this->attributes['pertodeescolas'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Condomínio fechado
     *
     * @param $value
     */
    public function setCondominiofechadoAttribute($value)
    {
        $this->attributes['condominiofechado'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Interfone
     *
     * @param $value
     */
    public function setInterfoneAttribute($value)
    {
        $this->attributes['interfone'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Sistema de alarme
     *
     * @param $value
     */
    public function setSistemadealarmeAttribute($value)
    {
        $this->attributes['sistemadealarme'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Jardim
     *
     * @param $value
     */
    public function setJardimAttribute($value)
    {
        $this->attributes['jardim'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Salão de Festas
     *
     * @param $value
     */
    public function setSalaodefestasAttribute($value)
    {
        $this->attributes['salaodefestas'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Permite animais
     *
     * @param $value
     */
    public function setPermiteanimaisAttribute($value)
    {
        $this->attributes['permiteanimais'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Quadra poliesportiva
     *
     * @param $value
     */
    public function setQuadrapoliesportivaAttribute($value)
    {
        $this->attributes['quadrapoliesportiva'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Gerador elétrico
     *
     * @param $value
     */
    public function setGeradoreletricoAttribute($value)
    {
        $this->attributes['geradoreletrico'] = (($value === true || $value === 'on') ? 1 : 0);
    }
    
    /**
     * Mutator Cozinha Americana
     *
     * @param $value
     */
    public function setCozinhaAmericanaAttribute($value)
    {
        $this->attributes['cozinha_americana'] = (($value === true || $value === 'on') ? 1 : 0);
    }
    
    /**
     * Mutator Cozinha Planejada
     *
     * @param $value
     */
    public function setCozinhaPlanejadaAttribute($value)
    {
        $this->attributes['cozinha_planejada'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Bar Social
     *
     * @param $value
     */
    public function setDispensaAttribute($value)
    {
        $this->attributes['dispensa'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Edícula
     *
     * @param $value
     */
    public function setEdiculaAttribute($value)
    {
        $this->attributes['edicula'] = (($value === true || $value === 'on') ? 1 : 0);
    }    

    /**
     * Mutator Escritório
     *
     * @param $value
     */
    public function setEscritorioAttribute($value)
    {
        $this->attributes['escritorio'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Banheira
     *
     * @param $value
     */
    public function setBanheiraAttribute($value)
    {
        $this->attributes['banheira'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Lareira
     *
     * @param $value
     */
    public function setLareiraAttribute($value)
    {
        $this->attributes['lareira'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Lavabo
     *
     * @param $value
     */
    public function setLavaboAttribute($value)
    {
        $this->attributes['lavabo'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Lavanderia
     *
     * @param $value
     */
    public function setLavanderiaAttribute($value)
    {
        $this->attributes['lavanderia'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Elevador
     *
     * @param $value
     */
    public function setElevadorAttribute($value)
    {
        $this->attributes['elevador'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Mobiliado
     *
     * @param $value
     */
    public function setMobiliadoAttribute($value)
    {
        $this->attributes['mobiliado'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Vista para o Mar
     *
     * @param $value
     */
    public function setVistaParaMarAttribute($value)
    {
        $this->attributes['vista_para_mar'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Piscina
     *
     * @param $value
     */
    public function setPiscinaAttribute($value)
    {
        $this->attributes['piscina'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Sauna
     *
     * @param $value
     */
    public function setSaunaAttribute($value)
    {
        $this->attributes['sauna'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Ventilador de Teto
     *
     * @param $value
     */
    public function setVentiladorTetoAttribute($value)
    {
        $this->attributes['ventilador_teto'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Internet
     *
     * @param $value
     */
    public function setInternetAttribute($value)
    {
        $this->attributes['internet'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    /**
     * Mutator Geladeira
     *
     * @param $value
     */
    public function setGeladeiraAttribute($value)
    {
        $this->attributes['geladeira'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    private function convertStringToDouble($param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(',', '.', str_replace('.', '', $param));
    }

    private function clearField(?string $param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
