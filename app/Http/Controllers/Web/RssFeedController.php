<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Property;
use App\Models\Config;
use Illuminate\Support\Facades\Cache;

class RssFeedController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = Cache::remember('site_config', 3600, function () {
            return Config::find(1);
        });
    }

    public function feed()
    {
        $inicio = now()->startOfDay();
        $fim    = now()->endOfDay();

        $postsHoje = Post::whereBetween('created_at', [$inicio, $fim])
            ->whereIn('type', ['artigo', 'noticia'])
            ->postson()
            ->latest()
            ->limit(20)
            ->get();

        $paginas = Post::where('type', 'pagina')
            ->postson()
            ->latest()
            ->limit(10)
            ->get();

        $properties = Property::where('highlight', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->available()
            ->latest()
            ->limit(10)
            ->get();

        return response()
            ->view('web.' . $this->config->template . '.feed', [
                'artigos'  => $postsHoje->where('type', 'artigo'),
                'noticias' => $postsHoje->where('type', 'noticia'),
                'paginas'  => $paginas,
                'imoveis'  => $properties,
                'config'   => $this->config
            ])
            ->header('Content-Type', 'text/xml; charset=UTF-8');
    }
}