<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConfigRequest;
use App\Models\Config;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function update(ConfigRequest $request, $id)
    {
        $config = Config::where('id', $id)->first(); 

        if(!empty($request->file('metaimg'))){
            Storage::delete($config->metaimg);
            $config->metaimg = null;
        }
        
        if(!empty($request->file('logo'))){
            Storage::delete($config->logo);
            $config->logo = null;
        }
        
        if(!empty($request->file('logo_admin'))){
            Storage::delete($config->logo_admin);
            $config->logo_admin = null;
        }
        
        if(!empty($request->file('favicon'))){
            Storage::delete($config->favicon);
            $config->favicon = null;
        }
        
        if(!empty($request->file('watermark'))){
            Storage::delete($config->watermark);
            $config->watermark = null;
        }
        
        if(!empty($request->file('imgheader'))){
            Storage::delete($config->imgheader);
            $config->imgheader = null;
        }
        
        $config->fill($request->all());
        
        if(!empty($request->file('metaimg'))){
            $config->metaimg = $request->file('metaimg')->storeAs(env('AWS_PASTA') . 'configuracoes', 'metaimg-'.Str::slug($request->nomedosite)  . '.' . $request->file('metaimg')->extension());
        }
        
        if(!empty($request->file('logo'))){
            $config->logo = $request->file('logo')->storeAs(env('AWS_PASTA') . 'configuracoes', 'logomarca-'.Str::slug($request->nomedosite)  . '.' . $request->file('logomarca')->extension());
        }
        
        if(!empty($request->file('logo_admin'))){
            $config->logo_admin = $request->file('logo_admin')->storeAs(env('AWS_PASTA') . 'configuracoes', 'logomarca-admin-'.Str::slug($request->nomedosite)  . '.' . $request->file('logomarca_admin')->extension());
        }
        
        if(!empty($request->file('favicon'))){
            $config->favicon = $request->file('favicon')->storeAs(env('AWS_PASTA') . 'configuracoes', 'favivon-'.Str::slug($request->nomedosite)  . '.' . $request->file('favicon')->extension());
        }
        
        if(!empty($request->file('watermark'))){
            $config->watermark = $request->file('watermark')->storeAs(env('AWS_PASTA') . 'configuracoes', 'marcadagua-'.Str::slug($request->nomedosite)  . '.' . $request->file('marcadagua')->extension());
        }
        
        if(!empty($request->file('imgheader'))){
            $config->imgheader = $request->file('imgheader')->storeAs(env('AWS_PASTA') . 'configuracoes', 'imgheader-'.Str::slug($request->nomedosite)  . '.' . $request->file('imgheader')->extension());
        }
        
        if(!$config->save()){
            return redirect()->back()->withInput()->withErrors('Erro');
        }

        return redirect()->route('configuracoes.editar', $config->id)->with([
            'color' => 'success', 
            'message' => 'Configurações atualizadas com sucesso!'
        ]);
    }
}
