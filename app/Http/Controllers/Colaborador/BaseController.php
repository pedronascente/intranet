<?php

namespace App\Http\Controllers\Colaborador;

use App\Models\Colaborador\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Instância da Base
     *
     * @var Base
     */
    private $base;

    public function __construct(Base $base)
    {
        $this->base = $base;
        $this->base->setPaginacao(10);  
    }

    public function index()
    {
        return view('base.index', [
            "titulo" => "Listar Bases",
            "arrayListBase" => $this->base->getBaseOrderByIdDesc(),
        ]);
    }

    public function create()
    {
        if (!$this->validarpermissao('Criar')) {
            return redirect()->back();
        }
        return view('base.create', ['titulo' => "Cadastrar Base"]);
    }

    public function store(Request $request)
    {
        $request->validate($this->base->rules('store'), $this->base->feedback());
        $this->base->salvar($request->nome);
        return redirect()->route('base.index')->with('status', "Registrado com sucesso!");
    } 

    public function edit($id)
    {
        if (!$this->validarpermissao('Editar')) {
            return redirect()->back();
        }
        return view('base.edit', [
            'titulo' => "Editar Base",
            'base' => $this->base->findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->base->rules('update'), $this->base->feedback());
        $base = $this->base->findOrFail($id);
        $base->nome = $request->nome;
        $base->update();
        return redirect()->route('base.index')->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        if (!$this->validarpermissao('Excluir')) {
            return redirect()->back();
        }
        $base = $this->base->with('colaboradores')->findOrFail($id);
        if ($base) 
        {
            if ($base->colaboradores->count() >= 1) 
            {
                return redirect()->route('base.index')->with('warning', "Esta Base está sendo utilizada, por tanto não pode ser excluida.");
            }
            $base->delete();
            return redirect()->route('base.index')->with('status', "Registro Excluido!");
        } 
        else 
        {
            return redirect()->route('base.index')->with('warning', "Registro não encontrado.");
        }
    }

    public function show($id)
    {
        return redirect()->route('base.index');
    }
} 