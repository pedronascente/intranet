<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class CargoController extends Controller
{
    private $modulo; //id do modulo
    private $paginate;
    private $actionIndex;

    public function __construct()
    {
        $this->modulo = 1; //id do modulo
        $this->paginate = 10;
        $this->actionIndex = 'App\Http\Controllers\Configuracoes\CargoController@index';
    }

    public function index()
    {
        return view('configuracoes.cargo.index', [
            'collection' => Cargo::orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo])) {
            return view('configuracoes.cargo.create');
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request, 'store');
        $cargo = new Cargo();
        $cargo->nome = $request->nome;
        $cargo->save();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo])) {
            return view('configuracoes.cargo.edit', ['cargo' => Cargo::findOrFail($id)]);
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request, 'update');
        $cargo = Cargo::findOrFail($id);
        $cargo->nome = $request->nome;
        $cargo->update();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $cargo = Cargo::with('colaboradores')->findOrFail($request->id);
        if ($cargo) {
            if ($cargo->colaboradores->count() >= 1) {
                return redirect()
                    ->action($this->actionIndex)
                    ->with('warning', "Este cargo tem colaborador associado, por tanto não pode ser excluida.");
            }
            $cargo->delete();
            return redirect()
                ->action($this->actionIndex)
                ->with('status', "Registro Excluido!");
        } else {
            return redirect()
                ->action($this->actionIndex)
                ->with('warning', "Registro não encontrado.");
        }
    }

    private function validarFormulario(Request $request, $method)
    {
        switch ($method) {
            case 'update':
                $regras = 'required|max:190|min:2';
                break;
            case 'store':
                $regras = 'required|max:190|min:2|unique:cargos,nome';
                break;
        }
        $request->validate(
            [
                'nome' =>  $regras,
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'nome.unique' => 'Este nome já está sendo utilizado.',
            ]
        );
    }
}
