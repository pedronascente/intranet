<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Permissao;

class GrupoController extends Controller
{
    public function index()
    {
        return view('grupo.index');
    }

    public function create()
    {
        $modulos =  Modulo::all();
        $permissoes =  Permissao::all();
        return view('grupo.create', [
            'modulos' => $modulos,
            'permissoes' => $permissoes,
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit($id)
    {
        return view('grupo.edit');
    }

    public function desativar($id)
    {
        dd($id);
    }
}
