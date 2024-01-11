<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class CargoController extends Controller
{
    private $modulo; //id do modulo
    private $cargo; 
    
    public function __construct(Cargo $cargo )
    {
        $this->modulo = 1; //id do modulo
        $this->cargo  = $cargo; 
    }

    public function index()
    {
        return view('configuracoes.cargo.index', [
            'collection' => $this->cargo->orderBy('id', 'desc')->paginate(10),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao([
            'permissao' => 'Criar', 
            'modulo'    => $this->modulo
        ])){
            return view('configuracoes.cargo.create');
        } else {
            return redirect()
                ->route('cargo.index');
        }
    }

    public function store(Request $request)
    {
        $request->validate($this->cargo->rules('store'), $this->cargo->feedback());
        $cargo       = $this->cargo;
        $cargo->nome = $request->nome;
        $cargo->save();
        
        return redirect()
            ->route('cargo.index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao([
            'permissao' => 'Editar', 
            'modulo'    => $this->modulo
        ])) {
            return view('configuracoes.cargo.edit', [
                    'cargo' => $this->cargo->findOrFail($id)
            ]);
        } else {
            return redirect()
                ->route('cargo.index');;
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->cargo->rules('update'), $this->cargo->feedback());
        $cargo       = $this->cargo->findOrFail($id);
        $cargo->nome = $request->nome;
        $cargo->update();
        
        return redirect()
            ->route('cargo.index')
            ->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        $cargo = $this->cargo->with('colaboradores')->findOrFail($id);
        if ($cargo) {
            if ($cargo->colaboradores->count() >= 1) {
                return redirect()
                    ->route('cargo.index')
                    ->with('warning', "Este cargo tem colaborador associado, por tanto não pode ser excluida.");
            }
            $cargo->delete();

            return redirect()
                ->route('cargo.index')
                ->with('status', "Registro Excluido!");
        } else {
            return redirect()
                ->route('cargo.index')
                ->with('warning', "Registro não encontrado.");
        }
    }

}
