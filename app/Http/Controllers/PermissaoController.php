<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\permissao;

class PermissaoController extends Controller
{
    public function index()
    {
        $collection = Permissao::orderBy('id', 'desc')->paginate(6);
        return view('settings.permissao.index', ['collection' => $collection]);
    }

    public function create()
    {
        return view('settings.permissao.create');
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->validar_duplicidade($request)) {
            return redirect()
                ->action('App\Http\Controllers\PermissaoController@index')
                ->with('warning', "já existe permissão com este nome!");
        }
        $permissao = new Permissao();
        $permissao->nome = $request->nome;
        $permissao->save();

        return redirect()
            ->action('App\Http\Controllers\PermissaoController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $permissao = Permissao::findOrFail($id);
        if ($permissao) {
            return view('settings.permissao.edit', ['permissao' => $permissao]);
        } else {
            return redirect()
                ->action('App\Http\Controllers\PermissaoController@index')
                ->with('error', "RRegistro não existe!");
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $permissao = Permissao::findOrFail($id);
        $permissao->nome = $request->nome;
        $permissao->update();
        return redirect()
            ->action('App\Http\Controllers\PermissaoController@index')
            ->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        $empresa = Permissao::findOrFail($id);
        $empresa->delete();
        return redirect()
            ->action('App\Http\Controllers\PermissaoController@index')
            ->with('status', "Registro Excluido!");
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
            ]
        );
    }

    private function validar_duplicidade(Request $request)
    {
        $duplicado = Permissao::where('nome', $request->nome)
            ->get()->count();
        return $duplicado;
    }
}
