<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CatPost;
use App\Models\Config;
use App\Models\Post;
use App\Models\Property;
use App\Models\Slide;
use App\Support\Seo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $propertiesHighlights = Property::orderBy('created_at', 'DESC')
                                ->available()
                                ->where('highlight', 1)
                                ->limit(18)
                                ->get();                            
        $propertiesViews = Property::orderBy('created_at', 'DESC')
                                ->available()
                                ->limit(8)
                                ->get();                            
        $slides = Slide::orderBy('created_at', 'DESC')
                            ->available()
                            ->whereDate('expired_at', '>=', Carbon::today())
                            ->get(); 

        // Total de visualizações para cálculo de estrelas
        $totalViews = DB::table('properties')->where('status', 1)->sum('views');

        // Função auxiliar para calcular estrelas
        $calculateStars = function($imoveis) use ($totalViews) {
            foreach ($imoveis as $imovel) {
                if ($imovel->views > 0 && $totalViews > 0) {
                    $percent = ($imovel->views / $totalViews) * 100;
                    $imovel->stars = ceil($percent / 20); // 0 a 5 estrelas
                } else {
                    $imovel->stars = 0;
                }
            }
            return $imoveis;
        };
        
        $artigos = Post::orderBy('created_at', 'DESC')
                            ->where('type', 'artigo')
                            ->orWhere('type', 'noticia')
                            ->postson()
                            ->limit(3)
                            ->get();

        $experienceCobertura = Property::where('experience', 'Cobertura')->inRandomOrder()->available()->get();
        $experienceCondominioFechado = Property::where('experience', 'Condomínio Fechado')->inRandomOrder()->available()->get();
        $experienceDeFrenteParaMar = Property::where('experience', 'De Frente para o Mar')->inRandomOrder()->available()->get();
        $experienceAltoPadrao = Property::where('experience', 'Alto Padrão')->inRandomOrder()->available()->get();
        $experienceLojasSalas = Property::where('experience', 'Lojas e Salas')->inRandomOrder()->available()->get();
        $experienceCompacto = Property::where('experience', 'Compacto')->inRandomOrder()->available()->get();
        
        $head = $this->seo->render($this->config->app_name ?? env('APP_NAME'),
            $this->config->information ?? env('APP_NAME'),
            route('web.home'),
            $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );

        return view('web.'.$this->config->template.'.home',[
            'propertiesHighlights' => $propertiesHighlights,
            'propertiesViews' => $propertiesViews,
            'artigos' => $artigos,
            'head' => $head,
            'slides' => $slides,
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
            $this->config->getMetaImg() ?? url(asset('theme/images/image.jpg'))
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
                $this->config->getMetaImg() ?? url(asset('theme/images/image.jpg'))
            );
            return view('web.properties.property', [
                'head' => $head,
                'property' => false,
                'type' => 'venda',
            ]);
        }
        
    }

    public function property($slug)
    {
        $property = Property::where('slug', request()->slug)->available()->first();
        $propertiesrelated = Property::where('id', '!=', $property->id)
                            ->available()
                            ->limit(4)
                            ->get();

        if(!empty($property)){
            $property->views = $property->views + 1;
            $property->save();

            $head = $this->seo->render($property->title ?? env('APP_NAME'),
                $property->headline ?? $property->title,
                route('web.property', ['slug' => $property->slug]),
                $property->cover() ?? $this->config->getMetaImg()
            );

            return view('web.'.$this->config->template.'.properties.property', [
                'head' => $head,
                'property' => $property,
                'propertiesrelated' => $propertiesrelated,
            ]);
        }
    }

    public function pesquisaImoveis(Request $request)
    {
        // $properties = Property::orderBy('created_at', 'DESC')
        //                     ->available()
        //                     ->search($request->all())
        //                     ->paginate(15)
        //                     ->appends($request->except('page'));

        $head = $this->seo->render('Pesquisa de Imóveis - ' . $this->config->app_name ?? env('APP_NAME'),
            'Resultados da sua pesquisa de imóveis.',
            route('web.pesquisar-imoveis'),
            $this->config->getMetaImg() ?? url(asset('theme/images/image.jpg'))
        );

        return view('web.'.$this->config->template.'.properties.search-property',[
            'head' => $head,
            // 'properties' => $properties,
            // 'type' => 'pesquisa',
        ]);
    }

    public function blog()
    {
        $posts = Post::orderBy('created_at', 'DESC')
                            ->where('type', 'artigo')
                            ->orWhere('type', 'noticia')
                            ->postson()
                            ->paginate(3);

        $head = $this->seo->render('Blog - ' . $this->config->app_name ?? env('APP_NAME'),
            'Confira nossos artigos e notícias sobre o mercado imobiliário.',
            route('web.blog.index'),
            $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );

        return view("web.{$this->config->template}.blog.index",[
            'head' => $head,
            'posts' => $posts,
        ]);
    }

    public function artigo(Request $request)
    {
        $post = Post::where('slug', $request->slug)->postson()->first();

        $postsTags = Post::where('type', 'artigo')->postson()->limit(3)->get();
        $categorias = CatPost::orderBy('title', 'ASC')->where('type', 'artigo')->get();
        $postsMais = Post::orderBy('views', 'DESC')->where('type', 'artigo')->limit(3)->postson()->get();
        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render('Blog - ' . $post->title ?? env('APP_NAME'),
            $post->title,
            route('web.blog.artigo', ['slug' => $post->slug]),
            $post->cover() ?? $this->config->getmetaimg()
        );

        return view("web.{$this->config->template}.blog.article", [
            'head' => $head,
            'post' => $post,
            'postsMais' => $postsMais,
            'categorias' => $categorias,
            'postsTags' => $postsTags,
        ]);
    }

    public function noticia(Request $request)
    {
        $post = Post::where('slug', $request->slug)->postson()->first();

        $postsTags = Post::where('type', 'noticia')->postson()->limit(3)->get();
        $categorias = CatPost::orderBy('title', 'ASC')->where('type', 'noticia')->get();
        $postsMais = Post::orderBy('views', 'DESC')->where('type', 'noticia')->limit(3)->postson()->get();
        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render('Blog - ' . $post->title ?? env('APP_NAME'),
            $post->title,
            route('web.blog.noticia', ['slug' => $post->slug]),
            $post->cover() ?? $this->config->getmetaimg()
        );

        return view("web.{$this->config->template}.blog.article", [
            'head' => $head,
            'post' => $post,
            'postsMais' => $postsMais,
            'categorias' => $categorias,
            'postsTags' => $postsTags,
        ]);
    }

    public function politica()
    {
        $head = $this->seo->render('Política de Privacidade - ' . $this->config->app_name ?? env('APP_NAME'),
            'Leia nossa política de privacidade e saiba como protegemos seus dados.',
            route('web.politica'),
            $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );

        return view("web.{$this->config->template}.privacy",[
            'head' => $head,
        ]);
    }

    public function contact()
    {
        $head = $this->seo->render('Atendimento - ' . $this->config->app_name ?? env('APP_NAME'),
            'Entre em contato conosco, teremos prazer em atendê-lo!',
            route('web.contact'),
            $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );

        return view("web.{$this->config->template}.contact", [
            'head' => $head
        ]);
    }
}
