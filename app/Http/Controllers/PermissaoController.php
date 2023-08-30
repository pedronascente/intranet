<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\permissao;

class PermissaoController extends Controller
{
    public function index()
    {
        return view(
            'settings.permissao.index',
            [
                'collection' => Permissao::orderBy('id', 'desc')->paginate(6),
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    public function create()
    {
        if ($this->verificarPermissao('Criar')) {
            return view('settings.permissao.create');
        } else {
            return redirect()
                ->action('App\Http\Controllers\PermissaoController@index');
        }
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
        if ($this->verificarPermissao('Editar')) {
            return view(
                'settings.permissao.edit',
                [
                    'permissao' => Permissao::findOrFail($id)
                ]
            );
        } else {
            return redirect()
                ->action('App\Http\Controllers\PermissaoController@index');
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

    public  function destroy(Request $request, $id)
    {
        $permissao = Permissao::with('perfis')->findOrFail($request->id);
        if ($permissao->perfis->count() >= 1) {
            return redirect()
                ->action('App\Http\Controllers\PermissaoController@index')
                ->with('warning', "Está permissão está relacionada a um perfil, Não pode ser excluida.");
        } else {
            $permissao->delete();
            return redirect()
                ->action('App\Http\Controllers\PermissaoController@index')
                ->with('status', "Registro Excluido!");
        }
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

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][5]) ? session()->get('perfil')['permissoes'][5]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }

    private function verificarPermissao($permissao)
    {
        $modulo = 5;
        $ArrayLystPermissoes = [];
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'] as $item) {
                foreach ($item as  $value) {
                    if ($value->modulo_id == $modulo) {
                        $ArrayLystPermissoes[] = $value->nome;
                    };
                }
            }
        }
        if (in_array($permissao, $ArrayLystPermissoes)) {
            return true;
        } else {
            return false;
        }
    }
}
