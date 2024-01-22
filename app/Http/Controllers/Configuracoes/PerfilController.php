<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Modulo;

use App\Models\Perfil;
use App\Models\Permissao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerfilController extends Controller
{
    private $perfil;
    
    public function __construct(Perfil $perfil)
    {
        $this->perfil = $perfil;
    }

    public function index()
    {
        return view('configuracoes.perfil.index', [
            'collections' => $this->perfil->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    public function create()
    {
        return view('configuracoes.perfil.create', [
            'modulos'    => Modulo::all(), 
            'permissoes' => Permissao::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->perfil->rules(), $this->perfil->feedback());
        if ($this->perfil->validarDuplicidade($request->nome)) {
            return redirect()
                ->route('perfil.create')
                ->with('warning', "Já existe um Perfil com este nome");
        }

        if (!$request->modulos) {
            return redirect()
                ->route('perfil.create')
                ->with('error', "Selecione pelo menos um modulo, e uma permissão para continuar.");
        }

        $perfil            = $this->perfil;
        $perfil->nome      = $request->nome;
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
            ->route('perfil.index')
            ->with('success', "Registrado com sucesso.");
    }

    public function edit($id)
    {
        $listArrayModulos     = [];
        $modulos              =  Modulo::all();
        $permissoes           = Permissao::all();
        $perfil               = $this->perfil->with('modulos', 'permissoes')->findOrFail($id);
        $listArraypermissoes  = $this->perfil->getPermissoes($id)->toArray();
        foreach ($perfil->modulos as  $value) {
            $listArrayModulos[] = $value->id;
        }
        return view('configuracoes.perfil.edit', [
            'modulos'             => $modulos,
            'permissoes'          => $permissoes,
            'perfil'              => $perfil,
            'listArrayModulos'    => $listArrayModulos,
            'listArraypermissoes' =>  $listArraypermissoes,
        ]);
    }

    public function update(Request $request, $id)
    {
        $perfil            = $this->perfil->with('modulos', 'permissoes')->findOrFail($id);
        $perfil->nome      = $request->nome;
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
            ->route('perfil.edit', $id)
            ->with('status',"Registro Atualizado!");
    }

    public function destroy($id)
    {
        $perfil = $this->perfil->with('user')->findOrFail($id);
        if ($perfil->user) {
            return redirect()
                ->route('perfil.index')
                ->with('warning', "Este Perfil tem usuario(s) associado(s), por tanto não pode ser excluida.");
        } else {
            $perfil->delete();
            return redirect()
                ->route('perfil.index')
                ->with('status', "Registro Excluido!");
        }
    }

    public function show($id)
    {
        return redirect()
            ->route('perfil.index');
    }
}
