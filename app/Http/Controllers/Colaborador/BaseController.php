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

    private $arrayListPermissoesDoModuloDaRota;
   
    public function __construct(Base $base)
    {
        $this->base = $base;
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }

    public function index()
    {
        $titulo = "Listar Bases";
        $arrayListBase = $this->base->orderBy('id', 'desc')->paginate(10);
        return view('base.index', [
            'titulo' => $titulo,
            'arrayListBase' => $arrayListBase,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function create()
    {
        if (!in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            return redirect()->route('base.index')->with('error', "Você não tem permissão de cadastro.");
        }
        $titulo = "Cadastrar Base";
        return view('base.create', ['titulo' => $titulo]);
    }

    public function store(Request $request)
    {
        $request->validate($this->base->rules('store'), $this->base->feedback());
        $base = $this->base;
        $base->nome = $request->nome;
        $base->save();
        return redirect()->route('base.index')->with('status', "Registrado com sucesso!");
    } 

    public function edit($id)
    {
        if (!in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)) {
            return redirect()->route('base.index')->with('error', "Você não tem permissão de edição.");
        }
        $Base = $this->base->findOrFail($id);
        $titulo = 'Editar Base';
        return view('base.edit', [
            'titulo' => $titulo,
            'base' => $Base
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
        if (!in_array('Excluir', $this->arrayListPermissoesDoModuloDaRota)) {
           return redirect()->route('base.index')->with('error', "Você não tem permissão de excluir.");
        }
        $base = $this->base->with('colaboradores')->findOrFail($id);
        if ($base) {
            if ($base->colaboradores->count() >= 1) {
                return redirect()->route('base.index')->with('warning', "Esta Base está sendo utilizada, por tanto não pode ser excluida.");
            }
            $base->delete();
            return redirect()->route('base.index')->with('status', "Registro Excluido!");
        } else {
            return redirect()->route('base.index')->with('warning', "Registro não encontrado.");
        }
    }

    public function show($id)
    {
        return redirect()->route('base.index');
    }
} 