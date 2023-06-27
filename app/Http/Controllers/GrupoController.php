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
        $this->validarFormulario($request);
        if ($this->validar_duplicidade($request)) {
            return redirect()
                ->action('App\Http\Controllers\GrupoController@index')
                ->with('warning', "Já existe um Perfil com este nome");
        }

        //  dd($request->all());

        $grupo = new Grupo();
        $grupo->nome = $request->nome;
        $grupo->descricao = $request->descricao;


        if ($request->modulo) {
            foreach ($request->modulo as  $value) {
                $grupo->modulos()->create([
                    'grupo_id' => $grupo->id,
                    'modulo_id' => $value,
                ]);
            }
        }



        $grupo->save();
        return redirect()
            ->action('App\Http\Controllers\GrupoController@index')
            ->with('status', "Registrado com sucesso!");
    }
    public function show($id)
    {
        $perfil = Grupo::findOrFail($id);
        return view('grupo.show', ['perfil' => $perfil]);
    }

    public function edit($id)
    {
        return view('grupo.edit');
    }

    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);
        $usuarios =  $grupo->users->count();
        if ($usuarios >= 1) {
            return redirect()
                ->action('App\Http\Controllers\GrupoController@index')
                ->with('warning', "Este Perfil tem usuario(s) associado(s), por tanto não pode ser excluida.");
        }

        $grupo->delete();
        return redirect()
            ->action('App\Http\Controllers\GrupoController@index')
            ->with('status', "Registro Excluido!");
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190|min:3',
            ],
            [
                'nome.nome' => 'Campo obrigatório.',
            ]
        );
    }

    private function validar_duplicidade(Request $request)
    {
        $duplicado = Grupo::where('nome', $request->nome)
            ->get()->count();
        return $duplicado;
    }
}
