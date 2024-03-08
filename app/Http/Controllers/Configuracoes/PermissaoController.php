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
    private $arrayListPermissoesDoModuloDaRota;

    public function __construct(Permissao $permissao)
    {
      $this->permissao = $permissao;
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }

    public function index()
    {
        $titulo = "Listar Permissões";
        $arrayListPermissao = $this->permissao->orderBy('id', 'desc')->paginate(10);
        return view('permissao.index', [
            'titulo' => $titulo,
            'arrayListPermissao' => $arrayListPermissao,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function create()
    {
        if (in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Cadastrar Permissão";
            return view('permissao.create', ['titulo' => $titulo]);
        } else {
            return redirect()->route('permissao.index')->with('error', "Você não Tem Permissão de Cadastro.");
        } 
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
        if (in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Editar Permissão";
            $Permissao = $this->permissao->findOrFail($id);
            return view('permissao.edit', [
                'titulo' => $titulo,
                'permissao' => $Permissao
            ]);
        } else {
            return redirect()->route('permissao.index')->with('error', "Você não Tem Permissão de Edição.");
        }         
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
        if (in_array('Excluir', $this->arrayListPermissoesDoModuloDaRota)) {
            $permissao = $this->permissao->with('perfis')->findOrFail($id);
            if ($permissao->perfis->count() >= 1) {
                return redirect()->route('permissao.index')->with('warning', "Está permissão está relacionada a um perfil, Não pode ser excluida.");
            } else {
                $permissao->delete();
                return redirect()->route('permissao.index')->with('status', "Registro Excluido!");
            }
        } else {
            return redirect()->route('permissao.index')->with('error', "Você não Tem Permissão de Excluir.");
        }           
    }

    public function show($id)
    {
        return redirect()->route('permissao.index');
    }
}