<?php

namespace App\Http\Controllers\Settings;

use App\Models\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class BaseController extends Controller
{
    private $modulo; //id do modulo
    private $paginate;
    private $actionIndex;

    public function __construct()
    {
        $this->modulo = 9; //id do modulo
        $this->paginate = 10;
        $this->actionIndex = 'App\Http\Controllers\Settings\BaseController@index';
    }

    public function index()
    {
        return view('settings.base.index', [
            'collection' => Base::orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo])) {
            return view('settings.base.create');
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request, 'store');
        $base = new Base();
        $base->nome = $request->nome;
        $base->save();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo])) {
            return view('settings.base.edit', ['base' => Base::findOrFail($id)]);
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request, 'update');
        $base = Base::findOrFail($id);
        $base->nome = $request->nome;
        $base->update();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $base = Base::with('colaboradores')->findOrFail($request->id);
        if ($base) {
            if ($base->colaboradores->count() >= 1) {
                return redirect()
                    ->action($this->actionIndex)
                    ->with('warning', "Esta Base está sendo utilizada, por tanto não pode ser excluida.");
            }
            $base->delete();
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
                $regras = 'required|max:190|min:2|unique:bases,nome';
                break;
        }
        $request->validate(
            [
                'nome' => $regras,
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'nome.unique' => 'Este nome já está sendo utilizado.',
            ]
        );
    }
}
