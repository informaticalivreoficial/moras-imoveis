<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function editar()
    {
        $config = Config::where('id', '1')->first();
        $templates = Template::orderBy('created_at', 'DESC')
                ->available()
                ->get();
         
        $datahoje = Carbon::now();

        if($config != null) {
            $sitemap = Carbon::createFromFormat('Y-m-d', $config->sitemap_data);
            $diferenca = $datahoje->diffInDays($sitemap); // saída: X dias
            $feeddata = Carbon::createFromFormat('Y-m-d', $config->rss_data);
            $feeddatadiferenca = $datahoje->diffInDays($feeddata); // saída: X dias
        }

        return view('admin.configuracoes',[
            'config' => $config,
            'diferenca' => $diferenca ?? 0,
            'templates' => $templates,
            'feeddatadiferenca' => $feeddatadiferenca ?? 0
        ]);
    }
}
