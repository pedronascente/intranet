<?php

namespace App\Http\Controllers\Colaborador;

use App\Models\Colaborador\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CargoController extends Controller
{
    /**
     * Instância de Cargo
     *
     * @var Cargo
     */
    private $cargo;
    protected $arrayListPermissoesDoModuloDaRota;//VALIDA AS PERMISSÕES DOS MODULOS

    public function __construct(Cargo $cargo)
    {
        $this->cargo = $cargo;
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
             return $next($request);
        });
    }

    public function index(Request $request )
    {

        $arrayListCargos = $this->cargo->getCargo($request->filtro);
        return view('cargo.index', [
            'titulo' => "Listar Cargos",
            'arrayListCargos' => $arrayListCargos,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function create()
    {
        if (in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Cadastrar Cargo";
            return view('cargo.create', ['titulo' => $titulo]);
        } else {
            return redirect()->route('cargo.index')->with('error', "Você não Tem Permissão de Cadastro.");
        }
    }

    public function store(Request $request)
    {
        $request->validate($this->cargo->rules('store'), $this->cargo->feedback());
        $cargo = $this->cargo;
        $cargo->nome = $request->nome;
        $cargo->save();

        return redirect()
            ->route('cargo.index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Editar Cargo";
            $cargo  = $this->cargo->findOrFail($id);
            return view('cargo.edit', [
                'titulo' => $titulo,
                'cargo' => $cargo,
            ]);
        } else {
            return redirect()->route('cargo.index')->with('error', "Você não Tem Permissão de Edição.");
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->cargo->rules('update'), $this->cargo->feedback());
        $cargo = $this->cargo->findOrFail($id);
        $cargo->nome = $request->nome;
        $cargo->update();
        return redirect()->route('cargo.index')->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        if (in_array('Excluir', $this->arrayListPermissoesDoModuloDaRota)) {
            $cargo = $this->cargo->with('colaboradores')->findOrFail($id);
            if ($cargo) {
                if ($cargo->colaboradores->count() >= 1) {
                    return redirect()->route('cargo.index')->with('warning', "Este cargo tem colaborador associado, por tanto não pode ser excluida.");
                }
                $cargo->delete();
                return redirect()->route('cargo.index')->with('status', "Registro Excluido!");
            } else {
                return redirect()->route('cargo.index')->with('warning', "Registro não encontrado.");
            }
        } else {
            return redirect()->route('cargo.index')->with('error', "Você não Tem Permissão de Excluir.");
        }
    }

    public function show($id)
    {
        return redirect()->route('cargo.index');
    }
}