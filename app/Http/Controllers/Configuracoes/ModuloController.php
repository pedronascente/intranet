<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Modulo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;
use App\Http\Controllers\Help\FormatarDataController;
class ModuloController extends Controller
{
    private $modulo_id; //id do modulo
    private $paginate;
    private $modulo;

    public function __construct(Modulo $modulo)
    {
        $this->modulo_id = 4;
        $this->paginate  = 10;
        $this->modulo    = $modulo;
    }

    public function index()
    {
        return view('configuracoes.modulo.index', [
            'collection' => $this->modulo->orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo_id),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo_id])) {
            return view('configuracoes.modulo.create');
        } else {
            return redirect()
                ->route('modulo.index');
        }
    }

    public function store(Request $request)
    {
        $request->validate($this->modulo->rules(), $this->modulo->feedback());
        $modulo            = $this->modulo;
        $modulo->nome      = $request->nome;
        $modulo->tipo_menu = $request->tipo_menu;
        $modulo->rota      = $request->rota;
        $modulo->slug      = FormatarDataController::generateSlug($request->nome);
        $modulo->descricao = $request->descricao;
        $modulo->save();
        return redirect()
            ->route('modulo.index')
            ->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        return view('configuracoes.modulo.show', ['modulo' => Modulo::find($id)]);
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo_id])) {
            return view('configuracoes.modulo.edit', ['modulo' => Modulo::findOrFail($id)]);
        } else {
            return redirect()
                ->route('modulo.index');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->modulo->rules(), $this->modulo->feedback());
        $modulo            = $this->modulo->findOrFail($id);
        $modulo->nome      = $request->nome;
        $modulo->tipo_menu = $request->tipo_menu;
        $modulo->rota      = $request->rota;
        $modulo->slug      = FormatarDataController::generateSlug($request->nome);
        $modulo->descricao = $request->descricao;
        $modulo->update();
        return redirect()
            ->route('modulo.index')
            ->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        $modulo = $this->modulo->with('perfis')->findOrFail($id);
       
        if ($modulo->perfis->count() >= 1) {
            return redirect()
                ->route('modulo.index')
                ->with('warning', "Este Módulo está relacionada a um perfil, Não pode ser excluida.");
        } else {
            $modulo->delete();
            return redirect()
                ->route('modulo.index')
                ->with('status', "Registro Excluido!");
        }
    }
}
