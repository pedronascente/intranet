<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\permissao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class PermissaoController extends Controller
{
    private $modulo; //id do modulo
    private $paginate;
    private $actionIndex;

    public function __construct()
    {
        $this->modulo = 5; //id do modulo
        $this->paginate = 10;
        $this->actionIndex = 'App\Http\Controllers\Configuracoes\PermissaoController@index';
    }

    public function index()
    {
        return view('configuracoes.permissao.index', [
            'collection' => Permissao::orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo])) {
            return view('configuracoes.permissao.create');
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->validar_duplicidade($request)) {
            return redirect()
                ->action($this->actionIndex)
                ->with('warning', "já existe permissão com este nome!");
        }
        $permissao = new Permissao();
        $permissao->nome = $request->nome;
        $permissao->save();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo])) {
            return view('configuracoes.permissao.edit', ['permissao' => Permissao::findOrFail($id)]);
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $permissao = Permissao::findOrFail($id);
        $permissao->nome = $request->nome;
        $permissao->update();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Atualizado!");
    }

    public  function destroy(Request $request, $id)
    {
        $permissao = Permissao::with('perfis')->findOrFail($request->id);
        if ($permissao->perfis->count() >= 1) {
            return redirect()
                ->action($this->actionIndex)
                ->with('warning', "Está permissão está relacionada a um perfil, Não pode ser excluida.");
        } else {
            $permissao->delete();
            return redirect()
                ->action($this->actionIndex)
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
}
