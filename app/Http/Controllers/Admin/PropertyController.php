<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\PropertyGb;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(50);
        return view('admin.properties.index', [
            'properties' => $properties,
        ]);
    }

    public function create()
    {
        $users = User::orderBy('superadmin', 'DESC')
                ->orderBy('admin', 'DESC')
                ->orderBy('editor', 'DESC')
                ->orderBy('name', 'ASC')
                ->get();

        //$portais = Portal::orderBy('nome')->available()->get();

        return view('admin.properties.create', [
            'users' => $users,
            //'portais' => $portais
        ]);
    }

    public function store(PropertyRequest $request){

        $createProperty = Property::create($request->all());
        $createProperty->fill($request->all());

        $createProperty->setSlug();

        $validator = Validator::make($request->only('files'), [
            'files.*' => 'image'
        ]);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with([
                'color' => 'danger',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if($request->allFiles()){
            $files = count($request->allFiles());
            if($files > env('LIMITE_IMOVEIS')){
                return redirect()->back()->withInput()->with([
                    'color' => 'danger',
                    'message' => 'O sistema só permite o envio de ' . env('LIMITE_IMOVEIS') . ' fotos por Imóvel!!',
                ]);
            }else{
                foreach ($request->allFiles()['files'] as $image) {
                    $propertyGb = new PropertyGb();
                    $propertyGb->property = $createProperty->id;
                    $propertyGb->path = $image->storeAs(env('AWS_PASTA') . 'imoveis/'. $createProperty->id, Str::slug($request->title) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                    $propertyGb->save();
                    unset($propertyGb);
                }
            }
        }
        
        // $portaisRequest = $request->all();
        // $portais = null;
        // foreach($portaisRequest as $key => $value) {
        //     if(Str::is('portal_*', $key) == true){
        //         $f['portal'] = ltrim($key, 'portal_');
        //         $f['imovel'] = $createProperty->id;
        //         $createPimovel = PortalImoveis::create($f);
        //         $createPimovel->save();
        //     }
        // }

        return redirect()->route('imoveis.edit', [
            'imovel' => $createProperty->id
        ])->with(['color' => 'success', 'message' => 'Imóvel cadastrado com sucesso!']);
    }

    public function setStatus(Request $request)
    {        
        $property = Property::find($request->id);
        $property->status = $request->status;
        $property->save();
        return response()->json(['success' => true]);
    }
}
