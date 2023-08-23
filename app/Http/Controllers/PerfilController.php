<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Perfil;
use App\Models\Permissao;
use App\Models\ModuloPermissao;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        return view(
            'settings.perfil.index',
            [
                'collections' => Perfil::orderBy('id', 'desc')->paginate(6),
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    public function create()
    {
        return view(
            'settings.perfil.create',
            [
                'modulos' => Modulo::all(),
                'permissoes' => Permissao::all(),
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->verificarDuplicidadeDePerfil($request)) {
            return redirect()
                ->action('App\Http\Controllers\PerfilController@create')
                ->with('warning', "Já existe um Perfil com este nome");
        }

        if (!$request->modulos) {
            return redirect()
                ->action('App\Http\Controllers\PerfilController@create')
                ->with('error', "Selecione pelo menos um modulo, e uma permissão para continuar.");
        }

        $perfil = new Perfil();
        $perfil->nome = $request->nome;
        $perfil->descricao = $request->descricao;
        $perfil->save();

        if ($request->modulos) {
            foreach ($request->modulos as $m) {
                $perfil->modulos()->attach($m);
            }
        }

        if ($request->permissoes) {
            foreach ($request->permissoes as $modulo => $permissoes) {
                $perfil->permissoes()->attach($permissoes, ['modulo_id' => $modulo]);
            }
        }

        return redirect()
            ->action('App\Http\Controllers\PerfilController@index')
            ->with('success', "Registrado com sucesso.");
    }

    public function edit($id)
    {
        $listArrayModulos = [];
        $modulos = Modulo::all();
        $permissoes = Permissao::all();
        $perfil = Perfil::with('modulos', 'permissoes')->findOrFail($id);
        $listArraypermissoes  = Perfil::getPermissoes($id)->toArray();
        foreach ($perfil->modulos as  $value) {
            $listArrayModulos[] = $value->id;
        }
        return view('settings.perfil.edit', [
            'modulos' => $modulos,
            'permissoes' => $permissoes,
            'perfil' => $perfil,
            'listArrayModulos' => $listArrayModulos,
            'listArraypermissoes' =>  $listArraypermissoes,
        ]);
    }

    public function update(Request $request, $id)
    {
        $perfil = Perfil::with('modulos', 'permissoes')->findOrFail($id);
        $perfil->nome = $request->nome;
        $perfil->descricao = $request->descricao;
        $perfil->update();
        $perfil->modulos()->detach();
        $perfil->permissoes()->detach();
        if ($request->modulos) {
            foreach ($request->modulos as $m) {
                $perfil->modulos()->attach($m);
            }
        }

        if ($request->permissoes) {
            foreach ($request->permissoes as $modulo => $permissoes) {
                $perfil->permissoes()->attach($permissoes, ['modulo_id' => $modulo]);
            }
        }

        return redirect()
            ->action('App\Http\Controllers\PerfilController@edit', $id)
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $perfil = Perfil::with('user')->findOrFail($request->id);
        if ($perfil->user) {
            return redirect()
                ->action('App\Http\Controllers\PerfilController@index')
                ->with('warning', "Este Perfil tem usuario(s) associado(s), por tanto não pode ser excluida.");
        } else {
            $perfil->delete();
            return redirect()
                ->action('App\Http\Controllers\PerfilController@index')
                ->with('status', "Registro Excluido!");
        }
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190|unique:perfis,nome',
                'descricao' => 'required|max:190|min:3',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'nome.unique' => 'Este perfil já está sendo utilizado.',
                'descricao.required' => 'Campo obrigatório.',
            ],
        );
    }

    private function verificarDuplicidadeDePerfil(Request $request)
    {
        return Perfil::where('nome', $request->nome)
            ->get()->count();
    }

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][6]) ? session()->get('perfil')['permissoes'][6]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }
}
