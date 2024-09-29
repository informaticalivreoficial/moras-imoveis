<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Property;
use App\Support\Seo;
use Illuminate\Http\Request;

class Webcontroller extends Controller
{
    protected $seo, $config;

    public function __construct()
    {
        $this->seo = new Seo();
        $this->config = Config::where('id', 1)->first();
    }

    public function home()
    {
        $propertiesForSale = Property::orderBy('created_at', 'DESC')
                            ->sale()
                            ->available()
                            ->limit(18)
                            ->get();

        $propertiesForRent = Property::orderBy('created_at', 'DESC')
                            ->location()
                            ->available()
                            ->limit(18)
                            ->get(); 
                            
        // $slides = Slide::orderBy('created_at', 'DESC')
        //                     ->available()
        //                     ->where('tenant_id', $this->tenant->id)
        //                     ->where('expira', '>=', Carbon::now())
        //                     ->get();
        
        $destaque = Property::where('highlight', 1)->available()->first();

        // $artigos = Post::orderBy('created_at', 'DESC')
        //                     ->where('tipo', 'artigo')
        //                     ->where('tenant_id', $this->tenant->id)
        //                     ->postson()
        //                     ->limit(6)
        //                     ->get();

        $experienceCobertura = Property::where('experience', 'Cobertura')->inRandomOrder()->available()->get();
        $experienceCondominioFechado = Property::where('experience', 'Condomínio Fechado')->inRandomOrder()->available()->get();
        $experienceDeFrenteParaMar = Property::where('experience', 'De Frente para o Mar')->inRandomOrder()->available()->get();
        $experienceAltoPadrao = Property::where('experience', 'Alto Padrão')->inRandomOrder()->available()->get();
        $experienceLojasSalas = Property::where('experience', 'Lojas e Salas')->inRandomOrder()->available()->get();
        $experienceCompacto = Property::where('experience', 'Compacto')->inRandomOrder()->available()->get();
        
        $head = $this->seo->render($this->config->app_name ?? env('APP_NAME'),
            $this->config->information ?? env('APP_NAME'),
            route('web.home'),
            $this->config->getmetaimg() ?? 'https://informatica-livre.s3.us-east-2.amazonaws.com/infolivre/configuracoes/metaimg-informatica-livre.png'
        );

        return view('web.'.$this->config->template.'.home',[
            'propertiesForSale' => $propertiesForSale,
            'propertiesForRent' => $propertiesForRent,
            'destaque' => $destaque,
            //'artigos' => $artigos,
            'head' => $head,
            //'slides' => $slides,
            'experienceCobertura' => $experienceCobertura,
            'experienceCondominioFechado' => $experienceCondominioFechado,
            'experienceAltoPadrao' => $experienceAltoPadrao,
            'experienceLojasSalas' => $experienceLojasSalas,
            'experienceCompacto' => $experienceCompacto,
            'experienceDeFrenteParaMar' => $experienceDeFrenteParaMar,
        ]);
    }

    public function propertyList($type)
    {
        if($type == 'venda'){
            $properties = Property::orderBy('created_at', 'DESC')
                                ->available()
                                ->sale()
                                ->paginate(15);
        }else{
            $properties = Property::orderBy('created_at', 'DESC')
                                ->available()
                                ->location()
                                ->paginate(15);
        }        

        $head = $this->seo->render('Imóveis para ' . $type ?? env('APP_NAME'),
            'Confira os imóveis para '.$type.' temos ótimas oportunidades de negócio.',
            route('web.propertyList', $type),
            $this->config->getMetaImg() ?? 'https://informatica-livre.s3.us-east-2.amazonaws.com/infolivre/configuracoes/metaimg-informatica-livre.png'
        );

        return view('web.'.$this->config->template.'.properties.properties',[
            'head' => $head,
            'properties' => $properties,
            'type' => $type
        ]);
    }

    public function buyProperty($slug)
    {
        $property = Property::where('slug', $slug)
                            ->available()
                            ->sale()
                            ->first();
        $properties = Property::where('id', '!=', $property->id)
                            ->available()
                            ->location()
                            ->limit(4)
                            ->get();

        if(!empty($property)){
            $property->views = $property->views + 1;
            $property->save();

            $head = $this->seo->render($property->title ?? env('APP_NAME'),
                $property->headline ?? $property->title,
                route('web.buyProperty', ['slug' => $property->slug]),
                $property->cover() ?? $this->config->getMetaImg()
            );

            return view('web.'.$this->config->template.'.properties.property', [
                'head' => $head,
                'property' => $property,
                'properties' => $properties,
                'type' => 'venda',
            ]);
        }else{
            $head = $this->seo->render($this->config->app_name ?? env('APP_NAME'),
                'Imóvel não encontrado!',
                route('web.home') ?? 'https://superimoveis.info',
                $this->config->getMetaImg() ?? 'https://superimoveis.info/media/metaimg.jpg'
            );
            return view('web.'.$this->config->template.'.properties.property', [
                'head' => $head,
                'property' => false,
                'type' => 'venda',
            ]);
        }
        
    }
}
