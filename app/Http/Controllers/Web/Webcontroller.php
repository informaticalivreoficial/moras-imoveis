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
                            ->limit(24)
                            ->get();

        $propertiesForRent = Property::orderBy('created_at', 'DESC')
                            ->location()
                            ->available()
                            ->limit(24)
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
}
