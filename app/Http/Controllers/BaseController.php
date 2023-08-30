<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;

class BaseController extends Controller
{
    public function index()
    {
        return view(
            'settings.base.index',
            [
                'collection' => Base::orderBy('id', 'desc')->paginate(10),
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->verificarPermissao('Criar')) {
            return view('settings.base.create');
        } else {
            return redirect()
                ->action('App\Http\Controllers\BaseController@index');
        }
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $base = new Base();
        $base->nome = $request->nome;
        $base->save();
        return redirect()
            ->action('App\Http\Controllers\BaseController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if ($this->verificarPermissao('Editar')) {
            return view(
                'settings.base.edit',
                [
                    'base' => Base::findOrFail($id)
                ]
            );
        } else {
            return redirect()
                ->action('App\Http\Controllers\BaseController@index');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $base = Base::findOrFail($id);
        $base->nome = $request->nome;
        $base->update();
        return redirect()
            ->action('App\Http\Controllers\BaseController@index')
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $base = Base::with('colaboradores')->findOrFail($request->id);
        if ($base) {
            if ($base->colaboradores->count() >= 1) {
                return redirect()
                    ->action('App\Http\Controllers\BaseController@index')
                    ->with('warning', "Esta Base está sendo utilizada, por tanto não pode ser excluida.");
            }
            $base->delete();
            return redirect()
                ->action('App\Http\Controllers\BaseController@index')
                ->with('status', "Registro Excluido!");
        } else {
            return redirect()
                ->action('App\Http\Controllers\CargoController@index')
                ->with('warning', "Registro não encontrado.");
        }
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190|min:2|unique:bases,nome',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'nome.unique' => 'Este nome já está sendo utilizado.',
            ]
        );
    }

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][9]) ? session()->get('perfil')['permissoes'][1]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }

    private function verificarPermissao($permissao)
    {
        $modulo = 9;
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
