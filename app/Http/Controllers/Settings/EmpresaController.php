<?php

namespace App\Http\Controllers\Settings;

use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class EmpresaController extends Controller
{
    private $modulo; //id do modulo
    private $paginate;
    private $actionIndex;

    public function __construct()
    {
        $this->modulo = 3;
        $this->paginate = 10;
        $this->actionIndex = 'App\Http\Controllers\EmpresaController@index';
    }

    public function index()
    {
        return view('settings.empresa.index', [
            'collection' => Empresa::orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo)
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo])) {
            return view('settings.empresa.create');
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request, 'store');
        if ($this->verificarDuplicidade($request)) {
            return redirect()
                ->action($this->actionIndex)
                ->with('warning', "já existe uma empresa com este nome, ou cnpj!");
        }
        $empresa = new Empresa();
        $empresa->nome = $request->nome;
        $empresa->cnpj = $request->cnpj;
        $empresa->save();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        return view('settings.empresa.show', ['empresa' => Empresa::find($id)]);
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo])) {
            return view('settings.empresa.edit', ['empresa' => Empresa::findOrFail($id)]);
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request, 'update');
        $empresa = Empresa::findOrFail($id);
        $empresa->nome = $request->nome;
        $empresa->cnpj = $request->cnpj;
        $empresa->update();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $empresa = Empresa::with('colaboradores')->findOrFail($request->id);
        if ($empresa->colaboradores->count() >= 1) {
            return redirect()
                ->action($this->actionIndex)
                ->with('warning', "Esta empresa tem colaborador associado, por tanto não pode ser excluida.");
        }
        $empresa->delete();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Excluido!");
    }

    private function validarFormulario(Request $request, $method)
    {
        switch ($method) {
            case 'update':
                $nome = 'required|max:190|min:5';
                $cnpj = 'required|max:20|min:5';
                break;
            case 'store':
                $nome = 'required|max:190|min:5|unique:empresas,nome';
                $cnpj = 'required|max:20|unique:empresas,cnpj';
                break;
        }
        $request->validate(
            [
                'nome' => $nome,
                'cnpj' => $cnpj,
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'cnpj.required' => 'Campo obrigatório.',
                'nome.unique' => 'Esta empresa já está sendo utilizado.',
                'cnpj.unique' => 'Esta cnpj já está sendo utilizado.',
            ]
        );
    }

    private function verificarDuplicidade(Request $request)
    {
        $duplicado = Empresa::where('nome', $request->nome)
            ->orWhere('cnpj', $request->cnpj)
            ->get()->count();
        return $duplicado;
    }
}
