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
        $collection = Perfil::orderBy('id', 'desc')->paginate(6);
        return view('settings.perfil.index', ['collections' => $collection]);
    }

    public function create()
    {
        $modulos =  Modulo::all();
        $permissoes =  Permissao::all();
        return view('settings.perfil.create', [
            'modulos' => $modulos,
            'permissoes' => $permissoes,
        ]);
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->verificarDuplicidadeDePerfil($request)) {
            return redirect()
                ->action('App\Http\Controllers\PerfilController@create')
                ->with('warning', "Já existe um Perfil com este nome");
        }
        if (!$request->modulos || !$request->permissoes) {
            return redirect()
                ->action('App\Http\Controllers\PerfilController@create')
                ->with('error', "Selecione pelo menos um modulo, e uma permissão para continuar.");
        }
        //Registrar Perfil.
        $perfil = new Perfil();
        $perfil->nome = $request->nome;
        $perfil->descricao = $request->descricao;
        $perfil->save();
        if ($perfil) {
            if ($request->modulos && $request->permissoes) {
                foreach ($request->modulos as $m) {
                    $perfil->modulos()->attach($m);
                }
                foreach ($request->modulos as $m) {
                    if (array_key_exists($m, $request->permissoes)) {
                        foreach ($request->permissoes as $keymodulo => $permissao) {
                            if ($keymodulo == $m) {
                                $objeModulo = Modulo::findOrFail($m);
                                $objeModulo->permissoes()->attach($permissao, ['perfil_id' => $perfil->id]);
                            }
                        }
                    }
                }
            } else {
                dd('Error: Modulo, ou permissão não foi selecionada!');
            }
        } else {
            dd('Error: Não foi possivel registrar perfil');
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
        $perfil = Perfil::with('modulos')->findOrFail($id);
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
        $perfil = Perfil::with('modulos')->findOrFail($id);
        $perfil->nome = $request->nome;
        $perfil->descricao = $request->descricao;
        $perfil->update();
        if ($request->modulos) {
            foreach ($perfil->modulos as $moduloRelacionado) {
                $perfil->modulos()->detach($moduloRelacionado);
            }
            foreach ($request->modulos as $m) {
                $perfil->modulos()->attach($m);
            }
        }
        if ($request->permissoes) {
            ModuloPermissao::deletePermissoes($id);
        }
        foreach ($request->modulos as $m) {
            if (array_key_exists($m, $request->permissoes)) {
                foreach ($request->permissoes as $keymodulo => $permissao) {
                    if ($keymodulo == $m) {
                        $objeModulo = Modulo::findOrFail($m);
                        $objeModulo->permissoes()->attach($permissao, ['perfil_id' => $perfil->id]);
                    }
                }
            }
        }
        return redirect()
            ->action('App\Http\Controllers\PerfilController@edit', $id)
            ->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        $perfil = Perfil::with('user')->findOrFail($id);
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
                'nome' => 'required|max:190|min:3',
                'descricao' => 'required|max:190|min:3',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'descricao.required' => 'Campo obrigatório.',
            ],
        );
    }

    private function verificarDuplicidadeDePerfil(Request $request)
    {
        return Perfil::where('nome', $request->nome)
            ->get()->count();
    }
}
