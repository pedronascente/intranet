<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\ModuloPerfil;
use App\Models\Perfil;
use App\Models\Permissao;


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
        if ($this->validar_duplicidade($request)) {
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
        $modulos =  Modulo::all();
        $permissoes =  Permissao::all();
        $perfil = Perfil::with('modulos')->findOrFail($id);
        $listArraypermissoes  = Perfil::getPermissoes($id)->toArray();
        foreach ($perfil->modulos as  $value) {
            $listModulos[] = $value->id;
        }
        return view('settings.perfil.edit', [
            'modulos' => $modulos,
            'permissoes' => $permissoes,
            'perfil' => $perfil,
            'listModulos' =>  $listModulos,
            'listArraypermissoes' =>  $listArraypermissoes,
        ]);
    }

    public function update()
    {
    }

    public function destroy($id)
    {
        $perfil = Perfil::findOrFail($id);
        $usuarios =  $perfil->users->count();
        if ($usuarios >= 1) {
            return redirect()
                ->action('App\Http\Controllers\PerfilController@index')
                ->with('warning', "Este Perfil tem usuario(s) associado(s), por tanto não pode ser excluida.");
        }

        $perfil->delete();
        return redirect()
            ->action('App\Http\Controllers\PerfilController@index')
            ->with('status', "Registro Excluido!");
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

    private function validar_duplicidade(Request $request)
    {
        $duplicado = Perfil::where('nome', $request->nome)
            ->get()->count();
        return $duplicado;
    }
}
