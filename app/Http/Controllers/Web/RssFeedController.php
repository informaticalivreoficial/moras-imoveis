<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{
    Post,
    Property,
    Config
};
use Carbon\Carbon;

class RssFeedController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = Config::where('id', 1)->first();
    }

    public function feed()
    {
        $postsHoje = Post::whereDate('created_at', Carbon::today())
            ->whereIn('type', ['artigo', 'noticia'])
            ->postson()
            ->limit(20)
            ->get();

        $paginas = Post::orderBy('created_at', 'DESC')
            ->where('type', 'pagina')
            ->postson()
            ->limit(10)
            ->get();

        $properties = Property::where('highlight', true)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->available()
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return response()->view('web.'.$this->config->template.'.feed', [
            'artigos'  => $postsHoje->where('type', 'artigo'),
            'noticias' => $postsHoje->where('type', 'noticia'),
            'paginas'  => $paginas,
            'imoveis'  => $properties,
            'config'   => $this->config
        ])->header('Content-Type', 'application/xml');
    }
}
