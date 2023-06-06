<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\permissao;

class PermissaoController extends Controller
{
    public function index()
    {
        $collection = Permissao::orderBy('id', 'desc')->paginate(6);
        return view('permissao.index', ['collection' => $collection]);
    }

    public function create()
    {
        return view('permissao.create');
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request); //Válidar Formulário.
        $permissao = new Permissao(); //Instânciar objeto.
        $permissao->nome = $request->nome;
        $permissao->save(); //persistir dados.

        return redirect()
            ->action('App\Http\Controllers\PermissaoController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $permissao = Permissao::findOrFail($id);
        if ($permissao) {
            return view('permissao.edit', ['permissao' => $permissao]);
        } else {
            return redirect('permissao/')->with('error', 'Registro não existe!'); //retorna resultado.
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request); //Válidar Formulário.
        $permissao = Permissao::findOrFail($id);
        $permissao->nome = $request->nome;
        $permissao->update();
        return redirect('permissao')->with('status', 'Registro Atualizado!'); //retorna resultado.
    }

    public function destroy($id)
    {
        $empresa = Permissao::findOrFail($id);
        $empresa->delete();
        return redirect('permissao')->with('status', 'Registro Excluido!'); //retorna resultado.
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190|min:2',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
            ]
        );
    }
}
