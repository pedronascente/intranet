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

    public function __construct(Cargo $cargo)
    {
        $this->cargo = $cargo;
        
    }

    public function index(Request $request )
    {   
        return view('cargo.index', [
            'titulo' => "Listar Cargos",
            'arrayListCargos' => $this->cargo->getCargo($request->filtro),
        ]);
    }

    public function create()
    {  
        if(!$this->validarpermissao('Criar')){
            return redirect()->back();
        }
        $titulo = "Cadastrar Cargo";
        return view('cargo.create', ['titulo' => $titulo]);  
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
        if (!$this->validarpermissao('Edit')) {
            return redirect()->back();
        }

        return view('cargo.edit', [
            'titulo' => "Editar Cargo",
            'cargo' => $this->cargo->findOrFail($id),
        ]);
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
        if (!$this->validarpermissao('Excluir')) {
            return redirect()->back();
        }
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
    }

    public function show($id)
    {
        return redirect()->route('cargo.index');
    }
    
}