<?php

namespace App\Http\Controllers\Settings;

use App\Models\Modulo;

use App\Models\Perfil;
use App\Models\Permissao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class PerfilController extends Controller
{
    private $modulo; //id do modulo
    private $paginate;
    private $actionIndex;
    private $actionEdit;
    private $actionCreate;

    public function __construct()
    {
        $this->modulo = 6;
        $this->paginate = 10;
        $this->actionIndex = 'App\Http\Controllers\Settings\PerfilController@index';
        $this->actionEdit = 'App\Http\Controllers\Settings\PerfilController@edit';
        $this->actionCreate = 'App\Http\Controllers\Settings\PerfilController@create';
    }

    public function index()
    {
        return view('settings.perfil.index', [
            'collections' => Perfil::orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo])) {
            return view('settings.perfil.create', ['modulos' => Modulo::all(), 'permissoes' => Permissao::all()]);
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->verificarDuplicidadeDePerfil($request)) {
            return redirect()
                ->action($this->actionCreate)
                ->with('warning', "Já existe um Perfil com este nome");
        }

        if (!$request->modulos) {
            return redirect()
                ->action($this->actionCreate)
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
            ->action($this->actionIndex)
            ->with('success', "Registrado com sucesso.");
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo])) {
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
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
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
            ->action($this->actionEdit, $id)
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $perfil = Perfil::with('user')->findOrFail($request->id);
        if ($perfil->user) {
            return redirect()
                ->action($this->actionIndex)
                ->with('warning', "Este Perfil tem usuario(s) associado(s), por tanto não pode ser excluida.");
        } else {
            $perfil->delete();
            return redirect()
                ->action($this->actionIndex)
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
}
