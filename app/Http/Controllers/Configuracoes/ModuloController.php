<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Modulo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class ModuloController extends Controller
{
    private $modulo; //id do modulo
    private $paginate;
    private $actionIndex;

    public function __construct()
    {
        $this->modulo = 4;
        $this->paginate = 10;
        $this->actionIndex = 'App\Http\Controllers\Configuracoes\ModuloController@index';
    }

    public function index()
    {
        return view('configuracoes.modulo.index', [
            'collection' => Modulo::orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo])) {
            return view('configuracoes.modulo.create');
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $modulo = new Modulo;
        $modulo->nome = $request->nome;
        $modulo->rota = $request->rota;
        $modulo->slug = $this->getSlug($request->rota);
        $modulo->descricao = $request->descricao;
        $modulo->save();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        return view('configuracoes.modulo.show', ['modulo' => Modulo::find($id)]);
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo])) {
            return view('configuracoes.modulo.edit', ['modulo' => Modulo::findOrFail($id)]);
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $modulo = Modulo::findOrFail($id);
        $modulo->nome = $request->nome;
        $modulo->rota = $request->rota;
        $modulo->slug = $this->getSlug($request->rota);
        $modulo->descricao = $request->descricao;
        $modulo->update();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $modulo = Modulo::with('perfis')->findOrFail($request->id);

        if ($modulo->perfis->count() >= 1) {
            return redirect()
                ->action($this->actionIndex)
                ->with('warning', "Este Módulo está relacionada a um perfil, Não pode ser excluida.");
        } else {
            $modulo->delete();
            return redirect()
                ->action($this->actionIndex)
                ->with('status', "Registro Excluido!");
        }
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190|min:2',
                'rota' => 'required|max:190|min:2',
                'descricao' => 'required|max:190|min:5',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'rota.required' => 'Campo obrigatório.',
                'descricao.required' => 'Campo obrigatório.',
            ]
        );
    }

    private function getSlug($rota)
    {
        $slog = explode('/', $rota);
        return $slog[2];
    }
}
