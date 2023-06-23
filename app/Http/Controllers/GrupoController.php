<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Grupo;
use App\Models\Permissao;

class GrupoController extends Controller
{
    public function index()
    {
        $collection = Grupo::orderBy('id', 'desc')->paginate(6);
        return view('grupo.index', ['collections' => $collection]);
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

        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {
            $grupo = new Grupo();
            $grupo->nome = $request->nome;
            $grupo->descricao = $request->descricao;
            $grupo->save();
            return redirect()
                ->action('App\Http\Controllers\GrupoController@index')
                ->with('status', "Registrado com sucesso!");
        }
    }

    public function edit($id)
    {
        return view('grupo.edit');
    }

    public function desativar($id)
    {
        dd($id);
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190|min:3',
                'descricao' => 'required',
            ],
            [
                'grupo.nome' => 'Campo obrigatório.',
                'grupo.descricao' => 'Campo obrigatório.',

            ]
        );
    }
}
