<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;

class ModuloController extends Controller
{
    public function index()
    {
        $modulos = Modulo::orderBy('id', 'desc')->paginate(10);
        return view(
            'settings.modulo.index',
            [
                'collection' => $modulos,
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    public function create()
    {
        return view('settings.modulo.create');
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $modulo = new Modulo;
        $modulo->nome = $request->nome;
        $modulo->rota = $request->rota;
        $modulo->descricao = $request->descricao;
        $modulo->save();
        return redirect()
            ->action('App\Http\Controllers\ModuloController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        $modulo = Modulo::find($id);
        return view('settings.modulo.show', ['modulo' => $modulo]);
    }

    public function edit($id)
    {
        $modelo = Modulo::findOrFail($id);
        if ($modelo) {
            return view('settings.modulo.edit', ['modulo' => $modelo]);
        } else {
            return redirect()
                ->action('App\Http\Controllers\ModuloController@index')
                ->with('error', 'Registro não existe!');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $modulo = Modulo::findOrFail($id);
        $modulo->nome = $request->nome;
        $modulo->rota = $request->rota;
        $modulo->descricao = $request->descricao;
        $modulo->update();
        return redirect()
            ->action('App\Http\Controllers\ModuloController@index')
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $modulo = Modulo::with('perfis')->findOrFail($request->id);

        if ($modulo->perfis->count() >= 1) {
            return redirect()
                ->action('App\Http\Controllers\ModuloController@index')
                ->with('warning', "Este Módulo está relacionada a um perfil, Não pode ser excluida.");
        } else {
            $modulo->delete();
            return redirect()
                ->action('App\Http\Controllers\ModuloController@index')
                ->with('status', "Registro Excluido!");
        }
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190|min:2',
                'rota' => 'required|max:190|min:2',
                'descricao' => 'required|max:190|min:5',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'rota.required' => 'Campo obrigatório.',
                'descricao.required' => 'Campo obrigatório.',
            ]
        );
    }

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][4]) ? session()->get('perfil')['permissoes'][4]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }
}
