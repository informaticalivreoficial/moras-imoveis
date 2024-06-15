<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyRequest;
use App\Models\Property;
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
        $users = User::orderBy('name')->get();

        //$portais = Portal::orderBy('nome')->available()->get();

        return view('admin.properties.create', [
            'users' => $users,
            //'portais' => $portais
        ]);
    }

    public function store(PropertyRequest $request){
        dd($request->all());
    }
}
