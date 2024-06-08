<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImovelController extends Controller
{
    public function index(): View
    {
        $imoveis = Imovel::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(50);
        return view('admin.imoveis.index', [
            'imoveis' => $imoveis,
        ]);
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        //$portais = Portal::orderBy('nome')->available()->get();

        return view('admin.imoveis.create', [
            'users' => $users,
            //'portais' => $portais
        ]);
    }
}
