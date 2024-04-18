<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\permissao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissaoController extends Controller
{
    /**
     * Instância de Permissao
     *
     * @var Permissao
     */
    private $permissao;

    public function __construct(Permissao $permissao)
    {
      $this->permissao = $permissao;
        
    }

    public function index()
    {
        return view('permissao.index', [
            "titulo" => "Listar Permissões",
            "arrayListPermissao" => $this->permissao->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    public function create()
    {
        if (!$this->validarpermissao('Criar')) {
            return redirect()->back();
        }
        return view('permissao.create', ['titulo' => "Cadastrar Permissão"]);
    }

    public function store(Request $request)
    {
        $request->validate($this->permissao->rules(), $this->permissao->feedback());
        if ($this->permissao->validarDuplicidade($request->nome)) {
            return redirect()->route('permissao.index')->with('warning', "já existe permissão com este nome!");
        }
        $permissao = $this->permissao;
        $permissao->nome = $request->nome;
        $permissao->save();
        return redirect()->route('permissao.index')->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (!$this->validarpermissao('Editar')) {
            return redirect()->back();
        }
        return view('permissao.edit', [
            'titulo' => "Editar Permissão",
            'permissao' => $this->permissao->findOrFail($id)
        ]);         
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->permissao->rules(), $this->permissao->feedback());
        $permissao = $this->permissao->findOrFail($id);
        $permissao->nome = $request->nome;
        $permissao->update();
        return redirect()->route('permissao.index')->with('status', "Registro Atualizado!");
    }

    public  function destroy($id)
    {
        if (!$this->validarpermissao('Excluir')) {
            return redirect()->back();
        }
        $permissao = $this->permissao->with('perfis')->findOrFail($id);
        if ($permissao->perfis->count() >= 1) {
            return redirect()->route('permissao.index')->with('warning', "Está permissão está relacionada a um perfil, Não pode ser excluida.");
        } else {
            $permissao->delete();
            return redirect()->route('permissao.index')->with('status', "Registro Excluido!");
        }       
    }

    public function show($id)
    {
        return redirect()->route('permissao.index');
    }
}