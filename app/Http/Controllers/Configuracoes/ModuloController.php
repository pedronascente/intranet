<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Modulo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\FormatarDataController;
class ModuloController extends Controller
{
    /**
     * Instância da Modulo
     *
     * @var Modulo
     */
    private $modulo;

    public function __construct(Modulo $modulo)
    {
        $this->modulo = $modulo;
    }

    public function index()
    {
        return view('configuracoes.modulo.index', [
            'collection' => $this->modulo->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    public function create()
    {
        return view('configuracoes.modulo.create');
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

    public function edit($id)
    {
        return view('configuracoes.modulo.edit', [
            'modulo' => Modulo::findOrFail($id)
        ]);
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

    public function show($id)
    {
        return redirect()
            ->route('modulo.index');
    }
}
