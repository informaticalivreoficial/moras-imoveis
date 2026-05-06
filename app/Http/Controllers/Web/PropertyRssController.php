<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Property;
use Illuminate\Support\Facades\Cache;

class PropertyRssController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = Cache::remember('site_config', 3600, function () {
            return Config::find(1);
        });
    }

    public function index()
    {
        $properties = Cache::remember('rss_properties_latest', 300, function () {
            return Property::select('id', 'title', 'slug', 'description', 'created_at')
                ->available()
                ->orderByDesc('created_at')
                ->limit(20)
                ->get();
        });

        if ($properties->isEmpty()) {
            logger()->warning('RSS: nenhum imóvel encontrado');
        }

        return response()
            ->view('web.' . $this->config->template . '.rss.properties', compact('properties'))
            ->header('Content-Type', 'text/xml; charset=UTF-8');
    }
}